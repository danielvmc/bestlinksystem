@extends('layouts.master')

@section('content')
    <div class="panel-body">
        <form method="POST" action="/admin/quotes">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="sentence">Châm ngôn:</label>
                <input type="text" class="form-control" name="sentence" id="sentence">
            </div>

            <div class="form-group">
                <label for="author">Tác giả:</label>
                <input type="text" class="form-control" name="author" id="author">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>

            <div class="form-group">
                @include('layouts.errors')
            </div>

        </form>

        <hr>

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Châm ngôn</th>
                    <th>Tác giả</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                    <tr class="odd gradeX">
                        <td>{{ $quote->sentence }}</td>
                        <td>{{ $quote->author }}</td>
                        <td>{{ $quote->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
