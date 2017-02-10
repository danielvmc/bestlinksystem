@extends('layouts.master')

@section('content')
    <h1>All users</h1>

    <ul class="list-group">
        @foreach ($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
@endsection
