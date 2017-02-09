@extends('layouts.master')

@section('content')

    <div class="col-sm-8">
        <h1>Đăng nhập</h1>

        <form method="POST" action="/login">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>

            <div class="form-group">
                @include('layouts.errors')
            </div>
        </form>

    </div>
@endsection
