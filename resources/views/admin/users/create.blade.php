@extends('layouts.master')

@section('content')
    <form method="POST" action="/admin/users">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" id="username">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>

        <div class="form-group">
            @include('layouts.errors')
        </div>
    </form>
@endsection
