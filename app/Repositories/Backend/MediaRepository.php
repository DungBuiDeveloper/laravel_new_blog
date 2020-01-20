<?php

namespace App\Repositories\Backend;

use DataTables;
use App\Models\BackEnd\Media;
use App\Models\BackEnd\Category;
use App\Models\BackEnd\MediaLibrary;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository.
 */
class MediaRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param  Category  $model
     */
    public function __construct(MediaLibrary $model, Media $model_media)
    {
        $this->model = $model;
        $this->model_media = $model_media;
    }

    /**
     * [getMediaManager Show Data for admin chose image].
     * @return [type]       [description]
     */
    public function getMediaManager()
    {
        return $this->model::first()->media()->where('mime_type', 'LIKE', 'image/%')->paginate(20)->appends(['type' => 'media']);
    }

    public function getAjaxDataTable()
    {
        $media = $this->model::first()->media()->get();
        $json = Datatables::of($media)

            ->editColumn('action', function ($media) {
                $viewButton = '<div class="btn-group btn-group-sm"><a
                target="_blank"
                title="'.__('buttons.general.crud.detail').'"
                href="'.$media->getUrl().'"
                class="btn btn-xs btn-primary"><i class="fas fa-eye"></i></a>';

                $downButton = '<a
                    title="'.__('buttons.general.crud.view').'"
                    href="'.route('admin.media.show', $media).'"
                    class="btn btn-xs btn-warning"><i class="fa fa-download" aria-hidden="true"></i></a>';

                $deleteButton = '<a
                    data-method="delete"
                    data-trans-button-cancel="'.__('buttons.general.cancel').'"
                    data-placement="top"
                    data-toggle="tooltip"
                    href="'.route('admin.media.destroy', ['medium' => $media]).'"
                    data-id="'.$media->id.'"
                    title="'.__('buttons.general.crud.delete').'"
                    data-original-title="'.__('buttons.general.crud.delete').'"
                    class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> </a></div>';

                return $viewButton.$downButton.$deleteButton;
            })
            ->editColumn('url', function ($media) {
                $copy = '<div class="btn-group-sm input-group">
                    <input style="width:calc( 100% - 38px )" class="form-control" id="'.'copy_url'.$media->id.'" type="text" value="'.env('APP_URL', false).$media->getUrl().'" />

                    <a  class="btn btn-primary btn-xs input-group-append click-copy-url" id="'.'copy_clipboard'.$media->id.'" data-id_media="'.$media->id.'" href="javascript:;">
                        <i style="font-size:20px;" class="fa fa-copy d-flex"></i>
                    </a>
                </div>';

                return $copy;
            })
            ->editColumn('thumb', function ($media) {
                $thumb = '';

                if (strstr($media->mime_type, 'image')) {
                    $thumb = '<a href="'.$media->getUrl().'" target="_blank">'.'<img  src="'.$media->getUrl('small').'" alt="'.$media->name.'" class="rounded">'.'</a>';
                } else {
                    $thumb = '<a class="btn " href="'.$media->getUrl().'" target="_blank"><i style="font-size: 25px;color:#20a8d8;" class="fa fa-file"></i></a>';
                }

                return $thumb;
            })

            ->rawColumns(['url', 'thumb', 'action'])
            ->toJson();

        return $json;
    }

    public function download($id)
    {
        $mediaItem = $this->model_media::find($id);

        if (copy($mediaItem->getPath(), $mediaItem->file_name)) {
            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $mediaItem = $this->model_media::find($id)->delete();

        if ($mediaItem) {
            return true;
        }

        return false;
    }
}
