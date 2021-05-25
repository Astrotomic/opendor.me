@push('head')
<script nonce="{{ csp_nonce() }}">
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('{{ asset('serviceworker.js') }}')
            .then(function (registration) {
                console.log(registration);

                registration.update()
                    .then(console.log)
                    .catch(console.error);
            })
            .catch(console.error);
    }
</script>
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
