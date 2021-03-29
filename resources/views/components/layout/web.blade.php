<x-layout.html
    :title="$title"
    class="min-h-screen bg-gray-100"
>
    <x-web.header/>

    <main class="py-10">
        {{ $slot }}
    </main>
</x-layout.html>
