<x-layout.html
    :title="$title"
    class="flex flex-col min-h-screen bg-gray-100"
>
    <x-web.header/>

    <main {{ $attributes }}>
        {{ $slot }}
    </main>

    <footer class="bg-white">
        <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="https://github.com/Astrotomic/opendor.me" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">GitHub</span>
                    <x-fab-github class="w-6 h-6"/>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-base text-center text-gray-400">
                    <span class="block sm:inline"><a href="{{ url('/') }}" class="hover:text-gray-700">{{ config('app.name') }}</a> &copy; {{ date('Y') }} <a href="https://astrotomic.info" class="hover:text-gray-700">Astrotomic</a>.</span>
                    <span class="block sm:inline">All rights reserved.</span>
                </p>
            </div>
        </div>
    </footer>
</x-layout.html>
