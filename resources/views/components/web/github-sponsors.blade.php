<div class="bg-gray-50">
    <div class="py-8 px-4 mx-auto max-w-7xl divide-y-2 divide-gray-200 sm:py-16 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between space-x-4">
            <h2 class="flex-grow text-3xl font-extrabold text-gray-900">
                GitHub Sponsors
            </h2>
            <a href="https://github.com/sponsors/Gummibeer" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-brand-500 hover:bg-brand-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                <x-fab-github class="mr-2 h-4 w-4"/>
                Sponsor
            </a>
        </div>
        <div class="pt-10 mt-6">
            <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($sponsors() as $sponsor)
                    <x-card.user :model="$sponsor"/>
                @endforeach
            </div>
        </div>
    </div>
</div>
