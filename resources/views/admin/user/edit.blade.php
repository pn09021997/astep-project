@extends('layouts.manage')

@section('content')

<div class="container">
    <h1>Sửa Người dùng</h1>

    <form action="{{route('user.update', $item->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
         @method('PATCH') 
       
        <div class="form-group">
            <input type="text" name="Username" id="Username" class="form-control" placeholder="Tên người dùng" value="{{ $item->Username }}">
        </div>

        <div class="form-group">
            <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="{{ $item->password }}">
        </div>

        <div class="form-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ $item->email }}">
        </div>

        <div class="form-group">
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" value="{{ $item->phone }}">
        </div>

        <div class="form-group">
            <input type="text" name="address" id="address" class="form-control" placeholder="Địa chỉ" value="{{ $item->address }}">
        </div>

        <div class="form-group">
            <input type="text" name="type" id="type" class="form-control" placeholder="Type" value="{{ $item->type }}">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Cập nhật</button>
    </form>
</div>

@endsection


