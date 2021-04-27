<div class="bg-white">
    <div class="py-8 px-4 mx-auto max-w-7xl divide-y-2 divide-gray-200 sm:py-16 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900">
            Sponsors
        </h2>
        <div class="grid grid-cols-2 gap-8 justify-center py-4 mt-6 md:grid-cols-3 lg:grid-cols-4">
            @foreach($sponsors() as $sponsor)
                <a href="{{ $sponsor->url }}" class="flex flex-col justify-center items-center py-6 px-4 space-y-2">
                    <img class="max-h-12" src="{{ asset('images/sponsors/'.$sponsor->image) }}" alt="{{ $sponsor->name }}">
                    <span class="text-lg font-medium text-center">{{ $sponsor->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
