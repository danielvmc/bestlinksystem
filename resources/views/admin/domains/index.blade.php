@extends('layouts.master')

@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Danh sách Domain</h1>
    </div>

    <div class="panel-body">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Domain</th>
                    <th>Ngày thêm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($domains as $domain)
                    <tr class="odd gradeX">
                        <td>
                            <a href="http://{{ $domain->name }}">{{ $domain->name }}</a>
                        </td>
                        <td>{{ $domain->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
