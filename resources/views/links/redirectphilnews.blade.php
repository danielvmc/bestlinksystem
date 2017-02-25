<head>
    @if(!$title)
        <title>Loading...</title>
    @else
        <title>{{ $title }}</title>
    @endif
</head>
<script>
window.location = 'http://philnews.info';
</script>
