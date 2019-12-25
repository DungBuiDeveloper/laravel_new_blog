@extends('backend.layouts.app')
@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-primary float-right" href="{{Route('admin.categories.showFormAdd')}}">Add Category</a>
                </div><!--col-->
            </div>

            <div class="col-sm-12" style="margin-top:20px">
              <table id="demo_table" class="table" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>


        </div>
    </div>
@endsection
