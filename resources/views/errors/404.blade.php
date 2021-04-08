<x-layout.web class="flex flex-col flex-grow justify-center bg-white">

    <div class="py-12 px-4 mx-auto max-w-7xl text-center sm:px-6 lg:py-16 lg:px-8">
        <x-fal-ghost class="mx-auto w-24 h-24 text-gray-400"/>

        <div class="mt-6 space-y-2">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 uppercase sm:text-4xl">
                Error <span class="text-gray-400">404</span>
            </h1>
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                Page Not Found
            </h2>
        </div>

        <div class="flex justify-center mt-12">
            <div class="inline-flex rounded-md shadow">
                <a href="{{ url('/') }}" class="inline-flex justify-center items-center py-3 px-5 space-x-2 text-base font-medium text-white bg-brand-600 rounded-md border border-transparent hover:bg-brand-700">
                    <x-far-home class="w-4 h-4 text-gray-100"/>
                    <span>back home</span>
                </a>
            </div>
            <div class="inline-flex ml-3">
                <a href="https://github.com/Astrotomic/opendor.me/issues/new" class="inline-flex justify-center items-center py-3 px-5 space-x-2 text-base font-medium text-gray-700 bg-gray-100 rounded-md border border-transparent hover:bg-gray-200">
                    <x-far-bug class="w-4 h-4 text-gray-500"/>
                    <span>report bug</span>
                </a>
            </div>
        </div>
    </div>

</x-layout.web>
