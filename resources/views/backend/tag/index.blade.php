@extends('backend.layouts.general')

@section('title', __('labels.backend.access.tag.management') . ' | ' . __('labels.backend.access.users.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.tag.management')
                        <small class="text-muted">@lang('labels.backend.access.tag.list')</small>
                    </h4>
                </div>
                <div class="col-sm-7">

                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{Route('admin.tags.showFormAdd')}}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div><!--col-->
            </div>

            <div class="col-sm-12" style="margin-top:20px">
              <table id="tag_table" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>@lang('labels.backend.access.tag.table.name')</th>
                    <th>@lang('labels.backend.access.tag.table.slug')</th>
                    <th>@lang('labels.backend.access.tag.table.created_at')</th>
                    <th>@lang('labels.backend.access.tag.table.updated_at')</th>
                    <th>@lang('labels.backend.access.tag.table.action')</th>
                  </tr>
                </thead>
              </table>
            </div>


        </div>
    </div>
@endsection
