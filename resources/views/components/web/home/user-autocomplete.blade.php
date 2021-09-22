<div
    x-data="components.homeUserAutocomplete()"
    x-init="init"
    id="user-autocomplete"
    @click.away="isFocused = false"
    {{ $attributes }}
>
    <div class="sm:flex">
        <label for="github-username" class="sr-only">GitHub username</label>
        <div class="relative w-full rounded-md shadow-sm">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <x-bxl-github class="w-5 h-5 text-gray-400"/>
            </div>
            <input
                type="search"
                name="name"
                id="github-username"
                class="block py-3 px-3 pl-10 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none"
                placeholder="Enter a username"
                autocomplete="off"
                @focus="isFocused = true"
            />
        </div>
    </div>
    <div class="relative">
        <div class="absolute top-1.5 z-10 w-full bg-white rounded-md border border-gray-300 shadow-lg sm:w-auto" x-show="hits.length > 0 && isFocused" x-cloak>
            <ol>
                <template x-for="(hit, i) in hits.slice(0, 3)" :key="hit.name" hidden>
                    <li class="border-b border-gray-200">
                        <a :href="hit.profile_url" class="flex items-center py-2 px-6 space-x-4 hover:bg-gray-100 group" :class="{'rounded-t-md': i === 0}">
                            <img :src="hit.avatar_url" :alt="hit.name" class="flex-shrink-0 w-6 h-6 rounded-md"/>
                            <span class="font-medium text-gray-900 group-hover:text-brand-500" x-text="hit.display_name"></span>
                            <span class="hidden text-sm text-gray-500 sm:block" x-text="'@'+hit.name"></span>
                        </a>
                    </li>
                </template>
            </ol>
            <div class="flex items-center justify-end px-2 py-1">
                <span class="text-xs text-gray-500">Search by</span>
                <a href="https://algolia.com" title="Algolia" class="ml-1">
                    <img class="h-3" src="{{ asset('images/sponsors/algolia.svg') }}" alt="Algolia">
                </a>
            </div>
        </div>
    </div>
</div>

@once
@push('javascript')
<script nonce="{{ csp_nonce() }}">
    window.components.homeUserAutocomplete = function () {
        return {
            isFocused: false,
            search: null,
            hits: [],
            init() {
                this.search = algolia.instantsearch({
                    indexName: '{{ (new \App\Models\User)->searchableAs() }}',
                    searchClient: algolia.searchClient,
                });

                const autocomplete = algolia.connectors.connectAutocomplete((renderOptions, isFirstRender) => {
                    const { indices, currentRefinement, refine, widgetParams } = renderOptions;

                    const input = widgetParams.container.querySelector('input[type="search"]');

                    if (isFirstRender) {
                        input.addEventListener('input', event => {
                            refine(event.currentTarget.value);
                        });
                    }

                    this.hits = currentRefinement.length > 0
                        ? indices[0].hits
                        : [];
                });

                this.search.addWidgets([
                    autocomplete({
                        container: document.querySelector('#user-autocomplete'),
                    }),
                ]);

                this.search.start();
            }
        };
    };
</script>
@endpush
@endonce
