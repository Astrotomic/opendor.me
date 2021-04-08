@props(['model'])

<aside {{ $attributes->merge(['class' => 'space-y-0.5']) }}>
    <ul class="flex flex-col text-gray-500 md:flex-row md:space-x-4">
        <li>
            <a href="{{ $model->github_url }}" class="flex items-center group">
                <x-fab-github class="inline-block mr-1 w-4 h-4 group-hover:text-gray-900"/>
                <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500">{{ $model->name }}</span>
            </a>
        </li>
        @if($model->twitter)
        <li>
            <a href="{{ $model->twitter_url }}" class="flex items-center group">
                <x-fab-twitter class="inline-block mr-1 w-4 h-4 group-hover:text-gray-900"/>
                <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500">{{ '@'.$model->twitter }}</span>
            </a>
        </li>
        @endif
        @if($model->website)
        <li>
            <a href="{{ $model->website }}" class="flex items-center group">
                <x-fas-globe class="inline-block mr-1 w-4 h-4 group-hover:text-gray-900"/>
                <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500">{{ \Illuminate\Support\Str::domain($model->website) }}</span>
            </a>
        </li>
        @endif
        @if($model->location)
        <li class="flex items-center group">
            <x-fas-map-marker-alt class="inline-block mr-1 w-4 h-4"/>
            <span class="text-sm font-medium text-gray-900">{{ $model->location }}</span>
        </li>
        @endif
    </ul>
    @if($model->description)
    <p class="flex space-x-4 text-sm text-gray-500">
        {{ $model->description }}
    </p>
    @endif
</aside>
