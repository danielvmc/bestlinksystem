@extends('layouts.master')

@section('content')
    <form method="POST" action="">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="fake_link">Link giả:</label>
            <input type="text" class="form-control" name="fake_link" id="fake_link" value="{{ old('fake_link') }}">
        </div>

        <div class="form-group">
            <label for="real_link">Link đích:</label>
            <input type="text" class="form-control" name="real_link" id="real_link" value="{{ old('real_link') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Tạo link</button>
        </div>

        @if (session()->has('link'))
            <div class="form-group">
                <a href="{{ session()->get('link')->full_link }}">{{ session()->get('link')->full_link }}</a>
            </div>
        @endif
        </div>
    </form>
@endsection
