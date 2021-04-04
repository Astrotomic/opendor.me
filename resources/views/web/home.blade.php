<x-layout.web>

    {{--  hero section  --}}
    <div class="relative bg-white">
        <div class="hidden overflow-hidden lg:block lg:absolute lg:inset-0" aria-hidden="true">
            <svg class="absolute top-0 left-1/2 transform translate-x-64 -translate-y-8" width="640" height="784" fill="none" viewBox="0 0 640 784">
                <defs>
                    <pattern id="9ebea6f4-a1f5-4d96-8c4e-4c2abf658047" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
                <rect x="118" width="404" height="784" fill="url(#9ebea6f4-a1f5-4d96-8c4e-4c2abf658047)" />
            </svg>
        </div>

        <div class="overflow-x-hidden relative pt-6 pb-16 sm:pb-24 lg:pb-32">
            <main class="px-4 mx-auto mt-16 max-w-7xl sm:mt-24 sm:px-6 lg:mt-32">
                <div class="lg:flex lg:justify-between">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:mx-0 lg:text-left lg:mr-12 lg:flex-grow">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl xl:text-6xl">
                          We <span class="text-indigo-600">open doors</span> for open-source contributors
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                            We make open-source visible and understandable for everyone and show recruiters the open-source work of a potential candidate.
                        </p>
                        <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                            <p class="text-base font-medium text-gray-900">
                                Search for an open-source contributor.
                            </p>
                            <x-web.home.user-autocomplete class="mt-3"/>
                        </div>
                    </div>
                    <div class="relative mt-12 sm:max-w-lg sm:mx-auto lg:mt-0 xl:max-w-none lg:mx-0 lg:flex lg:flex-shrink lg:items-center">
                        <svg class="absolute top-0 left-1/2 transform origin-top scale-75 -translate-x-1/2 -translate-y-8 sm:scale-100 lg:hidden" width="640" height="784" fill="none" viewBox="0 0 640 784" aria-hidden="true">
                            <defs>
                                <pattern id="4f4f415c-a0e9-44c2-9601-6ded5a34a13e" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                </pattern>
                            </defs>
                            <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
                            <rect x="118" width="404" height="784" fill="url(#4f4f415c-a0e9-44c2-9601-6ded5a34a13e)" />
                        </svg>
                        <x-imgix
                            source="unsplash"
                            path="photo-1573497491208-6b1acb260507"
                            class="relative z-10 w-full rounded-lg shadow-lg"
                            alt="Two people during interview process"
                            width="1350"
                            height="900"
                            :params="['fit' => 'crop', 'rot' => 357]"
                        />
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{--  random Repositories  --}}
    <x-web.home.random-repositories limit="3"/>

    {{--  Stats  --}}
    <x-web.home.stats/>

    {{--  random Contributors  --}}
    <x-web.home.random-contributors limit="6"/>

    {{--  random Organizations  --}}
    <x-web.home.random-organizations limit="6"/>

    {{--  FAQs  --}}
    <x-web.home.faqs/>

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

</x-layout.web>
