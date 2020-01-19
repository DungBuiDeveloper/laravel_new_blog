@extends('backend.layouts.general')
@section('title', __('labels.backend.access.post.management') . ' | ' . __('labels.backend.access.post.edit'))
@section('content')
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.post.management')
                        <small class="text-muted">@lang('labels.backend.access.post.create')</small>
                    </h4>
                </div><!--col-->
            </div>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-sm-12">
                    <form id="post_add_edit" method="POST" action={{route('admin.posts.add')}} enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="post_name">@lang('labels.backend.access.post.table.title')</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="@lang('labels.backend.access.post.table.title')" value="{{ old('title') }}">

                        </div>

                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror


                        <div class="form-group">
                            <label for="post_name">@lang('labels.backend.access.post.table.the_excerpt')</label>
                            <textarea type="text" class="form-control" id="the_excerpt" name="the_excerpt" placeholder="@lang('labels.backend.access.post.table.the_excerpt')" value="{{ old('the_excerpt') }}"></textarea>

                        </div>

                        @error('the_excerpt')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror


                        @if (sizeof($categories) > 0)
                            <div class="form-group">
                                <label for="cat_id">@lang('labels.backend.access.category.table.parent_of')</label>
                                <select
                                    title="@lang('labels.backend.access.category.table.parent_of')"
                                    data-live-search="true"
                                    multiple
                                    class="form-control selectpicker" id="cat_id"
                                    name="cat_id[]">
                                    @foreach ($categories as $key => $category)
                                        <option value="{{$category->id}}">name:{{$category->name}} - slug: {{$category->slug}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif




                        <div class="form-group">
                            <label for="thumbnail">@lang('labels.backend.access.post.table.thumbnail')</label>
                            <input type="hidden" class="form-control" id="thumbnail" name="thumbnail" placeholder="@lang('labels.backend.access.post.table.thumbnail')" value="{{ old('thumbnail') }}">
                            <div class="dz-clickable dz-message dz-preview dz-image-preview needsclick">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                                <div class="dropzone-previews dropzone"></div>
                            </div>

                            <div>
                                <a href="javascript:;" type="button"  data-toggle="modal" data-target="#imagelistModal">
                                    @lang('labels.backend.access.post.thumbnailTitle')
                                </a>
                            </div>

                            <div class="preview_image"></div>
                        </div>






                        <div class="form-group">
                            <label for="editor">@lang('labels.backend.access.post.table.content')</label>
                            <textarea name="content" id="editor">
                                &lt;p&gt;This is some sample content.&lt;/p&gt;
                            </textarea>
                        </div>


                        <button type="submit" class="btn btn-primary">@lang('buttons.general.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="list-image-modal">
        <div class="modal fade" id="imagelistModal" tabindex="-1" role="dialog" aria-labelledby="imagelistModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imagelistModalLabel">@lang('labels.backend.access.post.modal_title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                @include('backend.includes.modal_list_image')
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('buttons.general.cancel')</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    {{-- List Image Modal --}}

<style>

    .cke_dialog_ui_input_file {
        height: 1000px;
    }
</style>

@endsection
