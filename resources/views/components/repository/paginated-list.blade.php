@props(['contributor' => null, 'owner' => null, 'autoload' => false])

<div
    x-data="window.components.paginatedRepositoryList()"
    x-init="init"
    @if($contributor) data-contributor="{{ json_encode($contributor->getKey()) }}" @endif
    @if($owner) data-owner="{{ json_encode(['type' => $owner->getMorphClass(), 'id' => $owner->getKey()]) }}" @endif
    data-autoload="{{ json_encode($autoload) }}"
    {{ $attributes }}
>
    <template hidden x-if="repositories.length === 0">
        <x-bx-loader-alt class="w-8 h-8 animate-spin text-gray-500"/>
    </template>

    <template hidden x-if="repositories.length > 0">
        <div>
            <div class="grid grid-cols-1 col-span-full gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <template x-for="repository in repositories" :key="repository.id">
                    {{-- <x-card.repository/> --}}
                    <div class="bg-white rounded-lg divide-y divide-gray-200 shadow flex flex-col">
                        <div class="flex-grow px-6 py-4 space-y-2 w-full">
                            <div class="flex justify-between items-center space-x-6 w-full">
                                <div class="flex-1 truncate">
                                    <h3 class="space-x-1 text-base truncate">
                                        <a
                                            :href="repository.owner.profile_url"
                                            class="font-normal text-gray-500 hover:text-gray-700"
                                            x-text="repository.vendor_name"
                                        ></a>
                                        <span class="font-medium text-gray-900" x-text="repository.repository_name"></span>
                                    </h3>
                                    <ul class="flex mt-1 space-x-2">
                                        <li class="inline-flex">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800" x-text="repository.license.label"></span>
                                        </li>
                                        <li class="inline-flex">
                                            <span class="inline-flex items-center rounded overflow-hidden text-xs font-medium bg-white"><span class="bg-opacity-50 w-full h-full px-2 py-0.5 text-black" :class="'bg-'+repository.language.color" x-text="repository.language.label"></span></span>
                                        </li>
                                        <li class="inline-flex">
                                            <span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium">
                                                <x-bxs-star class="w-3.5 h-3.5 mr-1 text-yellow-500"/>
                                                <span class="text-yellow-800" x-text="repository.stargazers_numeral"></span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <a :href="repository.owner.profile_url" class="block">
                                    <img
                                        :src="repository.owner.avatar_url"
                                        :alt="repository.owner.name"
                                        loading="lazy"
                                        width="192"
                                        height="192"
                                        class="flex-shrink-0 rounded-md bg-white w-10 h-10"
                                    />
                                </a>
                            </div>
                            <p class="text-sm text-gray-500 truncate" x-text="repository.description"></p>
                        </div>


                        <div class="flex -mt-px w-full divide-x divide-gray-200">
                            <a :href="repository.github_url" class="inline-flex relative flex-grow justify-center items-center py-4 px-3 -mr-px text-sm font-medium rounded-bl-lg group flex-1" title="GitHub">
                                <x-bxl-github class="w-5 h-5 text-gray-400 group-hover:text-gray-600"/>
                                <span class="ml-3 text-gray-700 group-hover:text-gray-500">GitHub</span>
                            </a>
                            <a :href="repository.github_url+'/graphs/contributors'" class="inline-flex relative flex-shrink justify-center items-center py-4 px-3 text-sm font-medium rounded-br-lg group flex-1" title="Contributors">
                                <x-bxs-group class="w-5 h-5 text-gray-400 group-hover:text-gray-600"/>
                                <span class="ml-3 text-gray-700 group-hover:text-gray-500">Contributors</span>
                            </a>
                        </div>
                    </div>
                    {{--! <x-card.repository/> !--}}
                </template>
            </div>

            <template x-if="nextPageUrl">
                <button
                    type="button"
                    @click="loadNextPage"
                    class="block mx-auto items-center px-2.5 py-1.5 border border-gray-300 shadow text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 shadow mt-6"
                    :disabled="loading"
                >load more repositories</button>
            </template>
        </div>
    </template>
</div>

@once
@push('javascript')
<script nonce="{{ csp_nonce() }}">
window.components.paginatedRepositoryList = function () {
    return {
        repositories: [],
        nextPageUrl: null,
        loading: false,
        autoload: false,
        filter: {
            contributor: null,
            owner: null,
        },
        init() {
            this.autoload = JSON.parse(this.$el.dataset.autoload);
            this.filter.contributor = JSON.parse(this.$el.dataset.contributor ?? null);
            this.filter.owner = JSON.parse(this.$el.dataset.owner ?? null);

            this.loadFirstPage();
        },
        loadFirstPage() {
            if(this.repositories.length > 0) {
                return;
            }

            if(this.loading) {
                return;
            }

            this.loading = true;

            const url = new URL("{{ route('api.repository') }}");
            if(this.filter.contributor) {
                url.searchParams.set('contributor', this.filter.contributor);
            }
            if(this.filter.owner) {
                url.searchParams.set('owner[type]', this.filter.owner.type);
                url.searchParams.set('owner[id]', this.filter.owner.id);
            }

            fetch(url.toString())
                .then(res => res.json())
                .then(paginator => {
                    paginator.data.forEach(repository => this.repositories.push(repository));
                    this.nextPageUrl = paginator.next_page_url;
                })
                .finally(() => {
                    this.loading = false;
                    if(this.autoload){
                        this.loadNextPage();
                    }
                });
        },
        loadNextPage() {
            if(!this.nextPageUrl) {
                return;
            }

            if(this.loading) {
                return;
            }

            this.loading = true;

            fetch(this.nextPageUrl)
                .then(res => res.json())
                .then(paginator => {
                    paginator.data.forEach(repository => this.repositories.push(repository));
                    this.nextPageUrl = paginator.next_page_url;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    };
};
</script>
@endpush
@endonce
