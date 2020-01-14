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
}