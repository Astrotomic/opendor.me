@once
@push('javascript')
<script nonce="{{ csp_nonce() }}">
    const search = algolia.instantsearch({
        indexName: '{{ (new \App\Models\User)->searchableAs() }}',
        searchClient: algolia.searchClient,
    });

    search.addWidgets([
        algolia.widgets.searchBox({
            container: '#algolia-search-input',
            placeholder: 'Enter an username',
            searchAsYouType: true,
            showReset: false,
            showLoadingIndicator: false,
            showSubmit: true,
            templates: {
                submit: document.getElementById('search-icon').innerHTML,
            },
            cssClasses: {
                form: 'relative',
                input: 'block py-3 px-3 pl-10 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none',
                submit: 'flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none',
            },
        }),
        algolia.widgets.stats({
            container: '#algolia-search-stats-total',
            templates: {
                text: (renderOptions) => `Found <strong>${renderOptions.nbHits}</strong> matching users`
            },
            cssClasses: {
                text: 'text-sm text-gray-500',
            },
        }),
        algolia.widgets.stats({
            container: '#algolia-search-stats-pagination',
            templates: {
                text: (renderOptions) => {
                    let total = renderOptions.nbHits;
                    let from = renderOptions.page * renderOptions.hitsPerPage + 1;
                    let to = Math.min((renderOptions.page + 1) * renderOptions.hitsPerPage, total);

                    return `
                        Showing <strong>${from}</strong> to <strong>${to}</strong> of <strong>${total}</strong> matching users
                    `
                }
            },
            cssClasses: {
                text: 'text-sm text-gray-700',
            },
        }),
        algolia.widgets.currentRefinements({
            container: '#algolia-search-refinements',
            cssClasses: {
                list: 'flex flex-col space-y-2',
                item: 'flex flex-wrap items-center space-x-2',
                label: 'font-medium',
                category: 'inline-flex items-center px-2 py-1 text-xs rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
                delete: 'ml-1',
            }
        }),
        algolia.widgets.hits({
            container: '#algolia-search-hits',
            templates: {
                item: `
                <a href="@{{ profile_url }}" class="flex items-center p-4 space-x-4 bg-white rounded-lg shadow group focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <img src="@{{ avatar_url }}" alt="@{{ name }}" width="192" height="192" loading="lazy" class="flex-shrink-0 rounded-md bg-white w-12 h-12">
                    <div class="space-y-1 overflow-hidden">
                        <strong class="block text-lg font-medium leading-tight text-gray-900 truncate group-hover:text-brand-500">
                            @{{ display_name }}
                        </strong>
                        <span class="block font-normal leading-tight text-gray-500 group-hover:text-gray-700 truncate">
                            @@{{ name }}
                        </span>
                    </div>
                </a>
                `,
            },
            cssClasses: {
                list: 'grid grid-cols-1 col-span-full gap-6 md:grid-cols-2 lg:grid-cols-3',
            }
        }),
        algolia.widgets.refinementList({
            container: '#algolia-search-languages',
            attribute: 'languages',
            operator: 'and',
            limit: 5,
            searchable: true,
            searchableIsAlwaysActive: false,
            sortBy: ['count:desc'],
            templates: {
                item: `
                <label class="flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        name="languages"
                        value="@{{ label }}"
                        class="h-4 w-4 mr-1.5 text-brand-500 border-gray-300 focus:ring-brand-500"
                        @{{#isRefined}} checked @{{/isRefined}}
                    />
                    <span>@{{ label }}</span>
                    <span class="ml-2 text-xs text-gray-500">@{{ count }}</span>
                </label>
                `
            },
            cssClasses: {
                searchableRoot: 'mb-2',
                searchableInput: 'block py-2 px-3 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none',
                searchableSubmit: 'hidden',
                searchableReset: 'hidden',
                list: 'space-y-1',
            },
        }),
        algolia.widgets.hitsPerPage({
            container: '#algolia-search-hits-per-page',
            items: [
                { label: '6 hits per page', value: 6 },
                { label: '12 hits per page', value: 12, default: true },
                { label: '18 hits per page', value: 18 },
                { label: '24 hits per page', value: 24 },
                { label: '30 hits per page', value: 30 },
            ],
            cssClasses: {
                select: 'block py-1.5 px-3 pr-8 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none'
            }
        }),
        algolia.widgets.pagination({
            container: '#algolia-search-pagination',
            showFirst: true,
            showPrevious: false,
            showNext: false,
            showLast: true,
            padding: 2,
            scrollTo: false,
            templates: {
            },
            cssClasses: {
                root: '',
                list: 'relative z-0 inline-flex rounded-md shadow-sm -space-x-px text-gray-500',
                item: 'relative border border-gray-300 bg-white text-sm font-medium hover:text-brand-400 hover:bg-gray-50',
                firstPageItem: 'rounded-l-md',
                lastPageItem: 'rounded-r-md',
                pageItem: '',
                selectedItem: 'text-brand-500 pointer-events-none',
                disabledItem: 'text-gray-300 pointer-events-none',
                link: 'inline-flex items-center px-4 py-2',
            }
        }),
    ]);

    search.start();
</script>
@endpush
@endonce

<x-layout.web page-title="User Search">

    <div class="bg-white">
        <div class="py-8 px-4 mx-auto max-w-7xl sm:py-16 sm:px-6 lg:px-8">
            <div id="algolia-search-input">
                <template id="search-icon" hidden>
                    <x-bx-search class="w-5 h-5 text-gray-400"/>
                </template>
            </div>

            <div class="flex justify-between items-center mt-0.5">
                <div id="algolia-search-stats-total"></div>
                <div class="flex items-center">
                    <span class="text-xs text-gray-500">Search by</span>
                    <a href="https://algolia.com" title="Algolia" class="ml-1">
                        <img class="h-3" src="{{ asset('images/sponsors/algolia.svg') }}" alt="Algolia">
                    </a>
                </div>
            </div>

            <div class="flex justify-between space-x-4 mt-2">
                <div id="algolia-search-refinements"></div>
                <div id="algolia-search-hits-per-page" class="hidden sm:block"></div>
            </div>

            <div class="flex flex-col sm:flex-row space-y-6 sm:space-y-0 sm:space-x-8 mt-2 sm:mt-6">
                <div class="w-72 space-y-4">
                    <div>
                        <strong class="block font-medium mb-2">Languages</strong>
                        <div id="algolia-search-languages"></div>
                    </div>
                </div>
                <div id="algolia-search-hits" class="w-full"></div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8 space-y-2 sm:space-y-0 sm:space-x-4">
                <div id="algolia-search-stats-pagination"></div>
                <div id="algolia-search-pagination"></div>
            </div>
        </div>
    </div>

</x-layout.web>
