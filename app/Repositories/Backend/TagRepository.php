<?php

namespace App\Repositories\Backend;

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
            $tag = $this->model::create($data);

            return $tag;
        } catch (\Exception $e) {
            die($e->getMessage());

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
     * [getAlltags].
     * @return [array] [All Category ]
     */
    public function getAlltags()
    {
        return $this->model::all();
    }

    /**
     * [DELETE Category].
     * @return [array]
     */
    public function destroy($id)
    {
        $tagDel = $this->model::find($id);

        if ($tagDel) {
            return $tagDel->delete();
        }

        return false;
    }

    public function getTagBySlug($slug = '')
    {
        return $this->model::where('slug', $slug)->first();
    }

    public function editTag($data)
    {
        $tag = $this->model::find($data['id']);
        $update = $tag->update($data);

        return $tag;
    }
}
