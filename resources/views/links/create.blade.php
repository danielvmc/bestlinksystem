@extends('layouts.master')

@section('content')
    <div class="col-lg-12">
        <h1 class="page-header">Tạo link Spam - 1 link chỉ nên đăng 1 nick</h1>
    </div>
    <div class="panel-body">
        <form method="POST" action="/">
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

            <div class="form-group">
                @include('layouts.errors')
            </div>
        </form>

         @if (session()->has('link'))
                <div class="form-group">
                    <hr>
                    <button class="btn btn-primary" onclick="copyToClipboard('#result-link')">Copy link</button><br>
                    <a id="result-link" href="{{ session()->get('link')->full_link }}">{{ session()->get('link')->full_link }}</a><br>
                </div>
            @endif

    </div>
@endsection

<script>
    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }
</script>
