@push('javascript')
@env('frosty-pond', 'divine-forest')
<script nonce="{{ csp_nonce() }}">
    window.plausible("404", { props: { path: document.location.pathname } })
</script>
@endenv
@endpush

<x-layout.error>
    <x-fal-alien-monster class="mx-auto w-24 h-24 text-gray-400"/>

    <div class="mt-6 space-y-2">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 uppercase sm:text-4xl">
            Error <span class="text-gray-400">424</span>
        </h1>
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
            Invalid oAuth State
        </h2>
    </div>
</x-layout.error>
