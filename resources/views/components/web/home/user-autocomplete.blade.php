<form
    action="#"
    x-data="components.homeUserAutocomplete()"
    @focusin.once="load"
    @submit.prevent="search"
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
                class="block py-2 py-3 px-3 pl-10 w-full text-base placeholder-gray-500 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:flex-1 focus:outline-none"
                placeholder="Enter an username"
                autocomplete="off"
                x-ref="name"
                @keyup.debounce="search"
                @search="search"
                @focus="isFocused = true"
            />
        </div>
        <button
            type="submit"
            class="py-3 px-6 mt-3 w-full text-base font-medium text-white bg-gray-800 rounded-md border border-transparent shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto"
        >
            Search
        </button>
    </div>
    <div class="relative">
        <ul class="absolute top-1.5 z-10 py-1 w-full bg-white rounded-md border border-gray-300 divide-y divide-gray-200 shadow-lg sm:w-auto" x-show="hits.length > 0 && isFocused" x-cloak>
            <template x-for="hit in hits.slice(0, 3)" :key="hit.item.name" hidden>
                <li>
                    <a :href="profileUrl(hit.item)" class="flex items-center py-2 px-6 space-x-4 hover:bg-gray-100 group">
                        <img
                            :src="avatarUrl(hit.item)"
                            :alt="hit.item.name"
                            loading="lazy"
                            class="flex-shrink-0 w-6 h-6 rounded-md"
                        />
                        <span class="font-medium text-gray-900 group-hover:text-brand-500" x-text="hit.item.display_name"></span>
                        <span class="hidden text-sm text-gray-500 sm:block" x-text="'@'+hit.item.name"></span>
                    </a>
                </li>
            </template>
        </ul>
    </div>
</form>

@once
@push('javascript')
<script nonce="{{ csp_nonce() }}">
    window.components.homeUserAutocomplete = function () {
        return {
            fuse: null,
            hits: [],
            isFocused: false,
            load() {
                this.$fuse(
                    fetch('{{ route('api.user.autocomplete') }}').then(r => r.json()),
                    {
                        keys: ['name', 'display_name'],
                        minMatchCharLength: 3,
                        threshold: 0.5,
                        includeScore: true,
                        ignoreLocation: true,
                    }).then(f => this.fuse = f)
            },
            search() {
                if (this.fuse === null) {
                    return;
                }

                if (this.$refs.name.value.length < 2) {
                    this.hits = [];
                    return;
                }

                this.hits = this.fuse.search(this.$refs.name.value);
            },
            profileUrl(data) {
                return '{{ route('profile', '%name%') }}'.replace('%name%', data.name)
            },
            avatarUrl(data) {
                return 'https://avatars.githubusercontent.com/u/%id%'.replace('%id%', data.id)
            },
        };
    };
</script>
@endpush
@endonce
