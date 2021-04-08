<x-layout.web :page-title="$organization->name" class="py-10">
    <div class="flex flex-col px-4 mx-auto space-y-3 max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="flex items-center space-x-5">
            <div class="flex-shrink-0">
                <div class="relative">
                    <x-gh-avatar :model="$organization" class="w-28 h-28 shadow"/>
                </div>
            </div>
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $organization->display_name }}
                    <x-profile.verified :model="$organization"/>
                </h1>
                <x-profile.aside :model="$organization"/>
                <ul class="flex flex-wrap space-x-2">
                    @foreach($languages as $language)
                        <li><x-repository.language :language="$language" class="shadow"/></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @if($members->isNotEmpty())
    <section class="px-4 mx-auto mt-8 max-w-3xl sm:mt-12 lg:mt-16 sm:px-6 lg:px-8 lg:max-w-7xl">
        <h2 class="flex items-center mb-4 text-2xl font-bold text-gray-900">
            Members
        </h2>
        <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($members as $member)
                <div class="flex items-center p-4 space-x-4 bg-white rounded-lg shadow">
                    <x-gh-avatar :model="$member" class="w-12 h-12"/>
                    <div class="space-y-1">
                        <strong class="block text-lg font-medium leading-tight text-gray-900 truncate">
                            {{ $member->display_name }}
                        </strong>
                        <a
                            href="{{ $member->profile_url }}"
                            class="block font-normal leading-tight text-gray-500 hover:text-gray-700 truncate"
                        >
                            {{ '@'.$member->name }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($repositories->isNotEmpty())
    <section class="px-4 mx-auto mt-8 max-w-3xl sm:mt-12 lg:mt-16 sm:px-6 lg:px-8 lg:max-w-7xl">
        <h2 class="flex items-center mb-4 text-2xl font-bold text-gray-900">
            Repositories
        </h2>
        <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($repositories as $repository)
                <x-repository :repository="$repository"/>
            @endforeach
        </div>
    </section>
    @endif
</x-layout.web>
