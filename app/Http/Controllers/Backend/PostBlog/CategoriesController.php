<?php

namespace App\Http\Controllers\Backend\PostBlog;

use DataTables;
use App\Models\BackEnd\Category;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\CategoryRepository;
use App\Http\Requests\Backend\PostBlog\CategoryRequest;

class CategoriesController extends Controller
{
    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function ajaxDataTable($value = '')
    {
        if ($_POST['search']['value'] !== '') {
            dd($_POST['search']['value']);
        }

        return datatables()->of(Category::all())
            ->editColumn('action', function ($category) {
                return '<a href="'.route('admin.categories.showFormEdit', $category->id).'" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> View</a> <a href="javascript:void(0)" data-id="'.$category->id.'" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-times"></i> Delete</a>';
            })
            ->rawColumns(['action'])
            ->toJson();
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
        for ($i = 1; $i <= 10; $i++) {
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

        return redirect()->route('admin.categories.list')->withFlashSuccess(__('alerts.backend.roles.created'));
    }

    /**
     * [showFormEdit show Form Edit].
     * @param  string $slug [Unique String Get Category]
     * @return [type] [Return View Edit form]
     */
    public function showFormEdit($slug = '')
    {
        dd($slug);
    }

    /**
     * [editCategory Put Category].
     */
    public function editCategory()
    {
        // code...
    }

    /**
     * [destroy Delete Category].
     * @param  string $id [Get Category]
     */
    public function destroy($id = '')
    {
        // code...
    }
}
