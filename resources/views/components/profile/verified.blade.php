@props(['model'])

@if($model->is_verified)
    <x-fas-badge-check class="inline-block ml-2 w-4 h-4 text-indigo-400"/>
    <span class="sr-only">verified</span>
@endif
