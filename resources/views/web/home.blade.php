<x-layout.web>

<div class="relative bg-white">
    <div class="hidden lg:block lg:absolute lg:inset-0" aria-hidden="true">
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
    <div class="relative pt-6 pb-16 sm:pb-24 lg:pb-32">
    <main class="px-4 mx-auto mt-16 max-w-7xl sm:mt-24 sm:px-6 lg:mt-32">
        <div class="lg:flex lg:justify-between">
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:mx-0 lg:text-left pr-8">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl xl:text-6xl text-gray-900">
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
            <div class="relative mt-12 sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:flex lg:items-center">
                <svg class="absolute top-0 left-1/2 transform origin-top scale-75 -translate-x-1/2 -translate-y-8 sm:scale-100 lg:hidden" width="640" height="784" fill="none" viewBox="0 0 640 784" aria-hidden="true">
                    <defs>
                        <pattern id="4f4f415c-a0e9-44c2-9601-6ded5a34a13e" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
                    <rect x="118" width="404" height="784" fill="url(#4f4f415c-a0e9-44c2-9601-6ded5a34a13e)" />
                </svg>
                <div class="overflow-hidden relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                    <img
                        class="w-full"
                        src="https://images.unsplash.com/photo-1573497491208-6b1acb260507?auto=format&fit=crop&w=1350&q=80"
                        alt="Two people in interview process"
                        loading="lazy"
                    />
                </div>
            </div>
        </div>
    </main>
    </div>
</div>

    {{--  random Repositories  --}}
    <div class="relative py-16 px-4 bg-gray-50 sm:px-6 lg:py-24 lg:px-8">
        <div class="absolute inset-0">
            <div class="h-1/3 bg-white sm:h-2/3"></div>
        </div>
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Repositories
                </h2>
                <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-6 mx-auto mt-12 max-w-lg lg:grid-cols-3 lg:max-w-none">
                @foreach(\App\Models\Repository::inRandomOrder()->limit(3)->get() as $repository)
                    <x-repository :repository="$repository"/>
                @endforeach
            </div>
        </div>
    </div>

    {{--  Stats  --}}
    <div class="pt-12 bg-gray-50 sm:pt-16">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Trusted by developers all around the globe
                </h2>
                <p class="mt-3 text-xl text-gray-500 sm:mt-4">
                    We help open-source contributors to make their work visible and understandable to recruiters.
                </p>
            </div>
        </div>
        <div class="pb-12 mt-10 bg-white sm:pb-16">
            <div class="relative">
                <div class="absolute inset-0 h-1/2 bg-gray-50"></div>
                <div class="relative px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-4xl">
                        <dl class="bg-white rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                            <div class="flex flex-col p-6 text-center border-b border-gray-100 sm:border-0 sm:border-r">
                                <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                    Developers
                                </dt>
                                <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                    {{ \Illuminate\Support\Str::numeral(\App\Models\User::count()) }}
                                </dd>
                            </div>
                            <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 sm:border-0 sm:border-l sm:border-r">
                                <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                    Repositories
                                </dt>
                                <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                    {{ \Illuminate\Support\Str::numeral(\App\Models\Repository::count()) }}
                                </dd>
                            </div>
                            <div class="flex flex-col p-6 text-center border-t border-gray-100 sm:border-0 sm:border-l">
                                <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500">
                                    Contributions
                                </dt>
                                <dd class="order-1 text-5xl font-extrabold text-indigo-600">
                                    {{ \Illuminate\Support\Str::numeral(\App\Models\RepositoryUserPivot::count()) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  random Contributors  --}}
    <div class="bg-white">
        <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-24">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3 lg:gap-8">
                <div class="space-y-5 sm:space-y-4">
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Meet some contributors
                    </h2>
                    <p class="text-xl text-gray-500">
                        We want to promote open-source contributors. So here you can see some of them.
                    </p>
                </div>
                <div class="lg:col-span-2">
                    <ul class="grid gap-8 sm:grid-cols-2">
                        @foreach(\App\Models\User::whereNotNull('github_access_token')->inRandomOrder()->take(6)->get() as $contributor)
                        <li class="@if($loop->iteration >= 5) hidden md:block @endif">
                            <div class="flex items-center space-x-4 lg:space-x-6">
                                <x-gh-avatar :model="$contributor" class="w-16 h-16 rounded-full lg:w-20 lg:h-20"/>
                                <div class="font-medium">
                                    <h3 class="text-xl truncate">{{ $contributor->full_name ?? $contributor->name }}</h3>
                                    <a
                                        href="{{ route('profile', auth()->user()) }}"
                                        class="block text-gray-500 truncate hover:text-gray-700"
                                    >
                                        {{ '@'.$contributor->name }}
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{--  random Organizations  --}}
    <div class="bg-white">
        <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:py-16 lg:px-8">
            <p class="text-base font-semibold tracking-wider text-center text-gray-600 uppercase">
                Some of the open-source maintaining organizations
            </p>
            <div class="mt-6 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-8">
                @foreach(\App\Models\Organization::inRandomOrder()->limit(6)->get() as $organization)
                <div class="flex flex-col col-span-1 justify-center items-center py-8 px-8 space-y-2 bg-gray-50">
                    <x-gh-avatar :model="$organization" class="max-h-14"/>
                    <span class="text-lg font-medium">{{ \Illuminate\Support\Str::title($organization->name) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    {{--  FAQs  --}}
    <div class="bg-white">
        <div class="py-16 px-4 mx-auto max-w-7xl divide-y-2 divide-gray-200 sm:py-24 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Frequently Asked Questions
            </h2>
            <div class="pt-10 mt-6">
                <dl class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-2">
                    @foreach($faqs as $faq)
                    <div>
                        <dt class="text-lg font-medium leading-6 text-gray-900">
                            {{ $faq->question }}
                        </dt>
                        <dd class="mt-2 text-base text-gray-500">
                            {!! \Illuminate\Support\Str::markdown($faq->answer) !!}
                        </dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>

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
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</x-layout.web>
