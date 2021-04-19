@props(['model'])

@if($model->is_verified)
    <x-bxs-badge-check class="inline-block ml-2 w-4 h-4 text-brand-500"/>
    <span class="sr-only">verified</span>
@endif
