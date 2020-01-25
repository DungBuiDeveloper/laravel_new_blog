<?php

namespace App\Repositories\Backend;

use DataTables;
use App\Models\BackEnd\Post;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
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

    // public function test()
    // {
    //     return $this->model::with('categories')->with('getThumbnail')->get();
    // }

    /**
     * [getAjaxDataTable Ajax DataTable].
     * @return [array]         [data Posts for datatable load]
     */
    public function getAjaxDataTable()
    {
        try {

            $post = $this->model::select('id','thumbnail','type_thumb','title','slug','created_at','updated_at','video')->with('getThumbnail')->get();

            return Datatables::of($post)
                ->editColumn('thumbnail', function ($post) {
                    $idTable = '#post_table_'.$post["id"];
                    if (  isset($post['thumbnail']) || isset($post['video'])) {
                        if ($post['type_thumb'] == 'image') {
                            $media = '<script>
                                    var media = window.convertMedia("'.env('APP_URL').$post->getThumbnail->getUrl('thumb').'",false);

                                    $("'.$idTable.'").find("td").eq(2).html(media);
                                    $("'.$idTable.'").find("td").eq(2).find("img").width("auto").height(50);

                                    $("'.$idTable.'").find("td").eq(2).find("a").fancybox();

                                </script>';
                            return $media;
                        }
                        else {
                            $media = '<script>
                                    var video = `<a class="various fancybox fancybox.iframe" href="'.$post['video'].'">Video</a>`;


                                    $("'.$idTable.'").find("td").eq(2).html(video);
                                    $("'.$idTable.'").find("td").eq(2).find("a").fancybox();


                                </script>';
                            return $media;

                        }

                    }else {
                        return  '<img src="https://fakeimg.pl/50x50/?text=No Image">';
                    }
                })

                ->setRowId(function ($post) {
                    return 'post_table_'.$post->id;
                })
                ->editColumn('action', function ($post) {
                    $editButton = '<div class="btn-group btn-group-sm"><a
                    title="'.__('buttons.general.crud.edit').'"
                    href="'.route('admin.posts.showFormEdit', $post->slug).'"
                    class="btn btn-xs btn-primary"><i class="fas fa-edit"></i></a>';

                    $viewButton = '<a
                        title="'.__('buttons.general.crud.view').'"
                        href="'.route('admin.posts.detail', $post->slug).'"
                        class="btn btn-xs btn-warning"><i class="fas fa-eye"></i></a>';

                    $deleteButton = '<a
                        data-method="delete"
                        data-trans-button-cancel="'.__('buttons.general.cancel').'"
                        data-placement="top"
                        data-toggle="tooltip"
                        href="'.route('admin.posts.destroy', ['id' => $post->id]).'"
                        data-id="'.$post->id.'"
                        title="'.__('buttons.general.crud.delete').'"
                        data-original-title="'.__('buttons.general.crud.delete').'"
                        class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> </a></div>';

                    return $editButton.$viewButton.$deleteButton;
                })

                ->rawColumns(['thumbnail','action'])
                ->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }

    /**
     * [storeCategory Save Category].
     * @param  [type] $data [Post Category Data]
     * @return [type]       [true / false Status Save Model]
     */
    public function storePost($data)
    {
        try {
            $dataReturn = DB::transaction(function () use ($data) {

                $postNew = $this->model::create($data);

                if ($postNew) {
                    //Add Category
                    if (isset($data['cat_id'])) {
                        $postNew->categories()->attach($data['cat_id']);
                    }
                    //Add Tag
                    if (isset($data['tag_id'])) {
                        $postNew->tags()->attach($data['tag_id']);
                    }
                }

                return $postNew;
            });

            return $dataReturn;

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
     * [getAllPosts].
     * @return [array] [All Category ]
     */
    public function getAllPosts()
    {
        try {
            return $this->model::all();
        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }

    /**
     * [DELETE Category].
     * @return [array]
     */
    public function destroy($id)
    {

        try {
            $postDel = $this->model::find($id);

            if ($postDel) {
                return $postDel->delete();
            }

            return false;
        } catch (\Exception $e) {

            return $e->getMessage();
        }


    }

    public function getPostBySlug($slug = '')
    {
        try {
            return $this->model::where('slug', $slug)->with('categories')->with('tags')->with('getThumbnail')->first();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function editPost($data)
    {
        try {



            $postEdit = $this->model::find($data['id']);

            if (!$postEdit) {
                return false;
            }

            $dataReturn = DB::transaction(function () use ($data , $postEdit) {
                $update = $postEdit->update($data);

                if (isset($data['cat_id'])) {
                    $postEdit->categories()->sync($data['cat_id']);
                }
                if (isset($data['tag_id'])) {
                    $postEdit->tags()->sync($data['tag_id']);
                }
                return $postEdit;

            });

            return $dataReturn;


        } catch (\Exception $e) {
            dd($e->getMessage());
            return $e->getMessage();
        }


    }
}
