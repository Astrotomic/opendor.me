<footer class="bg-white">
    <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-12 divide-y-2 divide-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Sponsors
            </h2>
            <div class="grid grid-cols-2 gap-8 justify-center py-4 mt-6 md:grid-cols-3 lg:grid-cols-4">
                <a href="https://pingping.io" class="flex justify-center py-6 px-4">
                    <img class="h-12" src="{{ asset('images/sponsors/pingping.svg') }}" alt="PingPing">
                </a>
                <a href="https://plausible.io" class="flex justify-center py-6 px-4">
                    <img class="h-12" src="{{ asset('images/sponsors/plausible.png') }}" alt="Plausible">
                </a>
            </div>
        </div>

        <ul class="flex flex-wrap justify-center -mx-4 space-x-2 -sm:mx-6 -lg:mx-8 sm:space-x-4">
            <li>
                <a href="https://plant.treeware.earth/Astrotomic/opendor.me" class="block py-2 px-4 text-base text-gray-500 hover:text-gray-900 sm:px-6 lg:px-8">
                    Plant a Tree
                </a>
            </li>
            <li>
                <a href="https://pingping.io/wQwuV01Z" class="block py-2 px-4 text-base text-gray-500 hover:text-gray-900 sm:px-6 lg:px-8">
                    Status
                </a>
            </li>
            <li>
                <a href="https://plausible.io/opendor.me" class="block py-2 px-4 text-base text-gray-500 hover:text-gray-900 sm:px-6 lg:px-8">
                    Statistics
                </a>
            </li>
        </ul>

        <div class="mt-4 md:flex md:items-center md:justify-between">
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
    </div>
</footer>
