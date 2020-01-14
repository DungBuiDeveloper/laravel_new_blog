@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <textarea name="content" id="editor">
                &lt;p&gt;This is some sample content.&lt;/p&gt;
            </textarea>

            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    {!! __('strings.backend.welcome') !!}

                </div><!--card-body-->



                <div class="card-footer">
                    ád
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

<style>
.ck-editor__editable_inline {
    min-height: 400px;
}
</style>
