@props(['model'])

<x-avatar
    :search="$model->name"
    provider="github"
    :src="$model->avatar_url"
    :alt="$model->name"
    loading="lazy"
    {{ $attributes->merge(['class' => 'flex-shrink-0 rounded-md bg-white']) }}
/>
