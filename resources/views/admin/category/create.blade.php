@extends('layouts.manage')

@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Thêm mới
                            <small>Danh mục</small>
                        </h1>
                    </div>
                    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Tên danh mục...">
        </div>
        <div class="form-group">
            <input type="file" name="category_image" id="category_image" class="form-control" placeholder="Hình ảnh">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Thêm</button>
    </form>
</div>
@endsection