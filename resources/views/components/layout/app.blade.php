<x-layout.html
    :title="$title"
    class="flex overflow-hidden h-screen bg-white"
    x-data="{ sidebarOpen: false }"
>

    {{--  sidebar for mobile  --}}
    <div
        x-show="sidebarOpen"
        class="lg:hidden"
        x-cloak
    >
        <div class="flex fixed inset-0 z-40">
            <div
                @click="sidebarOpen = false"
                x-show="sidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0"
                aria-hidden="true"
                x-cloak
            >
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>
            <div
                x-show="sidebarOpen"
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="flex relative flex-col flex-1 pt-5 pb-4 w-full max-w-xs bg-white"
                x-cloak
            >
                <div class="absolute top-0 right-0 pt-2 -mr-12">
                    <button
                        x-show="sidebarOpen"
                        @click="sidebarOpen = false"
                        class="flex justify-center items-center ml-1 w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        x-cloak
                    >
                        <span class="sr-only">Close sidebar</span>
                        <x-fal-times class="w-6 h-6 text-white"/>
                    </button>
                </div>
                <div class="flex flex-shrink-0 items-center px-4">
                    <x-logo/>
                </div>
                <div class="overflow-y-auto flex-1 mt-5 h-0">
                    <nav class="px-2">
                        <div class="space-y-1">
                            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:text-gray-900 hover:bg-gray-50" -->
                            <a href="#"
                               class="flex items-center py-2 px-2 text-base font-medium leading-5 text-gray-900 bg-gray-100 rounded-md group"
                               aria-current="page">
                                <x-fad-badge-check class="mr-3 w-6 h-6 text-gray-400 group-hover:text-gray-500"/>
                                Contributions
                            </a>
                        </div>
                        <div class="mt-8">
                            <h3 class="px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase" id="teams-headline">
                                Organizations
                            </h3>
                            <ul class="mt-1 space-y-1" role="group" aria-labelledby="teams-headline">
                                @foreach(auth()->user()->organizations as $organization)
                                    <li class="flex justify-between items-center py-2 px-3 text-sm font-medium text-gray-700 rounded-md group">
                                    <span class="flex items-center">
                                        <x-gh-avatar :model="$organization" class="mr-3 w-6 h-6"/>
                                        <span class="truncate">{{ $organization->name }}</span>
                                    </span>
                                        <span class="inline-flex items-center p-1 text-xs font-medium text-gray-500">
                                      {{ $organization->repositories_count }}
                                    </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    {{--  sidebar for desktop  --}}
    <div class="hidden lg:flex lg:flex-shrink-0">
        <div class="flex flex-col pt-5 pb-4 w-64 bg-gray-100 border-r border-gray-200">
            <div class="flex flex-shrink-0 items-center px-6">
                <x-logo/>
            </div>

            <div class="flex overflow-y-auto flex-col flex-1 h-0">
                {{--  user dropdown  --}}
                <div class="inline-block relative px-3 mt-6 text-left">
                    <div
                        type="button"
                        class="py-2 px-2 w-full text-sm font-medium text-left text-gray-700 rounded-md"
                        id="options-menu"
                        aria-haspopup="true"
                    >
                        <div class="flex justify-between items-center space-x-2 w-full">
                            <x-gh-avatar :model="auth()->user()" class="w-10 h-10"/>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ auth()->user()->full_name ?? auth()->user()->name }}
                                </p>
                                <a
                                    href="{{ route('profile', auth()->user()) }}"
                                    class="block text-sm text-gray-500 truncate hover:text-gray-700"
                                >
                                    {{ '@'.auth()->user()->name }}
                                </a>
                            </div>

                            <x-logout :action="route('auth.signout')" class="block flex-shrink-0 p-3 -mr-2 text-gray-400 rounded hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500">
                                <x-fas-sign-out class="w-4 h-4"/>
                                <span class="sr-only">Logout</span>
                            </x-logout>
                        </div>
                    </div>
                </div>

                {{--  navigation  --}}
                <nav class="px-3 mt-6">
                    <ul class="space-y-1">

                        <li>
                            <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-700 hover:text-gray-900 hover:bg-gray-50" -->
                            <a
                                href="{{ route('app.contributions') }}"
                                class="flex justify-between items-center py-2 px-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-md group focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500"
                            >
                                <span class="flex items-center">
                                <x-fad-badge-check class="mr-3 w-6 h-6 text-gray-500"/>
                                <span>Contributions</span>
                                </span>
                                <span class="inline-flex items-center p-1 text-xs font-medium text-gray-500">
                                  {{ auth()->user()->contributions_count }}
                                </span>
                            </a>
                        </li>

                    </ul>

                    {{--  organizations  --}}
                    <div class="mt-8">
                        <h3 class="px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase" id="teams-headline">
                            Organizations
                        </h3>

                        <ul class="mt-1 space-y-1" role="group" aria-labelledby="teams-headline">
                            @foreach(auth()->user()->organizations as $organization)
                                <li class="flex justify-between items-center py-2 px-3 text-sm font-medium text-gray-700 rounded-md group">
                                    <span class="flex items-center">
                                        <x-gh-avatar :model="$organization" class="mr-3 w-6 h-6"/>
                                        <span class="truncate">{{ $organization->name }}</span>
                                    </span>
                                    <span class="inline-flex items-center p-1 text-xs font-medium text-gray-500">
                                      {{ $organization->repositories_count }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="flex overflow-hidden flex-col flex-1 w-0">
        {{--  mobile header  --}}
        <div class="flex relative z-10 flex-shrink-0 h-16 bg-white border-b border-gray-200 lg:hidden">
            <button
                @click.stop="sidebarOpen = true"
                class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden"
            >
                <span class="sr-only">Open sidebar</span>
                <x-fal-bars class="w-6 h-6"/>
            </button>
            <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex flex-1">
                </div>
                <div class="flex items-center">
                    <x-user-dropdown/>
                </div>
            </div>
        </div>

        {{--  main section  --}}
        <div class="overflow-y-auto relative z-0 flex-1 focus:outline-none">

            <header class="flex sticky top-0 z-10 justify-between items-center py-4 px-4 bg-white border-b border-gray-200 sm:px-6 lg:px-8">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 truncate">
                        {{ $pageTitle }}
                    </h1>
                </div>
                <div class="flex ml-4">
                    <button
                        type="button"
                        class="inline-flex order-1 items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0"
                        x-data="{{ json_encode(['profile_url' => auth()->user()->profile_url, 'copied' => false]) }}"
                        @click.prevent="$clipboard(profile_url)
                            .then(() => {
                                copied = true;
                                setTimeout(() => {
                                    copied = false;
                                    $el.blur();
                                }, 1000);
                            });"
                    >
                        <span class="mr-2 w-4 h-4">
                            <x-far-share-alt class="w-full h-full" x-show="!copied"/>
                            <x-far-check class="w-full h-full text-green-500" x-show="copied" x-cloak/>
                        </span>
                        <span>Share</span>
                    </button>
                </div>
            </header>

            <main class="relative">
                {{ $slot }}
            </main>

        </div>
    </div>

</x-layout.html>
