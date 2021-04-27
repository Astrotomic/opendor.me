@push('head')
    <meta name="description" content="{{ config('app.name') }} profile of {{ $user->name }}."/>

    <x-open-graph.website :image="$user->avatar_url"/>
@endpush

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
                <ul class="flex flex-wrap space-x-2">
                    @foreach($languages->unique() as $language)
                        <li><x-repository.language :language="$language" class="shadow"/></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="flex text-gray-500">
            <x-bx-error-circle class="inline-block w-5 h-5 mr-1.5 text-red-500"/>
            <p class="flex-grow text-sm">
                It can be that this profile is not complete. What you see is only the data we've already indexed.
            </p>
        </div>
        <x-web.profile.user-summary :user="$user" :languages="$languages"/>
    </div>

    <section class="px-4 mx-auto mt-8 space-y-8 max-w-3xl sm:mt-12 lg:mt-16 sm:px-6 lg:px-8 lg:max-w-7xl sm:space-y-12 lg:space-y-16">
        @foreach($contributions as $repositories)
            @php($owner = $repositories->first()->owner)
            <div class="space-y-6" x-data="{{ json_encode(['showAll' => false, 'count' => $repositories->count()]) }}">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <x-gh-avatar :model="$owner" class="w-20 h-20 shadow"/>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h2 class="flex items-center text-2xl font-bold text-gray-900">
                            {{ $owner->display_name }}
                            <x-profile.verified :model="$owner"/>
                        </h2>
                        <x-profile.aside :model="$owner"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($repositories->take(6) as $repository)
                        <x-card.repository :repository="$repository" :user="$user"/>
                    @endforeach
                </div>

                @if($repositories->count() > 6)
                    <button
                        type="button"
                        @click="showAll = !showAll"
                        class="block mx-auto items-center px-2.5 py-1.5 border border-gray-300 shadow text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow"
                        x-text="(showAll ? 'hide additional repositories' : `show all ${count} repositories`)"
                    ></button>

                    <div
                        class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3"
                        x-cloak
                        x-show="showAll"
                        :aria-hidden="!showAll"
                    >
                        @foreach($repositories->slice(6) as $repository)
                            <x-card.repository :repository="$repository" :user="$user"/>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </section>
</x-layout.web>
