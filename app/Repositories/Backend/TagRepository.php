<?php

namespace App\Repositories\Backend;

use Cache;
use DataTables;
use App\Models\BackEnd\Tag;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository.
 */
class TagRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param  Tag  $model
     */
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function getAjaxDataTable($search)
    {
        $tag = $this->model->get();

        return Datatables::of($tag)

            ->editColumn('action', function ($tag) {
                $editButton = '<div class="btn-group btn-group-sm"><a
                title="'.__('buttons.general.crud.edit').'"
                href="'.route('admin.tags.showFormEdit', $tag->slug).'"
                class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a>';

                $viewButton = '<a
                    title="'.__('buttons.general.crud.view').'"
                    href="'.route('admin.tags.detail', $tag->slug).'"
                    class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></a>';

                $deleteButton = '<a
                    data-method="delete"
                    data-trans-button-cancel="'.__('buttons.general.cancel').'"
                    data-placement="top"
                    data-toggle="tooltip"
                    href="'.route('admin.tags.destroy', ['id' => $tag->id]).'"
                    data-id="'.$tag->id.'"
                    title="'.__('buttons.general.crud.delete').'"
                    data-original-title="'.__('buttons.general.crud.delete').'"
                    class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> </a></div>';

                return $editButton.$viewButton.$deleteButton;
            })

            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * [storeCategory Save Category].
     * @param  [type] $data [Post Category Data]
     * @return [type]       [true / false Status Save Model]
     */
    public function storeTag($data)
    {
        try {
            $cacheTag = Cache::get('tags', $this->model::all());

            $tagNew = $this->model::create($data);

            $cacheTag[] = $tagNew;

            Cache::forever('tags', $cacheTag);

            return $tagNew;
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
        try {
            return $this->model::select('slug')->where('slug', 'like', $slug.'%')
                ->where('id', '<>', $id)
                ->get();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * [getAlltags].
     * @return [array] [All Category ]
     */
    public function getAlltags()
    {
        try {
            $tag = Cache::rememberForever('tags', function () {
                return $this->model::all();
            });

            return $tag;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * [DELETE Tag].
     */
    public function destroy($id)
    {
        try {
            $deleteTag = $this->model::find($id);

            $cacheTag = Cache::get('tags', null);

            if ($deleteTag) {
                if ($cacheTag) {
                    foreach ($cacheTag as $key => $tag) {
                        if ($tag->id == $id) {
                            unset($cacheTag[$key]);
                            Cache::forever('tags', $cacheTag);
                        }
                    }
                }
                return $deleteTag->delete();
            }
            return false;

        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * [getTagBySlug get Detail Tag By Slug].
     * @param  string $slug [description]
     * @return array
     */
    public function getTagBySlug($slug = '')
    {
        try {
            return $this->model::where('slug', $slug)->first();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * [editTag Edit Tag].
     * @param  array $data [data for edit Tag]
     * @return array
     */
    public function editTag($data)
    {
        try {
            $tagEdit = $this->model::find($data['id']);
            $update = $tagEdit->update($data);

            if ($update) {
                $cacheTag = Cache::get('tags', null);

                if ($cacheTag) {
                    foreach ($cacheTag as $key => $tag) {
                        if ($tag->id == $data['id']) {
                            $cacheTag[$key] = $tagEdit;

                            Cache::forever('tags', $cacheTag);
                        }
                    }
                }

                return $tagEdit;
            }

            return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
