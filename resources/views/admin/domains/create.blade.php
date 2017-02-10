@extends('layouts.master')

@section('content')
    <form method="POST" action="/admin/domains">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Domain:</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Domain</button>
        </div>

        <div class="form-group">
            @include('layouts.errors')
        </div>
    </form>
@endsection
