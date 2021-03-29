<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
    <script src="{{ mix('js/app.js') }}" defer></script>

    {{ $head ?? null }}
</head>
<body {{ $attributes->merge(['class' => 'antialiased']) }}>
    {{ $slot }}
</body>
</html>
