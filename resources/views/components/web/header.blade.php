<header class="bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex px-2 lg:px-0">
                <div class="flex flex-shrink-0 items-center">
                    <a href="#">
                        <img class="w-auto h-8" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg" alt="Workflow">
                    </a>
                </div>
                <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">

                    <a href="{{ route('home') }}" class="py-2 px-3 text-sm font-medium text-gray-900">
                        Home
                    </a>

                    <a href="#" class="py-2 px-3 text-sm font-medium text-gray-900">
                        Jobs
                    </a>

                    <a href="#" class="py-2 px-3 text-sm font-medium text-gray-900">
                        Applicants
                    </a>

                    <a href="#" class="py-2 px-3 text-sm font-medium text-gray-900">
                        Company
                    </a>

                </nav>
            </div>
            <div class="flex items-center lg:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block w-6 h-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <div class="lg:hidden" x-description="Mobile menu, show/hide based on mobile menu state.">

                <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Mobile menu overlay, show/hide based on mobile menu state." class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true" @click="toggle" style="display: none;"></div>

                <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-description="Mobile menu, show/hide based on mobile menu state." class="absolute top-0 right-0 z-30 p-2 w-full max-w-none transition transform origin-top" x-ref="panel" @click.away="open = false" style="display: none;">
                    <div class="bg-white rounded-lg divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 shadow-lg">
                        <div class="pt-3 pb-2">
                            <div class="flex justify-between items-center px-4">
                                <div>
                                    <img class="w-auto h-8" src="https://tailwindui.com/img/logos/workflow-mark-blue-600.svg" alt="Workflow">
                                </div>
                                <div class="-mr-2">
                                    <button type="button" class="inline-flex justify-center items-center p-2 text-gray-400 bg-white rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="toggle">
                                        <span class="sr-only">Close menu</span>
                                        <svg class="w-6 h-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 mt-3 space-y-1">

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Dashboard</a>

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Jobs</a>

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Applicants</a>

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Company</a>

                            </div>
                        </div>
                        <div class="pt-4 pb-2">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=8&amp;w=256&amp;h=256&amp;q=80" alt="">
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800">Whitney Francis</div>
                                    <div class="text-sm font-medium text-gray-500">whitney@example.com</div>
                                </div>
                                <button class="flex-shrink-0 p-1 ml-auto text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="w-6 h-6" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="px-2 mt-3 space-y-1">

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Your Profile</a>

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Settings</a>

                                <a href="#" class="block py-2 px-3 text-base font-medium text-gray-900 rounded-md hover:bg-gray-100 hover:text-gray-800">Sign out</a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="hidden lg:ml-4 lg:flex lg:items-center">
                <x-user-dropdown/>
            </div>
        </div>
    </div>
</header>
