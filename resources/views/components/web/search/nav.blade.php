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

            <a
                href="{{ route('search.organization') }}"
                class="
                    flex-1 justify-center group inline-flex items-center py-4 px-2 sm:border-b-2 font-medium text-sm
                    @if(request()->is(trim(route('search.organization', [], false), '/')))
                        border-indigo-500 text-indigo-600
                    @else
                        border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300
                    @endif
                "
            >
                <x-bx-buildings class="mr-2 w-5 h-5"/>
                <span>Organizations</span>
            </a>

            <span class="inline-flex flex-1 justify-center items-center py-4 px-2 text-sm font-medium text-gray-300 line-through border-transparent sm:border-b-2 group">
                <x-bx-package class="mr-2 w-5 h-5"/>
                <span>Repositories</span>
            </span>
        </nav>
    </div>
</div>
