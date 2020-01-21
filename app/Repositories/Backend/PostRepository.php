<?php

namespace App\Repositories\Backend;

use DataTables;
use App\Models\BackEnd\Post;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository.
 */
class PostRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param  Post  $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function test()
    {
        return $this->model::with('categories')->with('getThumbnail')->get();
    }

    /**
     * [getAjaxDataTable Ajax DataTable].
     * @param  [string] $search [Search Text]
     * @return [array]         [data Posts for datatable load]
     */
    public function getAjaxDataTable($search)
    {
        $post = $this->model->get();

        return Datatables::of($post)

            ->editColumn('action', function ($post) {
                $editButton = '<div class="btn-group btn-group-sm"><a
                title="'.__('buttons.general.crud.edit').'"
                href="'.route('admin.Posts.showFormEdit', $post->slug).'"
                class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a>';

                $viewButton = '<a
                    title="'.__('buttons.general.crud.view').'"
                    href="'.route('admin.Posts.detail', $post->slug).'"
                    class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></a>';

                $deleteButton = '<a
                    data-method="delete"
                    data-trans-button-cancel="'.__('buttons.general.cancel').'"
                    data-placement="top"
                    data-toggle="tooltip"
                    href="'.route('admin.Posts.destroy', ['id' => $post->id]).'"
                    data-id="'.$post->id.'"
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
    public function storePost($data)
    {
        try {
            $postNew = $this->model::create($data);

            if ($postNew) {
                if (isset($data['cat_id'])) {
                    $postNew->categories()->attach($data['cat_id']);
                }
                if (isset($data['tag_id'])) {
                    $postNew->tags()->attach($data['tag_id']);
                }
            }
            
            return $postNew;
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
     * [getAllPosts].
     * @return [array] [All Category ]
     */
    public function getAllPosts()
    {
        return $this->model::all();
    }

    /**
     * [DELETE Category].
     * @return [array]
     */
    public function destroy($id)
    {
        $postDel = $this->model::find($id);

        if ($postDel) {
            return $postDel->delete();
        }

        return false;
    }

    public function getPostBySlug($slug = '')
    {
        return $this->model::where('slug', $slug)->first();
    }

    public function editPost($data)
    {
        $post = $this->model::find($data['id']);
        $update = $post->update($data);

        return $post;
    }
}
