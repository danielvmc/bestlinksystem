@extends('layouts.master')

@section('content')
    <div class="col-md-12">
        <h1 class="page-header">Danh sách thành viên</h1>
    </div>
    <ul class="list-group">
        <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Tổng Bài</th>
                    <th>Tổng click bài</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="odd gradeX">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->links->count() }}</td>
                        <td>{{ $user->links->sum('clicks') }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            </div>
        </div>
    </ul>
    </div>
@endsection




    <!-- /.panel-heading -->
