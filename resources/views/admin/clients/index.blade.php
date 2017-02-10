@extends('layouts.master')

@section('content')
    <h1>All Clients Infomation</h1>

    <ul>
    @foreach ($clients as $client)
        <li>{{ $client->ip}}   {{ $client->user_agent }}   {{ $client->country }}</li>
    @endforeach
    </ul>

    {{ $clients->links() }}
@endsection
