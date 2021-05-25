<footer class="bg-gray-800">
    <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <ul class="flex flex-wrap justify-center -mx-4 space-x-2 -sm:mx-6 -lg:mx-8 sm:space-x-4 md:space-x-6 lg:space-x-8">
            <li>
                <a href="https://forest.astrotomic.info" class="flex items-center py-2 px-3 text-base text-green-500 hover:text-green-300 sm:px-6 lg:px-8">
                    <x-bxs-tree class="h-4 w-4 mr-1"/>
                    Plant a Tree
                </a>
            </li>
            <li>
                <a href="https://pingping.io/wQwuV01Z" class="flex items-center py-2 px-3 text-base text-gray-300 hover:text-white sm:px-6 lg:px-8">
                    <x-bx-wifi class="h-4 w-4 mr-1"/>
                    <span>Status</span>
                </a>
            </li>
        </ul>

        <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="https://github.com/Astrotomic/opendor.me" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">GitHub</span>
                    <x-bxl-github class="w-6 h-6"/>
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-base text-center text-gray-400">
                    <span class="block sm:inline"><a href="{{ url('/') }}" class="hover:text-white">{{ config('app.name') }}</a> &copy; {{ date('Y') }} <a href="https://astrotomic.info" class="hover:text-white">Astrotomic</a>.</span>
                    <span class="block sm:inline">All rights reserved.</span>
                </p>
            </div>
        </div>
    </div>
</footer>
