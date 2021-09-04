<x-layout.html
    :title="$title"
    :description="$description"
    class="flex flex-col min-h-screen bg-gray-100"
>
    <x-web.header/>

    <main {{ $attributes }}>
        {{ $slot }}
    </main>

    <x-web.footer/>

    <x-web.umami/>
</x-layout.html>
