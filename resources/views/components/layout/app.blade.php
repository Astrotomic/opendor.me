<x-layout.html
    :title="$title"
    class="flex overflow-hidden h-screen bg-white"
    x-data="{ sidebarOpen: false }"
>

    {{--  sidebar for mobile  --}}
    <div x-show="sidebarOpen" class="lg:hidden"
         x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." style="display: none;">
        <div class="flex fixed inset-0 z-40">
            <div @click="sidebarOpen = false" x-show="sidebarOpen"
                 x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                 x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0"
                 aria-hidden="true" style="display: none;">
                <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
            </div>
            <div x-show="sidebarOpen" x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                 class="flex relative flex-col flex-1 pt-5 pb-4 w-full max-w-xs bg-white" style="display: none;">
                <div class="absolute top-0 right-0 pt-2 -mr-12">
                    <button x-show="sidebarOpen" @click="sidebarOpen = false"
                            class="flex justify-center items-center ml-1 w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            style="display: none;">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="w-6 h-6 text-white" x-description="Heroicon name: outline/x"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-shrink-0 items-center px-4">
                    <img class="w-auto h-8"
                         src="https://tailwindui.com/img/logos/workflow-logo-purple-500-mark-gray-700-text.svg"
                         alt="Workflow">
                </div>
                <div class="overflow-y-auto flex-1 mt-5 h-0">
                    <nav class="px-2">
                        <div class="space-y-1">


                            <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:text-gray-900 hover:bg-gray-50" -->
                            <a href="#"
                               class="flex items-center py-2 px-2 text-base font-medium leading-5 text-gray-900 bg-gray-100 rounded-md group"
                               aria-current="page">
                                <x-fas-box-full class="mr-3 w-6 h-6 text-gray-400 group-hover:text-gray-500"/>
                                Contributions
                            </a>


                            <a href="#"
                               class="flex items-center py-2 px-2 text-base font-medium leading-5 text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                                <svg class="mr-3 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                                     x-description="Heroicon name: outline/view-list" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                My tasks
                            </a>


                            <a href="#"
                               class="flex items-center py-2 px-2 text-base font-medium leading-5 text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50 group">
                                <svg class="mr-3 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                                     x-description="Heroicon name: outline/clock" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Recent
                            </a>

                        </div>
                        <div class="mt-8">
                            <h3 class="px-3 text-xs font-semibold tracking-wider text-gray-500 uppercase"
                                id="teams-headline">
                                Teams
                            </h3>
                            <div class="mt-1 space-y-1" role="group" aria-labelledby="teams-headline">

                                <a href="#"
                                   class="flex items-center py-2 px-3 text-base font-medium leading-5 text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                                    <span class="w-2.5 h-2.5 mr-4 bg-indigo-500 rounded-full" aria-hidden="true"></span>
                                    <span class="truncate">
                        Engineering
                      </span>
                                </a>

                                <a href="#"
                                   class="flex items-center py-2 px-3 text-base font-medium leading-5 text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                                    <span class="w-2.5 h-2.5 mr-4 bg-green-500 rounded-full" aria-hidden="true"></span>
                                    <span class="truncate">
                        Human Resources
                      </span>
                                </a>

                                <a href="#"
                                   class="flex items-center py-2 px-3 text-base font-medium leading-5 text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                                    <span class="w-2.5 h-2.5 mr-4 bg-yellow-500 rounded-full" aria-hidden="true"></span>
                                    <span class="truncate">
                        Customer Success
                      </span>
                                </a>

                            </div>
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
                <img class="w-auto h-8"
                     src="https://tailwindui.com/img/logos/workflow-logo-purple-500-mark-gray-700-text.svg"
                     alt="Workflow">
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
                        <div class="flex justify-between items-center space-x-3 w-full">
                            <x-avatar
                                :search="$auth->name"
                                provider="github"
                                :src="$auth->avatar_url"
                                :alt="$auth->name"
                                class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
                            />
                            <div class="flex-1 min-w-0">
                                <span class="text-sm font-medium text-gray-900 truncate">
                                    {{ $auth->full_name ?? $auth->name }}
                                </span>
                                <span class="text-sm text-gray-500 truncate">
                                    {{ '@'.$auth->name }}
                                </span>
                            </div>

                            <x-logout :action="route('auth.signout')" class="block flex-shrink-0 p-3 -mr-2 text-gray-400 rounded hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500">
                                <x-fas-sign-out class="w-4 h-4"/>
                            </x-logout>
                        </div>
                    </div>
                </div>

                {{--  navigation  --}}
                <nav class="px-3 mt-6">
                    <ul class="space-y-1">

                        <li>
                            <!-- Current: "bg-gray-200 text-gray-900", Default: "text-gray-700 hover:text-gray-900 hover:bg-gray-50" -->
                            <a href="{{ route('app.contributions') }}" class="flex justify-between items-center py-2 px-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-md group">
                                <span class="flex items-center">
                                <x-fad-badge-check class="mr-3 w-6 h-6 text-gray-500"/>
                                <span>Contributions</span>
                                </span>
                                <span class="inline-flex items-center p-1 text-xs font-medium text-gray-500">
                                  {{ $auth->contributions_count }}
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
                            @foreach($auth->organizations as $organization)
                                <li class="flex justify-between items-center py-2 px-3 text-sm font-medium text-gray-700 rounded-md group">
                                <span class="flex items-center">
                                <x-avatar
                                    :search="$organization->name"
                                    provider="github"
                                    :src="$organization->avatar_url"
                                    :alt="$organization->name"
                                    class="flex-shrink-0 mr-3 w-6 h-6 bg-gray-300 rounded-full"
                                />
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
                <svg class="w-6 h-6" x-description="Heroicon name: outline/menu-alt-1"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h8m-8 6h16"></path>
                </svg>
            </button>
            <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex flex-1">
                </div>
                <div class="flex items-center">
                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" @keydown.escape.stop="open = false" @click.away="open = false"
                         class="relative ml-3">
                        <div>
                            <button
                                type="button"
                                class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                                id="user-menu"
                                @click="open = !open"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                            >
                                <span class="sr-only">Open user menu</span>
                                <x-avatar
                                    :search="$auth->name"
                                    provider="github"
                                    :src="$auth->avatar_url"
                                    :alt="$auth->name"
                                    class="flex-shrink-0 w-8 h-8 bg-gray-300 rounded-full"
                                />
                            </button>
                        </div>

                        <div
                            x-show="open"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="user-menu"
                            style="display: none;"
                        >
                            <div class="py-1" role="none">
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">View profile</a>
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">Settings</a>
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">Notifications</a>
                            </div>
                            <div class="py-1" role="none">
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">Get desktop app</a>
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">Support</a>
                            </div>
                            <div class="py-1" role="none">
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                   role="menuitem">Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{--  main section  --}}
        <div class="overflow-y-auto relative z-0 flex-1 focus:outline-none">

            <header
                class="sticky top-0 z-10 py-4 px-4 bg-white border-b border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                        {{ $pageTitle }}
                    </h1>
                </div>
                <div class="flex mt-4 sm:mt-0 sm:ml-4">
                    <button type="button"
                            class="inline-flex order-1 items-center py-2 px-4 ml-3 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-0 sm:ml-0">
                        Share
                    </button>
                    <button type="button"
                            class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-purple-600 rounded-md border border-transparent shadow-sm order-0 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:order-1 sm:ml-3">
                        Create
                    </button>
                </div>
            </header>

            <main class="relative">
                {{ $slot }}
            </main>

        </div>
    </div>

</x-layout.html>
