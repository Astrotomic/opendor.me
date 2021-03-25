<x-layout.app page-title="Contributions">

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($contributions as $contribution)
                <x-repository :repository="$contribution" class="col-span-1"/>
            @endforeach
        </div>
    </div>

</x-layout.app>
