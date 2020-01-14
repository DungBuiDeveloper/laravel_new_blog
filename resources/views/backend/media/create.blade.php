@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.media.management')
                        <small class="text-muted">@lang('labels.backend.access.media.create')</small>
                    </h4>
                </div><!--col-->
                <div class="col-sm-12 mt-3">



                    <form id="media-dropzone"   action={{route('admin.media.store')}} method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">@lang('labels.backend.access.media.table.file')</label>
                            <div class="dz-clickable dz-message dz-preview dz-image-preview needsclick">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                                <div class="dropzone-previews dropzone"></div>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-primary">@lang('buttons.general.submit')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
