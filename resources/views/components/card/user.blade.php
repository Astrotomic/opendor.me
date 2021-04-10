<?php /** @var \App\Models\User|\App\Models\Organization $model */ ?>
@props(['model'])

<div class="flex items-center p-4 space-x-4 bg-white rounded-lg shadow">
    <x-gh-avatar :model="$model" class="w-12 h-12"/>
    <div class="space-y-1">
        <strong class="block text-lg font-medium leading-tight text-gray-900 truncate">
            {{ $model->display_name }}
        </strong>
        <a
            href="{{ $model->profile_url }}"
            class="block font-normal leading-tight text-gray-500 hover:text-gray-700 truncate"
        >
            {{ '@'.$model->name }}
        </a>
    </div>
</div>
