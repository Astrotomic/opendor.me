<?php

use App\Enums\Language;
use App\Enums\License;
use App\Models\Repository;

beforeEach(function () {
    $this->validData = [
        'id' => 123457,
        'full_name' => 'Gummibeer/php-library',
        'name' => 'php-library',
        'description' => 'Hello world',
        'homepage' => 'opendor.me',
        'stargazers_count' => 10000,
        'private' => false,
        'archived' => false,
        'disabled' => false,
        'fork' => false,
        'language' => 'PHP',
        'license' => [
            'key' => 'mit',
            'name' => 'MIT License',
            'spdx_id' => 'MIT',
            'url' => 'https://api.github.com/licenses/mit',
            'node_id' => 'MDc6TGljZW5zZTEz',
        ],
        'owner' => [
            'id' => 123456,
            'type' => 'User',
            'login' => 'Gummibeer',
        ],
    ];
});

it('links the repository to the owner', function () {
    Repository::fromGithub($this->validData);

    expect(Repository::findOrFail(123457))
        ->name->toBe('Gummibeer/php-library')
        ->description->toBe('Hello world')
        ->language->toBe(Language::PHP())
        ->license->toBe(License::MIT())
        ->owner->toBeUser()
        ->owner->name->toBe('Gummibeer');
});

it('the fromGithub method returns early if the data is invalid')
    ->expect(fn ($overrides) => Repository::fromGithub(array_merge($this->validData, $overrides)))->toBeNull()
    ->expect(fn () => Repository::exists())->toBeFalse()
    ->with([
        [['private' => true]],
        [['archived' => true]],
        [['disabled' => true]],
        [['license' => null]],
        [['name' => '.github']],
        [['name' => 'Gummibeer', 'owner' => ['type' => 'User', 'login' => 'Gummibeer']]],
        [['fork' => true]],
        [['language' => 'some-fake-language']],
    ]);

it('throws an InvalidArgumentException if the owner type is not User or Organization')
    ->tap(fn () => Repository::fromGithub(array_merge($this->validData, ['owner' => ['type' => 'Foobar']])))
    ->throws(InvalidArgumentException::class, 'Unknown repository owner type [Foobar]');
