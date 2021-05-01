<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ trans('filament::layout.direction') == 'rtl' ? 'rtl' : 'ltr' }}" class="antialiased bg-gray-100 js-focus-visible">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ __($title) ?? null }} {{ __($title) ?? false ? '|' : null }} {{ config('app.name') }}</title>

    @livewireStyles
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Commissioner:wght@200;300;400;500;600;700&amp;family=JetBrains+Mono:ital@0;1&amp;display=swap">
    <link rel="stylesheet" href="{{ mix('css/filament.css', 'vendor/filament/assets') }}" />
    @stack('filament-styles')
</head>

<body class="text-gray-600">
    {{ $slot }}

    <x-filament::notification />

    @livewireScripts
    <script>
        window.filamentConfig = @json(\Filament\Filament::getScriptData());
    </script>
    <script src="{{ mix('js/filament.js', 'vendor/filament/assets') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.6.5/mousetrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.6.5/plugins/global-bind/mousetrap-global-bind.min.js"></script>
    @stack('filament-scripts')
</body>
</html>
