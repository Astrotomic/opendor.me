<div>
    <x-filament::card class="space-y-2">
        <div class="flex items-center justify-between w-full">
            <x-filament::card-header :title="$title"/>
            <div class="w-1/3">
                <div class="flex text-xs w-full space-x-1">
                    {{ $reasons->count() }} total
                </div>
            </div>
        </div>
        <div class="text-sm">
            @foreach($reasons as $reason)
                <div>
                    {{ $reason->block_reason }} ({{ $reason->quantity }} - {{ $reason->percentage }}%)
                </div>
            @endforeach
        </div>
    </x-filament::card>
</div>
