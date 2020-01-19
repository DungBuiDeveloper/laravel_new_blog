@extends('backend.layouts.general')

@section('title', __('labels.backend.access.category.management') . ' | ' . __('labels.backend.access.category.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.category.management')
                        <small class="text-muted">@lang('labels.backend.access.category.edit')</small>
                    </h4>
                </div><!--col-->
                <div class="col-sm-12">
                    <form method="POST" action={{route('admin.categories.edit')}}>
                        @csrf
                        <input
                            type="hidden"
                            class="form-control"
                            name="id"
                            value="{{$category->id}}"
                            >
                        <div class="form-group">
                            <label for="name">@lang('labels.backend.access.category.table.name')</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{$category->name}}"
                                placeholder="@lang('labels.backend.access.category.table.name')">

                        </div>
                        @if (sizeof($categories) > 0)
                            <div class="form-group">
                                <label for="parent_id">@lang('labels.backend.access.category.table.parent_of')</label>
                                <select
                                    title="@lang('labels.backend.access.category.table.parent_of')"
                                    data-live-search="true"
                                    multiple
                                    class="form-control selectpicker" id="parent_id"
                                    name="parent_id[]">
                                    @foreach ($categories as $key => $cat)
                                        @if ($cat->id !== $category->id)
                                            <option
                                                {{ in_array($cat->id, $oldCategories) ? 'selected' : null }}
                                                value="{{$cat->id}}">name:{{$cat->name}} - slug: {{$cat->slug}}
                                            </option>
                                        @endif

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
