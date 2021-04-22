<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="dns-prefetch" href="https://avatars.githubusercontent.com"/>
    <link rel="dns-prefetch" href="https://images.unsplash.com"/>
    <link rel="dns-prefetch" href="https://plausible.io"/>

    <title>{{ $title }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#ff4297">
    <meta name="apple-mobile-web-app-title" content="opendor.me">
    <meta name="application-name" content="opendor.me">
    <meta name="msapplication-TileColor" content="#ff4297">
    <meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <link rel="sitemap" type="application/xml" href="{{ route('sitemap.xml') }}"/>
    <link rel="canonical" href="{{ rtrim(request()->url(), '/') }}"/>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

    <script nonce="{{ csp_nonce() }}">
        window.ALGOLIA_ID = '{{ config('scout.algolia.id') }}';
        window.ALGOLIA_KEY = '{{ config('scout.algolia.search_key') }}';
    </script>

    @stack('head')
</head>
<body {{ $attributes->merge(['class' => 'antialiased']) }}>
{{ $slot }}
<script src="{{ mix('js/app.js') }}"></script>
@stack('javascript')
</body>
</html>
