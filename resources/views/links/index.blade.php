@extends('layouts.master')

@section('content')
    <div class="col-md-12">
        <h1 class="page-header">Danh sách link</h1>
    </div>

    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
        @if (!auth()->user()->isAdmin())
            <thead>
                <tr>
                    <th>Link giả</th>
                    <th>Link bài</th>
                    <th>Link đăng</th>
                    {{-- <th>Link tinyurl</th> --}}
                    <th>Clicks</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($links as $link)
                    <tr class="odd gradeX">
                        <td><a href="{{ $link->fake_link }}">{{ str_limit($link->fake_link, 30) }}</td>
                        <td><a href="{{ $link->real_link }}">{{ str_limit($link->real_link, 30) }}</td>
                        <td><a href="{{ $link->full_link }}">{{ str_limit($link->full_link, 30) }}</a></td>
                        {{-- <td><a href="{{ $link->tiny_url_link }}">{{ $link->tiny_url_link }}</a></td> --}}
                        <td>{{ Redis::get('links.click'. $link->id) }}</td>
                        <td>{{ $link->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>

        @else
            <thead>
                <tr>
                    <th>Link giả</th>
                    <th>Link bài</th>
                    <th>Link thường</th>
                    <th>Link tinyurl</th>
                    <th>Clicks</th>
                    <th>Creator</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($linksAdmin as $link)
                    <tr class="odd listeX">
                        <td><a href="{{ $link->fake_link }}">{{ str_limit($link->fake_link, 20) }}</td>
                        <td><a href="{{ $link->real_link }}">{{ str_limit($link->real_link, 20) }}</td>
                        <td><a href="{{ $link->full_link }}">{{ str_limit($link->full_link, 20) }}</a></td>
                        <td><a href="{{ $link->tiny_url_link }}">{{ $link->tiny_url_link }}</a></td>
                        <td>{{ $link->clicks }}</td>
                        <td>{{ $link->user_name }}</td>
                        <td>{{ $link->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        @endif
        </table>
    </div>


    {{ $links->links() }}
@endsection
