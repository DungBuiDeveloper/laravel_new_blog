<?php

namespace App\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\BackEnd\Media;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\MediaLibrary;
use App\Repositories\Backend\MediaRepository;
use App\Http\Requests\BackEnd\MediaLibraryRequest;

class MediaLibraryController extends Controller
{
    public function __construct(MediaRepository $MediaRepository)
    {
        $this->MediaRepository = $MediaRepository;
    }

    /**
     * Return the media library.
     */
    public function index(Request $request)
    {
        return view('backend.media.index');
    }

    public function ajaxDataTable()
    {
        return $this->MediaRepository->getAjaxDataTable();
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $medium): Media
    {
        return $medium;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        return view('backend.media.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediaLibraryRequest $request)
    {
        $files = $request->file('files');

        foreach ($files as $key => $file) {
            $name = $file->getClientOriginalName();

            MediaLibrary::first()
                ->addMedia($file)
                ->usingName($name)
                ->toMediaCollection();
        }

        return response()->json(['success' => true, 'message' => __('media.created'), 'link' => route('admin.media.index')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($medium)
    {
        if ($this->MediaRepository->delete($medium)) {
            return redirect()->route('admin.media.index')->withFlashSuccess(__('media.deleted'));
        }

        return redirect()->route('admin.media.index')->withFlashDanger(__('media.deleted'));
    }

    /**
     * [storeOnlyImage Create Media Image for upload ].
     * @return [object] [Model iamge]
     */
    public function storeOnlyImage(MediaLibraryRequest $request)
    {
        try {
            $file = $request->file('files');
            $name = $file->getClientOriginalName();
            $mediaUpload = MediaLibrary::first()
                ->addMedia($file)
                ->usingName($name)
                ->toMediaCollection();

            return response()->json(['success' => true, 'message' => __('media.created'), 'url_image' => $mediaUpload->getUrl('thumb'), 'id_image' => $mediaUpload->id]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //Upload CkEditor
    public function storeCkEditor(MediaLibraryRequest $request)
    {
        if ($request->hasFile('upload')) {
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            //get Mime Type
            if (isset($_FILES['upload']['tmp_name'])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['upload']['tmp_name']);

                finfo_close($finfo);
            }
            //reg check image mimetype
            $re = '/^[^?]*.(jpg|jpeg|gif|png)/m';
            //Check File is Image
            if ($_GET['type'] == 'image' && preg_match_all($re, $mime, $matches, PREG_SET_ORDER, 0) == 0) {
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '' , 'not image')</script>";

                @header('Content-type: text/html; charset=utf-8');
                echo $response;
                die();
            }
            $reVideo = '/video\/*/';

            if (preg_match_all($reVideo, $mime, $matches, PREG_SET_ORDER, 0) == 1) {
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '' , 'Video let use Embed')</script>";

                @header('Content-type: text/html; charset=utf-8');
                echo $response;
                die();
            }

            $file = $request->file('upload');
            $name = $file->getClientOriginalName();
            $mediaUpload = MediaLibrary::first()
                ->addMedia($file)
                ->usingName($name)
                ->toMediaCollection();

            //if Image Get thumnail preview
            if ($_GET['type'] == 'image') {
                $url = url($mediaUpload->getUrl('thumb'));
            } else {
                $url = $mediaUpload->getUrl();
            }

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
