<div class="pt-12 bg-gray-50 sm:pt-16">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Trusted by contributors all around the globe
            </h2>
            <p class="mt-3 text-xl text-gray-500 sm:mt-4">
                We help open-source contributors to make their work visible and understandable to recruiters.
            </p>
        </div>
    </div>

    <div class="pb-12 mt-10 bg-white sm:pb-16">
        <div class="relative">
            <div class="absolute inset-0 h-1/2 bg-gray-50"></div>
            <div class="relative px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mx-auto max-w-4xl">
                    <dl class="bg-white rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                        <div class="flex flex-col p-6 text-center border-b border-gray-100 sm:border-0 sm:border-r">
                            <dd class="text-5xl font-extrabold text-brand-500">
                                <x-numeral>{{ $contributorsCount }}</x-numeral>
                            </dd>
                            <dt class="mt-2 text-lg font-medium leading-6 text-gray-500">
                                Contributors
                            </dt>
                        </div>
                        <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 sm:border-0 sm:border-l sm:border-r">
                            <dd class="text-5xl font-extrabold text-brand-500">
                                <x-numeral>{{ $repositoriesCount }}</x-numeral>
                            </dd>
                            <dt class="mt-2 text-lg font-medium leading-6 text-gray-500">
                                Repositories
                            </dt>
                        </div>
                        <div class="flex flex-col p-6 text-center border-t border-gray-100 sm:border-0 sm:border-l">
                            <dd class="text-5xl font-extrabold text-brand-500">
                                <x-numeral>{{ $contributionsCount }}</x-numeral>
                            </dd>
                            <dt class="mt-2 text-lg font-medium leading-6 text-gray-500">
                                Contributions
                            </dt>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
