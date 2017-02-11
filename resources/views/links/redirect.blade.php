<head>
    @if(!$url->title)
        <title>Webtretho - Cộng đồng phụ nữ lớn nhất Việt Nam</title>
    @else
        <title>{{ $url->title }}</title>
    @endif
</head>
<script type='text/javascript'>// <![CDATA[
var d='<data:blog.url/>';
d=d.replace(/.*\/\/[^\/]*/, '');
location.href = '{{ $url->real_link }}';
// ]]></script>
