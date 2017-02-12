<head>
    @if(!$title)
        <title>Webtretho - Cộng đồng phụ nữ lớn nhất Việt Nam</title>
    @else
        <title>{{ $title }}</title>
    @endif
</head>
<script>
window.location = '{{ $realLink }}';
</script>
