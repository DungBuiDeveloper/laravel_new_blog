<?php

namespace App\Repositories\Backend;

use DataTables;
use App\Models\BackEnd\Category;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository.
 */
class CategoryRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param  Category  $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAjaxDataTable($search)
    {
        $category = $this->model::with('parentOf')->get();

        return Datatables::of($category)

            ->editColumn('action', function ($category) {
                $editButton = '<div class="btn-group btn-group-sm"><a
                title="'.__('buttons.general.crud.edit').'"
                href="'.route('admin.categories.showFormEdit', $category->slug).'"
                class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a>';

                $viewButton = '<a
                    title="'.__('buttons.general.crud.view').'"
                    href="'.route('admin.categories.detail', $category->slug).'"
                    class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></a>';

                $deleteButton = '<a
                    data-method="delete"
                    data-trans-button-cancel="'.__('buttons.general.cancel').'"
                    data-placement="top"
                    data-toggle="tooltip"
                    href="'.route('admin.categories.destroy', ['id' => $category->id]).'"
                    data-id="'.$category->id.'"
                    title="'.__('buttons.general.crud.delete').'"
                    data-original-title="'.__('buttons.general.crud.delete').'"
                    class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> </a></div>';

                return $editButton.$viewButton.$deleteButton;
            })

            ->editColumn('parent_of', function ($category) {
                $nameParent = '';
                foreach ($category->parentOf as $key => $value) {
                    $nameParent = $nameParent.','.$value->slug;
                }

                if (substr($nameParent, 1)) {
                    return substr($nameParent, 1);
                }

                return '';
            })

            ->rawColumns(['action', 'parent_of'])
            ->toJson();
    }

    /**
     * [storeCategory Save Category].
     * @param  [type] $data [Post Category Data]
     * @return [type]       [true / false Status Save Model]
     */
    public function storeCategory($data)
    {
        try {
            $category = $this->model::create($data);

            if (isset($data['parent_id'])) {
                $category->parentOf()->attach($data['parent_id']);
            }

            return $category;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * [getRelatedSlugs Relate Slug].
     * @param  [type]  $slug [Condition]
     * @param  int $id   [Use when edit]
     * @return [string]        [unique slug]
     */
    public function getRelatedSlugs($slug, $id = 0)
    {
        return $this->model::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }

    /**
     * [getAllCategories].
     * @return [array] [All Category ]
     */
    public function getAllCategories()
    {
        return $this->model::all();
    }

    /**
     * [DELETE Category].
     * @return [array]
     */
    public function destroy($id)
    {
        $deleteCat = $this->model::find($id);

        if ($deleteCat) {
            return $deleteCat->delete();
        }

        return false;
    }

    public function getCategoryBySlug($slug = '')
    {
        return $this->model::where('slug', $slug)->with('parentOf')->first();
    }

    public function editCategory($data)
    {
        $cate = $this->model::find($data['id']);
        $update = $cate->update($data);

        if (isset($data['parent_id'])) {
            $cate->parentOf()->sync($data['parent_id']);
        }

        return $cate;
    }
}
