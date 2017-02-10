@extends('layouts.master')

@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Thông tin khách truy cập</h1>
    </div>

    <ul>
    @foreach ($clients as $client)
        <li>{{ $client->ip}}   {{ $client->user_agent }}   {{ $client->country }}</li>
    @endforeach
    </ul>

    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>IP</th>
                    <th>User Agent</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr class="odd gradeX">
                        <td>{{ $client->ip }}</td>
                        <td>{{ $client->user_agent }}</td>
                        <td>{{ $client->country }}</td>
                    </tr>
                @endforeach
            </tbody>
    </table>
    </div>
    {{ $clients->links() }}
@endsection
