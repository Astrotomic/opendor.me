<div>
    <x-filament::card class="space-y-2">
        <div class="flex items-center justify-between w-full">
            <x-filament::card-header :title="$title"/>
            <div class="w-1/3">
                <div class="flex text-xs w-full space-x-1">
                    @foreach($options as $k => $option)
                        <div class="block rounded bg-gray-50 py-1 px-2  @if($selectedOption === $k) font-medium @endif" wire:click="$set('selectedOption', '{{ $k }}')">
                            {{ $option }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="text-2xl">
            {{ $count }}
        </div>
    </x-filament::card>
</div>
