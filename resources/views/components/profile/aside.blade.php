@props(['model'])

<aside {{ $attributes->merge(['class' => 'space-y-0.5']) }}>
    <div class="grid grid-flow-row gap-1 md:grid-flow-col md:gap-4 justify-start">
        <a href="{{ $model->github_url }}" class="grid grid-flow-col gap-1 justify-start items-center group">
            <x-bxl-github class="w-4 h-4 group-hover:text-gray-900" />
            
            <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500 truncate">
                {{ $model->name }}
            </span>
        </a>

        @if($model->twitter)
        <a href="{{ $model->twitter_url }}" class="grid grid-flow-col gap-1 justify-start items-center group">
            <x-bxl-twitter class="w-4 h-4 group-hover:text-gray-900" />

            <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500 truncate">
                {{ '@'.$model->twitter }}
            </span>
        </a>
        @endif

        @if($model->website)
        <a href="{{ $model->website }}" class="grid grid-flow-col gap-1 justify-start items-center group">
            <x-bx-globe class="w-4 h-4 group-hover:text-gray-900"/>

            <span class="text-sm font-medium text-gray-900 group-hover:text-brand-500 truncate">
                {{ \Illuminate\Support\Str::domain($model->website) }}
            </span>
        </a>
        @endif

        @if($model->location)
        <div class="grid grid-flow-col gap-1 justify-start items-center group">
            <x-bx-map class="w-4 h-4"/>

            <span class="text-sm font-medium text-gray-900 truncate">
                {{ $model->location }}
            </span>
        </div>
        @endif
    </div>

    @if($model->description)
    <p class="flex space-x-4 text-sm text-gray-500">
        {{ $model->description }}
    </p>
    @endif
</aside>
