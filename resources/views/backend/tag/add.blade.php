@extends('backend.layouts.general')
@section('title', __('labels.backend.access.tag.management') . ' | ' . __('labels.backend.access.tag.edit'))
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.tag.management')
                        <small class="text-muted">@lang('labels.backend.access.tag.create')</small>
                    </h4>
                </div><!--col-->
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-sm-12">
                    <form id="tag_add_edit" method="POST" action={{route('admin.tags.add')}}>
                        @csrf
                        <div class="form-group">
                            <label for="tag_name">@lang('labels.backend.access.tag.table.name')</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="@lang('labels.backend.access.tag.table.name')" value="{{ old('username') }}">

                        </div>

                        @error('tag_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror



                        <button type="submit" class="btn btn-primary">@lang('buttons.general.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
