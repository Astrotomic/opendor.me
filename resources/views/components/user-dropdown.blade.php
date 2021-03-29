@if(auth()->check())
<div x-data="{ open: false }" @click.away="open = false" class="relative ml-3">
    <button
        type="button"
        class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 overflow-hidden"
        id="user-menu"
        @click="open = !open"
        aria-haspopup="true"
        x-bind:aria-expanded="open"
    >
        <x-gh-avatar :model="auth()->user()" class="w-8 h-8"/>
        <span class="sr-only">Open user menu</span>
    </button>

    <ul
        x-show="open"
        class="absolute right-0 mt-2 w-48 bg-white rounded-md divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu"
        x-cloak
    >
        <li class="py-1" role="none">
            <a
                href="{{ route('app.contributions') }}"
                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                role="menuitem"
            >View Contributions</a>
            <a
                href="{{ route('profile', auth()->user()) }}"
                class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                role="menuitem"
            >View profile</a>
        </li>
        <li class="py-1" role="none">
            @if(auth()->user()->is_admin)
                <a
                    href="{{ url(config('nova.path')) }}"
                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                >Nova</a>
            @endif
            @if(auth()->user()->is_superadmin)
                <a
                    href="{{ url(config('horizon.path')) }}"
                    class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                    role="menuitem"
                >Horizon</a>
            @endif
        </li>
        <li class="py-1" role="none">
            <x-logout :action="route('auth.signout')" class="block py-2 px-4 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                Logout
            </x-logout>
        </li>
    </ul>

</div>
@endif
