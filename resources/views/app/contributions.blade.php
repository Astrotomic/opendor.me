<x-layout.app page-title="Contributions">

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <x-form :action="route('app.repository.create')" class="flex rounded-md shadow-sm max-w-xl" x-data="{}" @submit="$refs.input.value = $refs.input.value.replace('https://github.com/', '')">
            <div class="relative flex-grow focus-within:z-10">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <x-far-search-plus class="w-4 h-4 text-gray-400"/>
                </div>
                <label for="repository-name" class="sr-only">Name</label>
                <input type="text" name="name" id="repository-name" class="block py-1 pl-10 w-full rounded-none rounded-l-md border border-gray-300 focus:outline-none focus:border-indigo-500" placeholder="Astrotomic/opendor.me" x-ref="input" @change="$refs.input.value = $refs.input.value.replace('https://github.com/', '')">
            </div>

            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-none rounded-r-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                submit
            </button>
        </x-form>
    </div>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($contributions as $contribution)
                <x-repository :repository="$contribution" class="col-span-1"/>
            @endforeach
        </div>
    </div>

</x-layout.app>
