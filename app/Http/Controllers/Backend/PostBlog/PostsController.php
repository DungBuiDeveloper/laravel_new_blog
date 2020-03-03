<?php

namespace App\Http\Controllers\Backend\PostBlog;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\PostRepository;
use App\Repositories\Backend\MediaRepository;
use App\Repositories\Backend\CategoryRepository;
use App\Repositories\Backend\TagRepository;
use App\Http\Requests\Backend\PostBlog\PostRequest;


class PostsController extends Controller
{
    public function __construct(
        PostRepository $PostRepository,
        MediaRepository $MediaRepository,
        TagRepository $TagRepository,
        CategoryRepository $CategoryRepository)
    {
        $this->PostRepository = $PostRepository;
        $this->MediaRepository = $MediaRepository;
        $this->TagRepository = $TagRepository;
        $this->CategoryRepository = $CategoryRepository;
    }
    /**
     * [ajaxDataTable Get Data Ajax Table]
     * @return array [post data]
     */
    public function ajaxDataTable() {
        return $this->PostRepository->getAjaxDataTable();
    }
    /**
     * [index Show list view]
     */
    public function index()
    {
        return view('backend/post/index');
    }

    /**
     * [showFormAdd Show Form].
     * @return [Layout] [Return View Add form]
     */
    public function showFormAdd(PostRequest $request)
    {

        // Init Data Post
        $allImage = $this->MediaRepository->getMediaManager();
        $categories = $this->CategoryRepository->getAllCategories();
        $tags = $this->TagRepository->getAllTags();
        // Ajax Return View Data
        if ($request->ajax()) {
            return view('backend/includes/modal_list_image')->withAllImage($allImage);
        }

        return view('backend/post/add')
            ->withAllImage($allImage)
            ->withTags($tags)
            ->withCategories($categories);
    }

    /**
     * [createSlug Generate Unique slug Post].
     * @param  [String]  $name [name Post]
     * @param  int $id    [id when edit]
     * @return [String]         [unique slug]
     */
    public function createSlug($name, $id = 0)
    {
        // Normalize the title
        $slug = \Str::slug($name);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->PostRepository->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;

            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    /**
     * [storePost Save Post].
     */
    public function storePost(PostRequest $request)
    {
        $data = $request->All();

        $data['slug'] = $this->createSlug($data['title']);
        $data['author_id'] = auth()->user()->id;


        $save = $this->PostRepository->storePost($data);

        if (isset($save->id) == false) {

            \App::abort(500);
        }


        return redirect()->route('admin.posts.list')->withFlashSuccess(__('alerts.backend.post.created'));
    }

    /**
     * [showFormEdit show Form Edit].
     * @param  string $slug [Unique String Get Post]
     * @return [type] [Return View Edit form]
     */
    public function showFormEdit($slug = '')
    {
        //Check Post By Slug
        $Post = $this->PostRepository->getPostBySlug($slug);

        if ($Post == null) {
            \App::abort(404);
        }

        // Init Data Post
        $allImage = $this->MediaRepository->getMediaManager();
        $categories = $this->CategoryRepository->getAllCategories();
        $tags = $this->TagRepository->getAllTags();
        $oldCatId = [];
        $oldTagId = [];

        if (sizeof($Post['categories'])) {
            foreach ($Post['categories'] as $key => $value) {
                $oldCatId[] = $value['id'];
            }
        }

        if (sizeof($Post['tags'])) {
            foreach ($Post['tags'] as $key => $value) {
                $oldTagId[] = $value['id'];
            }
        }


        return view('backend/post/edit')
            ->withAllImage($allImage)
            ->withTags($tags)
            ->withPost($Post)
            ->withOldCategories($oldCatId)
            ->withOldTags($oldTagId)
            ->withCategories($categories);

    }

    /**
     * [editCategory Put Category].
     */
    public function editPost(PostRequest $request)
    {
        $data = $request->all();

        $edit = $this->PostRepository->editPost($data);

        if (! $edit->id) {
            \App::abort(500, 'Some Error');
        }

        return redirect()->route('admin.posts.list')->withFlashSuccess(__('alerts.backend.post.updated'));
    }

    /**
     * [destroy Delete Post].
     * @param  string $id [Get Post]
     */
    public function destroy()
    {
        $delete = $this->PostRepository->destroy($_GET['id']);

        if ($delete) {
            return redirect()->route('admin.posts.list')->withFlashSuccess(__('alerts.backend.post.deleted'));
        }
        \App::abort(500, 'Some Error');
    }

    /**
     * [detail show category detail].
     * @param  [string] $slug [unique condition for get category]
     * @return [Object]       [Category Detail]
     */
    public function detail($slug)
    {
        $post = $this->PostRepository->getPostBySlug($slug);
        if (!$post) {
            \App::abort(404);
        }
        return view('backend/post/detail')->withPost($post);
    }
}
