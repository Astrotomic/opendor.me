<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white shadow">
    <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex relative justify-between items-center h-16">
            <div class="flex absolute inset-y-0 left-0 items-center sm:hidden">
                {{-- Mobile menu toggle --}}
                <button type="button" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                    <span class="sr-only">Toggle main menu</span>
                    <x-fal-bars class="block w-6 h-6" x-show="!open" x-cloak/>
                    <x-fal-times class="block w-6 h-6" x-show="open" x-cloak/>
                </button>
            </div>
            <div class="flex flex-1 justify-center items-center h-full sm:items-stretch sm:justify-start">

                {{-- Logo --}}
                <div class="flex flex-shrink-0 items-center">
                    <x-logo/>
                </div>

                {{-- desktop menu --}}
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a
                        href="{{ route('home') }}"
                        class="
                            inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2
                            @if(request()->is(route('home', [], false)))
                                border-brand-500 text-gray-900
                            @else
                                border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700
                            @endif
                        "
                    >Home</a>

                    <a
                        href="{{ route('faqs') }}"
                        class="
                            inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2
                            @if(request()->is(trim(route('faqs', [], false), '/')))
                                border-brand-500 text-gray-900
                            @else
                                border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700
                            @endif
                        "
                    >FAQs</a>

                    <a
                        href="{{ route('sponsors') }}"
                        class="
                            inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2
                            @if(request()->is(trim(route('sponsors', [], false), '/')))
                                border-brand-500 text-gray-900
                            @else
                                border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700
                            @endif
                        "
                    >Sponsors</a>
                </div>
            </div>

            @if(request()->route() !== null)
                @if(auth()->guest())
                <div class="flex-shrink-0">
                    <a href="{{ route('auth.github.redirect') }}" class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-white rounded-md border border-transparent shadow-sm bg-brand-500 hover:bg-brand-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                        <x-fas-sign-in class="mr-2 w-4 h-4"/>
                        Sign-In
                    </a>
                </div>
                @endif
                <x-user-dropdown/>
            @endif
        </div>
    </div>

    {{-- mobile menu --}}
    <div class="sm:hidden" id="mobile-menu" x-show="open" x-cloak>
        <div class="pt-2 pb-4 space-y-1">
            <a
                href="{{ route('home') }}"
                class="
                    block py-2 pr-4 pl-3 text-base font-medium border-l-4
                    @if(request()->is(route('home', [], false)))
                        bg-brand-50 border-brand-500 text-brand-700
                    @else
                        border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700
                    @endif
                "
            >Home</a>

            <a
                href="{{ route('faqs') }}"
                class="
                    block py-2 pr-4 pl-3 text-base font-medium border-l-4
                    @if(request()->is(trim(route('faqs', [], false), '/')))
                        bg-brand-50 border-brand-500 text-brand-700
                    @else
                        border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700
                    @endif
                "
            >FAQs</a>

            <a
                href="{{ route('faqs') }}"
                class="
                    block py-2 pr-4 pl-3 text-base font-medium border-l-4
                    @if(request()->is(trim(route('faqs', [], false), '/')))
                        bg-brand-50 border-brand-500 text-brand-700
                    @else
                        border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700
                    @endif
                "
            >FAQs</a>

            <a
                href="{{ route('sponsors') }}"
                class="
                    block py-2 pr-4 pl-3 text-base font-medium border-l-4
                    @if(request()->is(trim(route('sponsors', [], false), '/')))
                        bg-brand-50 border-brand-500 text-brand-700
                    @else
                        border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700
                    @endif
                "
            >Sponsors</a>
        </div>
    </div>
</nav>
