@extends('backend.layouts.general')

@section('title', __('labels.backend.access.post.management') . ' | ' . __('labels.backend.access.post.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.post.management')
                        <small class="text-muted">@lang('labels.backend.access.post.edit')</small>
                    </h4>
                </div><!--col-->
                <div class="col-sm-12">
                    <form method="POST" action={{route('admin.posts.edit')}}>
                        @csrf
                        <input
                            type="hidden"
                            class="form-control"
                            name="id"
                            value="{{$post->id}}"
                            >
                        <div class="form-group">
                            <label for="post_name">@lang('labels.backend.access.post.table.name')</label>
                            <input
                                type="text"
                                class="form-control"
                                id="post_name"
                                name="post_name"
                                value="{{$post->post_name}}"
                                placeholder="@lang('labels.backend.access.post.table.name')">

                        </div>





                        <button type="submit" class="btn btn-primary">@lang('buttons.general.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
