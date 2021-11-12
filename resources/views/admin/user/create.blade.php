@extends('layouts.manage')

@section('content')

<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Thêm mới
                            <small>Người dùng</small>
                        </h1>
                    </div>
                    <form action="{{ route('user.store') }}" method="post" >
        @csrf
        
        <div class="form-group">
            <input type="text" name="Username" id="Username" class="form-control" placeholder="Tên người dùng">
        </div>

        <div class="form-group">
            <input type="text" name="password" id="password" class="form-control" placeholder="Password" >
        </div>

        <div class="form-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" >
        </div>

        <div class="form-group">
            <input type="text" name="address" id="address" class="form-control" placeholder="Địa chỉ" >
        </div>

        <div class="form-group">
            <input type="text" name="type" id="type" class="form-control" placeholder="Type">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Thêm</button>
    </form>
</div>
@endsection