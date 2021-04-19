<div {{ $attributes->merge(['class' => 'bg-white rounded-lg divide-y divide-gray-200 shadow flex flex-col']) }}>
    <div class="flex-grow px-6 py-4 space-y-2 w-full">
        <div class="flex justify-between items-center space-x-6 w-full">
            <div class="flex-1 truncate">
                <h3 class="space-x-1 text-base truncate">
                    <a href="{{ $repository->owner->profile_url }}" class="font-normal text-gray-500 hover:text-gray-700">{{ $repository->vendor_name }}</a>
                    <span class="font-medium text-gray-900">{{ $repository->repository_name }}</span>
                </h3>
                <ul class="flex mt-1 space-x-2">
                    <li class="inline-flex"><x-repository.license :license="$repository->license"/></li>
                    <li class="inline-flex"><x-repository.language :language="$repository->language"/></li>
                    <li class="inline-flex"><x-repository.stars :stars="$repository->stargazers_count"/></li>
                </ul>
            </div>
            <a href="{{ $repository->owner->profile_url }}" class="block">
                <x-gh-avatar :model="$repository->owner" class="w-10 h-10"/>
            </a>
        </div>
        <p class="text-sm text-gray-500 truncate">{{ $repository->description }}</p>
    </div>

    <div class="flex -mt-px w-full divide-x divide-gray-200">
        <a href="{{ $repository->github_url }}" class="inline-flex relative flex-grow justify-center items-center py-4 px-3 -mr-px text-sm font-medium rounded-bl-lg group @if(!$user) flex-1 @endif" title="GitHub">
            <x-bxl-github class="w-5 h-5 text-gray-400 group-hover:text-gray-600"/>
            <span class="ml-3 text-gray-700 group-hover:text-gray-500">GitHub</span>
        </a>
        @if($user)
            <a href="{{ $repository->github_url }}/commits?author={{ $user->name }}" class="inline-flex relative flex-grow justify-center items-center py-4 px-3 -mr-px text-sm font-medium group" title="Commits">
                <x-bx-git-commit class="w-5 h-5 text-gray-400 group-hover:text-gray-600"/>
                <span class="ml-3 text-gray-700 group-hover:text-gray-500">Commits</span>
            </a>
        @endif
        <a href="{{ $repository->github_url }}/graphs/contributors" class="inline-flex relative flex-shrink justify-center items-center py-4 px-3 text-sm font-medium rounded-br-lg group @if(!$user) flex-1 @endif" title="Contributors">
            <x-bxs-group class="w-5 h-5 text-gray-400 group-hover:text-gray-600"/>
            <span class="@if($user) sr-only @else ml-3 @endif text-gray-700 group-hover:text-gray-500">Contributors</span>
        </a>
    </div>
</div>
