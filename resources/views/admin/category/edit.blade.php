@extends('layouts.manage')

@section('content')

<div class="container">
    <h1>Sửa Danh Mục</h1>

    <form action="{{route('category.update', $item->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('PATCH') 
        <div class="form-group">
            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Tên danh mục" value="{{ $item->name }}">
        </div>
        <div class="form-group">
            <input type="text" name="category_image" id="category_image" class="form-control" placeholder="Hình ảnh" value="{{ $item->image }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Cập nhật</button>
    </form>
</div>

@endsection


