<?php /** @var \App\Enums\Language $language */ ?>
@props(['language'])

@if($language instanceof \App\Enums\Language)
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded overflow-hidden text-xs font-medium bg-white"]) }}>
    <span class="bg-{{ $language->color() }} bg-opacity-50 w-full h-full px-2 py-0.5 text-black">{{ $language->label }}</span>
</span>
@endif
