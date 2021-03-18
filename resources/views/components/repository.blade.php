<?php /** @var \App\Models\Repository $repository */ ?>
@props(['repository'])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg divide-y divide-gray-200 shadow flex flex-col']) }}>
    <div class="p-6 w-full space-y-2 flex-grow">
        <div class="flex justify-between items-center space-x-6 w-full">
            <div class="flex-1 truncate">
                <h3 class="text-base truncate space-x-1">
                    <span class="font-normal text-gray-500">{{ $repository->vendor_name }}</span>
                    <span class="font-medium text-gray-900">{{ $repository->repository_name }}</span>
                </h3>
                <ul class="flex space-x-2 mt-1">
                    <li class="inline-flex"><x-license :license="$repository->license"/></li>
                    <li class="inline-flex"><x-language :language="$repository->language"/></li>
                </ul>
            </div>
            <x-avatar
                :search="$repository->owner->name"
                provider="github"
                :src="$repository->owner->avatar_url"
                :alt="$repository->owner->name"
                class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
            />
        </div>
        <p class="text-sm text-gray-500 truncate">{{ $repository->description }}</p>
    </div>

    <div>
        <div class="flex -mt-px divide-x divide-gray-200">
            <div class="flex flex-1 w-0">
                <a href="{{ $repository->github_url }}"
                   class="inline-flex relative flex-1 justify-center items-center py-4 -mr-px w-0 text-sm font-medium text-gray-700 rounded-bl-lg border border-transparent hover:text-gray-500">
                    <x-fab-github class="w-5 h-5 text-gray-400"/>
                    <span class="ml-3">GitHub</span>
                </a>
            </div>
            <div class="flex flex-1 -ml-px w-0">
                <a href="{{ $repository->github_url }}/graphs/contributors"
                   class="inline-flex relative flex-1 justify-center items-center py-4 w-0 text-sm font-medium text-gray-700 rounded-br-lg border border-transparent hover:text-gray-500">
                    <x-fas-users class="w-5 h-5 text-gray-400"/>
                    <span class="ml-3">Contributors</span>
                </a>
            </div>
        </div>
    </div>
</div>
