<?php

namespace Tests\Utils;

use App\Models\Organization;
use Astrotomic\PhpunitAssertions\NullableTypeAssertions;
use Astrotomic\PhpunitAssertions\UrlAssertions;
use PHPUnit\Framework\Assert as PHPUnit;

trait OrganizationAssertions
{
    /**
     * @param  \App\Models\Organization|mixed  $actual
     */
    public static function assertOrganization($actual): void
    {
        PHPUnit::assertInstanceOf(Organization::class, $actual);
        PHPUnit::assertIsInt($actual->id);
        PHPUnit::assertIsString($actual->name);
        PHPUnit::assertIsString($actual->display_name);

        self::assertGithubUrl($actual);
        self::assertAvatarUrl($actual);
        self::assertTwitter($actual);

        NullableTypeAssertions::assertIsNullableString($actual->full_name);
        NullableTypeAssertions::assertIsNullableString($actual->description);
        NullableTypeAssertions::assertIsNullableString($actual->location);
        NullableTypeAssertions::assertIsNullableBool($actual->is_verified);

        BlockableAssertions::assertBlockable($actual);
    }

    public static function assertGithubUrl(Organization $actual): void
    {
        UrlAssertions::assertValidLoose($actual->github_url);
        UrlAssertions::assertScheme('https', $actual->github_url);
        UrlAssertions::assertHost('github.com', $actual->github_url);
        UrlAssertions::assertPath('/'.$actual->name, $actual->github_url);
    }

    public static function assertAvatarUrl(Organization $actual): void
    {
        UrlAssertions::assertValidLoose($actual->avatar_url);
        UrlAssertions::assertScheme('https', $actual->avatar_url);
        UrlAssertions::assertHost('avatars.githubusercontent.com', $actual->avatar_url);
        UrlAssertions::assertPath('/u/'.$actual->id, $actual->avatar_url);
    }

    public static function assertTwitter(Organization $actual): void
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
