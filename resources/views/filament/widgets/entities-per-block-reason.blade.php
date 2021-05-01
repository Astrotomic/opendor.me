<div>
    <x-filament::card class="space-y-2">
        <div class="flex items-center justify-between w-full">
            <x-filament::card-header :title="$title"/>
            <div class="w-1/3">
                <div class="flex text-xs w-full space-x-1">
                    {{ $total }} total
                </div>
            </div>
        </div>
        <div class="text-sm">
            @foreach($reasons as $reason)
                <div>
                    {{ $reason->block_reason->label }} ({{ $reason->quantity }} - {{ number_format($reason->percentage, 2) }}%)
                </div>
            @endforeach
        </div>
    </x-filament::card>
</div>
