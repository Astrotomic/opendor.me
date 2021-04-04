<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Sitemap\Sitemap;

class SitemapXmlController
{
    public function __invoke(): Sitemap
    {
        return Sitemap::create()
            ->add(route('home'))
            ->add(User::whereIsRegistered()->get());
    }
}
