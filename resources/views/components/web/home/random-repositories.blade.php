<div class="relative py-16 px-4 bg-gray-50 sm:px-6 lg:py-24 lg:px-8">
    <div class="absolute inset-0">
        <div class="h-1/3 bg-white sm:h-2/3"></div>
    </div>
    <div class="relative mx-auto max-w-7xl">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Repositories
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
                Let our contributors work speak for itself. Checkout some of the repositories our contributors have provided contributions to.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-6 mx-auto mt-12 max-w-lg lg:grid-cols-3 lg:max-w-none">
            @foreach($repositories() as $repository)
                <x-repository :repository="$repository"/>
            @endforeach
        </div>
    </div>
</div>
