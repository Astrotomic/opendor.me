<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="dns-prefetch" href="https://avatars.githubusercontent.com"/>
    <link rel="dns-prefetch" href="https://images.unsplash.com"/>

    <title>{{ $title }}</title>

    <link rel="sitemap" type="application/xml" href="{{ route('sitemap.xml') }}"/>
    <link rel="canonical" href="{{ rtrim(request()->url(), '/') }}"/>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

    @stack('head')
</head>
<body {{ $attributes->merge(['class' => 'antialiased flex flex-col']) }}>
{{ $slot }}
<script src="{{ mix('js/app.js') }}"></script>
@stack('javascript')
</body>
</html>
