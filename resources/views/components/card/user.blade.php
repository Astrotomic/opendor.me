<?php /** @var \App\Models\User|\App\Models\Organization $model */ ?>
@props(['model'])

@if($model->profile_url)
<a href="{{ $model->profile_url }}" class="flex items-center p-4 space-x-4 bg-white rounded-lg shadow group focus:ring-2 focus:ring-brand-500 focus:outline-none">
@else
<div class="flex items-center p-4 space-x-4 bg-white rounded-lg shadow">
@endif
    <x-gh-avatar :model="$model" class="w-12 h-12"/>
    <div class="space-y-1 overflow-hidden">
        <strong class="block text-lg font-medium leading-tight text-gray-900 truncate group-hover:text-brand-500">
            {{ $model->display_name }}
        </strong>
        <span class="block font-normal leading-tight text-gray-500 group-hover:text-gray-700 truncate">
            {{ '@'.$model->name }}
        </span>
    </div>
@if($model->profile_url)
</a>
@else
</div>
@endif
