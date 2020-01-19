@extends('backend.layouts.general')
@section('title', __('labels.backend.access.category.management') . ' | ' . __('labels.backend.access.category.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.category.management')
                        <small class="text-muted">@lang('labels.backend.access.category.create')</small>
                    </h4>
                </div><!--col-->
                <div class="col-sm-12">
                    <form id="category_add" method="POST" action={{route('admin.categories.add')}}>
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('labels.backend.access.category.table.name')</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="@lang('labels.backend.access.category.table.name')" value="{{ old('name') }}">

                        </div>

                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        @if (sizeof($categories) > 0)
                            <div class="form-group">
                                <label for="parent_id">@lang('labels.backend.access.category.table.parent_of')</label>
                                <select
                                    title="@lang('labels.backend.access.category.table.parent_of')"
                                    data-live-search="true"
                                    multiple
                                    class="form-control selectpicker" id="parent_id"
                                    name="parent_id[]">
                                    @foreach ($categories as $key => $category)
                                        <option value="{{$category->id}}">name:{{$category->name}} - slug: {{$category->slug}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">@lang('buttons.general.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
