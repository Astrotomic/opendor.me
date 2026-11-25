<?php

namespace App\Http\Policies;

use Mazedlx\FeaturePolicy\Policies\Policy;

class PermissionsPolicy extends Policy implements \Stringable
{
    public function configure(): void {}

    public function __toString(): string
    {
        return implode(', ', array_filter([parent::__toString(), 'interest-cohort=()']));
    }
}
