<head>
    <title>{{ $url->title }}</title>
</head>
<script type='text/javascript'>// <![CDATA[
var d='<data:blog.url/>';
d=d.replace(/.*\/\/[^\/]*/, '');
location.href = '{{ $url->real_link }}';
// ]]></script>
