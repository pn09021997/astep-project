@extends('layouts.manage')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
    <div class="row">
    
    <div class="col-lg-12">
    <h1 class="page-header">Danh sách
                            <small> Người dùng </small>
                        </h1>
    <div class="beta-subject-list">
    
    <div class="beta-subjects-detail">
    <form style="padding-right:40%;padding-top:2%;" class="form-inline my-2 my-lg-0" role="search" method="get" id="" action="{{route('user.search')}}">
            <input style="border-radius:5px;" type="text" value="" name="keyword" placeholder="Nhập từ khóa...">
            <button style="border-radius:5px;"  class="btn btn-success"type="submit" id="">Tìm kiếm</button>
</form>
     @if(empty(count($user)))
     <p class="pull-left">Không tìm thấy người dùng nào</p>
     @else
    <p style="padding-left:2%;"class="pull-left">Tìm thấy {{count($user)}} người dùng</p>
    @endif
    <div class="clearfix"></div></div></div>
  
    </div>
                      <a style="margin-left:92%;margin-bottom:5%;" href="{{route('category.create')}}" class="btn btn-success">Thêm <i class="fas fa-plus"></i></a>
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                            <tr >
                                <th style="text-align:center;">ID</th>
                                <th style="text-align:center;">Tên</th>
                                <th style="text-align:center;">Password</th>
                                <th style="text-align:center;">Email</th>
                                <th style="text-align:center;">Address</th>
                                <th style="text-align:center;">Phone</th>
                                <th style="text-align:center;">Type</th>
                                <th style="text-align:center;">Sửa</th>
                                <th style="text-align:center;">Xóa</th>
                            </tr>
                        </thead>
                        @foreach($user as $item)
                        <tbody>
                            <tr class="odd gradeX" align="center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->Username }}</td>
                                <td>{{ $item->password }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                                @if($item->type == 1 )
                                <td>Admin</td>
                               @elseif($item->type == 0)
                               <td>Customer</td>
                               @endif
                                <td class="center"><a class="btn btn-primary" href="{{route('user.edit',$item->id)}}"><i class="fas fa-edit"></i></a></td>
                                <td class="center"><form action="{{route('user.destroy',$item->id)}}" method="POST" onsubmit="return confirm('Xóa người dùng?')">
                        @csrf
                         @method('DELETE') 
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </form></td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
   
@endsection


