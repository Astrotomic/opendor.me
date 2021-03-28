<?php /** @var \App\Enums\Language $language */ ?>
@props(['language'])

@if($language instanceof \App\Enums\Language)
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{$language->color()}-100 text-{$language->color()}-800"]) }}>
    {{ $language->label }}
</span>
@endif
