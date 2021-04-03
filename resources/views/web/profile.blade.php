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
                    {{ $user->full_name ?? $user->name }}
                </h1>
                <x-profile.aside :model="$user"/>
                <ul class="flex flex-wrap space-x-2">
                    @foreach($languages->unique() as $language)
                        <li><x-repository.language :language="$language" class="shadow"/></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <p class="text-gray-700">
            <span class="font-medium text-gray-900">{{ $user->full_name ?? $user->name }}</span> has contributed to <span class="font-medium text-gray-900">{{ $user->contributions_count }}</span> different repositories across <span class="font-medium text-gray-900">{{ $contributions->count() }}</span> unique vendors.
            <br/>
            These repositories have {!! $languages->unique()->map(fn(\App\Enums\Language $l) => '<span class="font-medium text-gray-900">'.$l->label.'</span>')->join(', ', ' and ') !!} as their primary {{ \Illuminate\Support\Str::plural('language', $languages->unique()->count()) }} - most contributions were made to repositories using <span class="font-medium text-gray-900">{{ $languages->groupBy(fn(\App\Enums\Language $l) => $l->label)->map(fn(\Illuminate\Support\Collection $repos) => $repos->count())->sortDesc()->keys()->first() }}</span> as primary language.
            @if($user->repositories()->exists())
            <br/>
            They publish open-source repositories using their own <span class="font-medium text-gray-900">{{ $user->name }}</span> nickname.
            @endif
            @if($organizations->isNotEmpty())
            <br/>
            In addition, they are also a member of {!! $organizations->map(fn(\App\Models\Organization $organization) => '<span class="font-medium text-gray-900">'.($organization->full_name ?? $organization->name).'</span>')->join(', ', ' and ') !!} {{ \Illuminate\Support\Str::plural('organization', $organizations->count()) }}, and have contributed to their open-source repositories.
            @endif
        </p>
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
                            {{ $owner->full_name ?? $owner->name }}
                            <x-profile.verified :model="$owner"/>
                        </h2>
                        <x-profile.aside :model="$owner"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($repositories->take(6) as $repository)
                        <x-repository :repository="$repository" :user="$user"/>
                    @endforeach
                </div>

                @if($repositories->count() > 6)
                    <button
                        type="button"
                        @click="showAll = !showAll"
                        class="block mx-auto items-center px-2.5 py-1.5 border border-gray-300 shadow text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow"
                        x-text="(showAll ? 'hide additional repositories' : `show all ${count} repositories`)"
                    ></button>

                    <div
                        class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3"
                        x-cloak
                        x-show="showAll"
                        :aria-hidden="!showAll"
                    >
                        @foreach($repositories->slice(6) as $repository)
                            <x-repository :repository="$repository" :user="$user"/>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </section>
</x-layout.web>
