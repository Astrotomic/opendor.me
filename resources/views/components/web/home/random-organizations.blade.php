<div class="bg-white">
    <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:py-16 lg:px-8">
        <p class="text-base font-semibold tracking-wider text-center text-gray-600 uppercase">
            Some of the open-source maintaining organizations
        </p>
        <div class="mt-6 grid grid-cols-2 gap-0.5 md:grid-cols-3 lg:mt-8">
            @foreach($organizations() as $organization)
                <div class="flex flex-col col-span-1 justify-center items-center py-8 px-8 space-y-2 bg-gray-50">
                    <x-gh-avatar :model="$organization" class="max-h-14"/>
                    <span class="text-lg font-medium">{{ \Illuminate\Support\Str::title($organization->name) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
