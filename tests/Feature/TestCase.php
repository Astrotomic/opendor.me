<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'api.github.com/users/Gummibeer' => Http::response($this->fixture('users/Gummibeer'), 200),
        ]);
    }

    protected function fixture(string $path): array
    {
        return json_decode(File::get(
            Str::of($path)
                ->trim('/')
                ->prepend(__DIR__.'/../fixtures/')
                ->finish('.json')
        ), true);
    }

    protected function requiresPostgreSQL(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            $this->markTestSkipped('This test requires a PostgreSQL database connection');
        }
    }
}
