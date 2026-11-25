<?php

namespace App\Http\Policies;

use Illuminate\Support\Facades\Vite;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

class ContentSecurityPolicy implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::DEFAULT, Keyword::NONE)
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CHILD, Keyword::NONE)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::CONNECT, 'https://*.algolia.net')
            ->add(Directive::CONNECT, 'https://*.algolianet.com')
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, Keyword::NONE)
            ->add(Directive::FRAME_ANCESTORS, Keyword::NONE)
            ->add(Directive::MANIFEST, Keyword::SELF)
            ->add(Directive::MEDIA, Keyword::NONE)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::WORKER, Keyword::SELF)
            ->add(Directive::IMG, Keyword::SELF)
            ->add(Directive::IMG, 'data:')
            ->add(Directive::IMG, 'https://avatars.githubusercontent.com')
            ->add(Directive::IMG, 'https://images.unsplash.com')
            ->add(Directive::SCRIPT, Keyword::SELF)
            ->add(Directive::SCRIPT, Keyword::UNSAFE_EVAL)
            ->add(Directive::STYLE, Keyword::SELF)
            ->add(Directive::STYLE, Keyword::UNSAFE_INLINE)
            ->add(Directive::FONT, Keyword::SELF)
            ->addNonce(Directive::SCRIPT);

        if (config('app.asset_url')) {
            $policy
                ->add(Directive::SCRIPT, config('app.asset_url'))
                ->add(Directive::STYLE, config('app.asset_url'))
                ->add(Directive::FONT, config('app.asset_url'))
                ->add(Directive::IMG, config('app.asset_url'));
        }

        if (app()->environment('local') && Vite::isRunningHot()) {
            $url = rtrim(file_get_contents(Vite::hotFile()));

            $policy
                ->add(Directive::SCRIPT, $url)
                ->add(Directive::STYLE, $url)
                ->add(Directive::FONT, $url)
                ->add(Directive::IMG, $url)
                ->add(Directive::CONNECT, $url)
                ->add(Directive::CONNECT, 'ws'.substr($url, 4));
        }

        if (config('services.umami.enabled')) {
            $policy
                ->add(Directive::CONNECT, sprintf('https://%s/api/collect', config('services.umami.api_url')))
                ->add(Directive::SCRIPT, sprintf('https://%s/umami.js', config('services.umami.api_url')));
        }
    }
}
