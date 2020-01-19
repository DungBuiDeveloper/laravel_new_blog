@extends('backend.layouts.general')

@section('title', __('labels.backend.access.category.management') . ' | ' . __('labels.backend.access.users.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.category.management')
                        <small class="text-muted">@lang('labels.backend.access.category.list')</small>
                    </h4>
                </div>
                <div class="col-sm-7">

                    <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
                        <a href="{{Route('admin.categories.showFormAdd')}}" class="btn btn-success ml-1" data-toggle="tooltip" title="@lang('labels.general.create_new')"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div><!--col-->
            </div>

            <div class="col-sm-12" style="margin-top:20px">
              <table id="category_table" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>@lang('labels.backend.access.category.table.name')</th>
                    <th>@lang('labels.backend.access.category.table.slug')</th>
                    <th>@lang('labels.backend.access.category.table.created_at')</th>
                    <th>@lang('labels.backend.access.category.table.updated_at')</th>
                    <th>@lang('labels.backend.access.category.table.parent_of')</th>
                    <th>@lang('labels.backend.access.category.table.action')</th>
                  </tr>
                </thead>
              </table>
            </div>


        </div>
    </div>
@endsection
