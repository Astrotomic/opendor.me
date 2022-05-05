<x-layout.web :page-title="$user->name" class="py-10">
    <div class="flex flex-col px-4 mx-auto space-y-3 max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <div class="relative">
                    <x-gh-avatar :model="$user" class="w-28 h-28 shadow"/>
                </div>
            </div>
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $user->display_name }}
                </h1>
                <x-profile.aside :model="$user"/>
            </div>
        </div>

        <div class="py-12 px-4 mx-auto max-w-7xl text-center sm:px-6 lg:py-16 lg:px-8">
            <div class="mt-6 space-y-2">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 uppercase sm:text-4xl">
                    Error <span class="text-gray-400">404</span>
                </h1>
                @guest()
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        This could be your profile.
                    </h2>
                    <p class="text-xl text-gray-900 sm:text-2xl">
                        Sign-In and claim your profile to see all contributions.
                    </p>
                    <a href="{{ route('auth.github.redirect') }}" class="inline-flex relative items-center py-2 px-4 text-sm font-medium text-white rounded-md border border-transparent shadow-sm bg-brand-500 hover:bg-brand-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                        <x-bx-log-in class="mr-2 w-4 h-4"/>
                        Sign-In
                    </a>
                @endguest
                @auth()
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        Profile is missing.
                    </h2>
                    <p class="text-xl text-gray-900 sm:text-2xl">
                        This user has not signed-up yet. You can tell them about <strong>opendor.me</strong>.
                    </p>
                @endauth
            </div>
        </div>
    </div>
</x-layout.web>
