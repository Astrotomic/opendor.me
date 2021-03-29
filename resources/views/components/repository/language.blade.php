<?php /** @var \App\Enums\Language $language */ ?>
@props(['language'])

@if($language instanceof \App\Enums\Language)
{{-- bg-yellow-100 text-yellow-800 --}}
{{-- bg-red-100 text-red-800 --}}
{{-- bg-blue-100 text-blue-800 --}}
{{-- bg-indigo-100 text-indigo-800 --}}
{{-- bg-green-100 text-green-800 --}}
{{-- bg-gray-100 text-gray-800 --}}
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{$language->color()}-100 text-{$language->color()}-800"]) }}>
    {{ $language->label }}
</span>
@endif
