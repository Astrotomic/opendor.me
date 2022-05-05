<?php

namespace Tests\Utils;

use App\Models\User;
use Astrotomic\PhpunitAssertions\NullableTypeAssertions;
use Astrotomic\PhpunitAssertions\UrlAssertions;
use PHPUnit\Framework\Assert as PHPUnit;

trait UserAssertions
{
    /**
     * @param \App\Models\User|mixed $actual
     */
    public static function assertUser($actual): void
    {
        PHPUnit::assertInstanceOf(User::class, $actual);
        PHPUnit::assertIsInt($actual->id);
        PHPUnit::assertIsString($actual->name);

        self::assertGithubUrl($actual);
        self::assertAvatarUrl($actual);
        self::assertTwitter($actual);

        NullableTypeAssertions::assertIsNullableString($actual->github_access_token);
        NullableTypeAssertions::assertIsNullableString($actual->full_name);
        NullableTypeAssertions::assertIsNullableString($actual->description);
        NullableTypeAssertions::assertIsNullableString($actual->location);

        BlockableAssertions::assertBlockable($actual);
    }

    public static function assertGithubUrl(User $actual): void
    {
        UrlAssertions::assertValidLoose($actual->github_url);
        UrlAssertions::assertScheme('https', $actual->github_url);
        UrlAssertions::assertHost('github.com', $actual->github_url);
        UrlAssertions::assertPath('/'.$actual->name, $actual->github_url);
    }

    public static function assertAvatarUrl(User $actual): void
    {
        UrlAssertions::assertValidLoose($actual->avatar_url);
        UrlAssertions::assertScheme('https', $actual->avatar_url);
        UrlAssertions::assertHost('avatars.githubusercontent.com', $actual->avatar_url);
        UrlAssertions::assertPath('/u/'.$actual->id, $actual->avatar_url);
    }

    public static function assertTwitter(User $actual): void
    {
        NullableTypeAssertions::assertIsNullableString($actual->twitter);

        if ($actual->twitter !== null) {
            UrlAssertions::assertValidLoose($actual->twitter_url);
            UrlAssertions::assertScheme('https', $actual->twitter_url);
            UrlAssertions::assertHost('twitter.com', $actual->twitter_url);
            UrlAssertions::assertPath('/'.$actual->twitter, $actual->twitter_url);
        } else {
            PHPUnit::assertNull($actual->twitter_url);
        }
    }
}
