<?php /** @var int $stars */ ?>

@if($stars > 0)
<span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium">
    <x-fas-star class="w-3.5 h-3.5 mr-1 text-yellow-500"/>
    <x-numeral class="text-yellow-800">{{ $stars }}</x-numeral>
</span>
@endif
