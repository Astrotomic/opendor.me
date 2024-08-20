<?php

namespace App\Http\Policies;

use Mazedlx\FeaturePolicy\Policies\Policy;

class PermissionsPolicy extends Policy implements \Stringable
{
    public function configure(): void {}

    public function __toString()
    {
        return collect(parent::__toString())
            ->add('interest-cohort=()')
            ->filter()
            ->implode(';');
    }
}
