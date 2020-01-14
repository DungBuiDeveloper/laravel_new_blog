@extends('backend.layouts.app')


@section('content')


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.media.management')
                        <small class="text-muted">@lang('labels.backend.access.media.list')</small>
                    </h4>
                </div>
                <div class="col-sm-4">

                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{Route('admin.media.create')}}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div><!--col-->
            </div>

            <div class="col-sm-12" style="margin-top:20px">
                @include('backend/media/_list')
            </div>
        </div>
    </div>
@endsection
