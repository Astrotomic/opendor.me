<div class="bg-white">
    <div class="py-12 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-24">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-3 lg:gap-8">
            <div class="space-y-5 sm:space-y-4">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Meet some contributors
                </h2>
                <p class="text-xl text-gray-500">
                    We want to promote open-source contributors. So here you can see some of them.
                </p>
            </div>
            <div class="lg:col-span-2">
                <ul class="grid gap-8 sm:grid-cols-2">
                    @foreach($contributors() as $contributor)
                        <li class="@if($loop->iteration >= 5) hidden md:block @endif">
                            <div class="flex items-center space-x-4 lg:space-x-6">
                                <x-gh-avatar :model="$contributor" class="w-16 h-16 rounded-full lg:w-20 lg:h-20"/>
                                <div class="font-medium">
                                    <h3 class="text-xl truncate">{{ $contributor->full_name ?? $contributor->name }}</h3>
                                    <a
                                        href="{{ $contributor->profile_url }}"
                                        class="block text-gray-500 truncate hover:text-gray-700"
                                    >
                                        {{ '@'.$contributor->name }}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
