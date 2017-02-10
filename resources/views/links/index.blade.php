@extends('layouts.master')

@section('content')
    <h1>Tat ca links</h1>

    <ul>
    @foreach ($links as $link)
        <li>{{ $link->full_link }}</li>
    @endforeach
    </ul>

    {{ $links->links() }}
@endsection
