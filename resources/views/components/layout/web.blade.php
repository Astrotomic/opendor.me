<x-layout.html
    :title="$title"
    class="min-h-screen bg-gray-100"
>
    <x-web.header/>

    <main {{ $attributes }}>
        {{ $slot }}
    </main>
</x-layout.html>
