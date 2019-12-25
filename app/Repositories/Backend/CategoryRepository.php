<?php

namespace App\Repositories\Backend;

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
     * [getCategoryPagi Get Data Category pagination].
     * @return [array]
     */
    public function getCategoryPagi()
    {
        // code...
    }
}
