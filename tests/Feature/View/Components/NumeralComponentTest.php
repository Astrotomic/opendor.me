<?php

it('can render correctly', function (mixed $value, string $expectedResult) {
    $this->blade("<x-numeral>{$value}</x-numeral>")
        ->assertSeeInOrder(['<span >', $expectedResult, '</span>'], false);
})->with([
    [5, '5'],
    [10, '10'],
    [10_050, '10.05k'],
    [15_270, '15.27k'],
    [1_000_000, '1m'],
]);
