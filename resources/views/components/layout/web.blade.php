<x-layout.html
    :title="$title"
    class="min-h-screen bg-gray-100"
>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex px-2 lg:px-0">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="#">
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg" alt="Workflow">
                        </a>
                    </div>
                    <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">

                        <a href="#" class="px-3 py-2 text-gray-900 text-sm font-medium">
                            Dashboard
                        </a>

                        <a href="#" class="px-3 py-2 text-gray-900 text-sm font-medium">
                            Jobs
                        </a>

                        <a href="#" class="px-3 py-2 text-gray-900 text-sm font-medium">
                            Applicants
                        </a>

                        <a href="#" class="px-3 py-2 text-gray-900 text-sm font-medium">
                            Company
                        </a>

                    </nav>
                </div>
                <div class="flex items-center lg:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="lg:hidden" x-description="Mobile menu, show/hide based on mobile menu state.">

                    <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Mobile menu overlay, show/hide based on mobile menu state." class="z-20 fixed inset-0 bg-black bg-opacity-25" aria-hidden="true" @click="toggle" style="display: none;"></div>

                    <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-description="Mobile menu, show/hide based on mobile menu state." class="z-30 absolute top-0 right-0 max-w-none w-full p-2 transition transform origin-top" x-ref="panel" @click.away="open = false" style="display: none;">
                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y divide-gray-200">
                            <div class="pt-3 pb-2">
                                <div class="flex items-center justify-between px-4">
                                    <div>
                                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg" alt="Workflow">
                                    </div>
                                    <div class="-mr-2">
                                        <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="toggle">
                                            <span class="sr-only">Close menu</span>
                                            <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-3 px-2 space-y-1">

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Dashboard</a>

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Jobs</a>

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Applicants</a>

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Company</a>

                                </div>
                            </div>
                            <div class="pt-4 pb-2">
                                <div class="flex items-center px-5">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=8&amp;w=256&amp;h=256&amp;q=80" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-800">Whitney Francis</div>
                                        <div class="text-sm font-medium text-gray-500">whitney@example.com</div>
                                    </div>
                                    <button class="ml-auto flex-shrink-0 bg-white p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <span class="sr-only">View notifications</span>
                                        <svg class="h-6 w-6" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-3 px-2 space-y-1">

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Your Profile</a>

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Settings</a>

                                    <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Sign out</a>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="hidden lg:ml-4 lg:flex lg:items-center">
                    <!-- Profile dropdown -->
                    <div x-data="{ open: false }" @keydown.escape.stop="open = false" @click.away="open = false" class="ml-4 relative flex-shrink-0">
                        <div>
                            <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu" @click="open = !open" aria-haspopup="true" x-bind:aria-expanded="open">
                                <span class="sr-only">Open user menu</span>
                                <x-gh-avatar :model="$auth" class="h-8 w-8"/>
                            </button>
                        </div>

                        <div x-description="Dropdown menu, show/hide based on menu state." x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu" style="display: none;">

                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>

                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>

                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        {{ $slot }}
    </main>
</x-layout.html>
