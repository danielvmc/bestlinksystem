@extends('layouts.master')

@section('content')
    <h1>All Domains</h1>

    <ul class="form-group">
        @foreach ($domains as $domain)
            <li>{{ $domain->name }}</li>
        @endforeach
    </ul>
@endsection
