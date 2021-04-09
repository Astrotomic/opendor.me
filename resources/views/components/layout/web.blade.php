@push('javascript')
@env('production')
    <script async defer data-domain="{{ parse_url(url('/'), PHP_URL_HOST) }}" src="https://plausible.io/js/plausible.js"></script>
@endenv
@endpush

<x-layout.html
    :title="$title"
    class="flex flex-col min-h-screen bg-gray-100"
>
    <x-web.header/>

    <main {{ $attributes }}>
        {{ $slot }}
    </main>

    <x-web.footer/>
</x-layout.html>
