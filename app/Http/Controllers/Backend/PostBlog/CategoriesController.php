<?php

namespace App\Http\Controllers\Backend\PostBlog;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\CategoryRepository;
use App\Http\Requests\Backend\PostBlog\CategoryRequest;

class CategoriesController extends Controller
{
    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function ajaxDataTable()
    {
        return $this->CategoryRepository->getAjaxDataTable(null);
    }

    public function index()
    {
        return view('backend/category/index');
    }

    /**
     * [showFormAdd Show Form].
     * @return [Layout] [Return View Add form]
     */
    public function showFormAdd()
    {
        $categories = $this->CategoryRepository->getAllCategories();

        return view('backend/category/add')->withCategories($categories);
    }

    /**
     * [createSlug Generate Unique slug category].
     * @param  [String]  $name [name category]
     * @param  int $id    [id when edit]
     * @return [String]         [unique slug]
     */
    public function createSlug($name, $id = 0)
    {
        // Normalize the title
        $slug = \Str::slug($name);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->CategoryRepository->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 20; $i++) {
            $newSlug = $slug.'-'.$i;

            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    /**
     * [storeCategory Save Category].
     */
    public function storeCategory(CategoryRequest $request)
    {
        $data = $request->All();
        $data['slug'] = $this->createSlug($data['name']);

        $save = $this->CategoryRepository->storeCategory($data);

        if (! $save->id) {
            \App::abort(500, 'Some Error');
        }

        return redirect()->route('admin.categories.list')->withFlashSuccess(__('alerts.backend.category.created'));
    }

    /**
     * [showFormEdit show Form Edit].
     * @param  string $slug [Unique String Get Category]
     * @return [type] [Return View Edit form]
     */
    public function showFormEdit($slug = '')
    {
        $category = $this->CategoryRepository->getCategoryBySlug($slug);
        $categories = $this->CategoryRepository->getAllCategories();
        $oldCatId = [];
        foreach ($category['parentOf'] as $key => $value) {
            $oldCatId[] = $value['id'];
        }

        return view('backend/category/edit')
            ->withCategories($categories)
            ->withCategory($category)
            ->withOldCategories($oldCatId);
    }

    /**
     * [editCategory Put Category].
     */
    public function editCategory(CategoryRequest $request)
    {
        $data = $request->all();
        $edit = $this->CategoryRepository->editCategory($data);

        if (! $edit->id) {
            \App::abort(500, 'Some Error');
        }

        return redirect()->route('admin.categories.list')->withFlashSuccess(__('alerts.backend.category.created'));
    }

    /**
     * [destroy Delete Category].
     * @param  string $id [Get Category]
     */
    public function destroy()
    {
        $delete = $this->CategoryRepository->destroy($_GET['id']);

        if ($delete) {
            return redirect()->route('admin.categories.list')->withFlashSuccess(__('alerts.backend.category.created'));
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
        $category = $this->CategoryRepository->getCategoryBySlug($slug);

        return view('backend/category/detail')->withCategory($category);
    }
}
