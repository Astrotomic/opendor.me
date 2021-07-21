<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Astrotomic\PhpunitAssertions\Laravel\ModelAssertions;
use Illuminate\Support\Facades\DB;
use Tests\Utils\UserAssertions;

uses(Tests\Feature\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeUser', function() {
    UserAssertions::assertUser($this->value);
    return $this;
});

expect()->extend('toBeModel', function($comparison) {
    if ($comparison instanceof Closure) {
        $comparison = Closure::bind($comparison, test())();
    }

    ModelAssertions::assertSame($this->value, $comparison);
    return $this;
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
