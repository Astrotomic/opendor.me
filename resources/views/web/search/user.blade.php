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
                    <img src="@{{ avatar_url }}" alt="@{{ name }}" width="192" height="192" loading="lazy" class="flex-shrink-0 w-12 h-12 bg-white rounded-md">
                    <div class="overflow-hidden space-y-1">
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
            searchablePlaceholder: 'Search for language',
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
                searchableInput: 'block py-1.5 px-3 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none',
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
        <div class="py-8 px-4 mx-auto max-w-7xl sm:py-12 sm:px-6 lg:px-8">
            <div class="hidden mb-8 sm:block">
                <div class="border-b border-gray-200">
                    <nav class="flex flex-col justify-between -mb-px space-y-2 sm:flex-row sm:space-y-0 sm:space-x-8" aria-label="Tabs">
                        <a
                            href="{{ route('search.user') }}"
                            class="
                                flex-1 justify-center group inline-flex items-center py-4 px-2 sm:border-b-2 font-medium text-sm
                                @if(request()->is(trim(route('search.user', [], false), '/')))
                                border-indigo-500 text-indigo-600
                                @else
                                border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300
                                @endif
                            "
                        >
                            <x-bx-user class="mr-2 w-5 h-5"/>
                            <span>Users</span>
                        </a>

                        <span class="inline-flex flex-1 justify-center items-center py-4 px-2 text-sm font-medium text-gray-300 line-through border-transparent sm:border-b-2 group">
                            <x-bx-buildings class="mr-2 w-5 h-5"/>
                            <span>Organizations</span>
                        </span>
                        <span class="inline-flex flex-1 justify-center items-center py-4 px-2 text-sm font-medium text-gray-300 line-through border-transparent sm:border-b-2 group">
                            <x-bx-package class="mr-2 w-5 h-5"/>
                            <span>Repositories</span>
                        </span>
                    </nav>
                </div>
            </div>

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

            <div class="flex justify-between mt-2 space-x-4">
                <div id="algolia-search-refinements"></div>
                <div id="algolia-search-hits-per-page" class="hidden sm:block"></div>
            </div>

            <div class="flex flex-col mt-2 space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8 sm:mt-6">
                <div class="space-y-4 w-full sm:w-72">
                    <div>
                        <strong class="block mb-2 font-medium">Languages</strong>
                        <div id="algolia-search-languages"></div>
                    </div>
                </div>
                <div id="algolia-search-hits" class="w-full"></div>
            </div>

            <div class="flex flex-col mt-8 space-y-2 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 sm:space-x-4">
                <div id="algolia-search-stats-pagination"></div>
                <div id="algolia-search-pagination"></div>
            </div>
        </div>
    </div>

</x-layout.web>
