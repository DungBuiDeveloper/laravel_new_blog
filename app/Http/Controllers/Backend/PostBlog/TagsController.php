<?php

namespace App\Http\Controllers\Backend\PostBlog;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\TagRepository;
use App\Http\Requests\Backend\PostBlog\TagRequest;

class TagsController extends Controller
{
    public function __construct(TagRepository $TagRepository)
    {
        $this->TagRepository = $TagRepository;
    }

    public function ajaxDataTable()
    {
        return $this->TagRepository->getAjaxDataTable(null);
    }

    public function index()
    {
        return view('backend/tag/index');
    }

    /**
     * [showFormAdd Show Form].
     * @return [Layout] [Return View Add form]
     */
    public function showFormAdd()
    {
        return view('backend/tag/add');
    }

    /**
     * [createSlug Generate Unique slug tag].
     * @param  [String]  $name [name tag]
     * @param  int $id    [id when edit]
     * @return [String]         [unique slug]
     */
    public function createSlug($name, $id = 0)
    {
        // Normalize the title
        $slug = \Str::slug($name);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->TagRepository->getRelatedSlugs($slug, $id);
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
     * [storetag Save tag].
     */
    public function storetag(tagRequest $request)
    {
        $data = $request->All();
        $data['slug'] = $this->createSlug($data['tag_name']);

        $save = $this->TagRepository->storeTag($data);

        if (! $save->id) {
            \App::abort(500);
        }

        return redirect()->route('admin.tags.list')->withFlashSuccess(__('alerts.backend.tag.created'));
    }

    /**
     * [showFormEdit show Form Edit].
     * @param  string $slug [Unique String Get Tag]
     * @return [type] [Return View Edit form]
     */
    public function showFormEdit($slug = '')
    {
        $Tag = $this->TagRepository->getTagBySlug($slug);

        if (!$Tag) {
            \App::abort(404);
        }
        return view('backend/Tag/edit')
            ->withTag($Tag);
    }

    /**
     * [editCategory Put Category].
     */
    public function editTag(TagRequest $request)
    {
        $data = $request->all();
        $edit = $this->TagRepository->editTag($data);

        if (! $edit->id) {
            \App::abort(500);
        }

        return redirect()->route('admin.tags.list')->withFlashSuccess(__('alerts.backend.tag.created'));
    }

    /**
     * [destroy Delete Tag].
     * @param  string $id [Get Tag]
     */
    public function destroy()
    {
        $delete = $this->TagRepository->destroy($_GET['id']);

        if ($delete) {
            return redirect()->route('admin.tags.list')->withFlashSuccess(__('alerts.backend.tag.deleted'));
        }
        \App::abort(500);
    }

    /**
     * [detail show category detail].
     * @param  [string] $slug [unique condition for get category]
     * @return [Object]       [Category Detail]
     */
    public function detail($slug)
    {
        $tag = $this->TagRepository->getTagBySlug($slug);

        return view('backend/tag/detail')->withTag($tag);
    }
}
