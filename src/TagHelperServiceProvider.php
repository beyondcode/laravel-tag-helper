<?php

namespace BeyondCode\TagHelper;

use View;
use Illuminate\Support\ServiceProvider;
use BeyondCode\TagHelper\Helpers\CsrfHelper;
use BeyondCode\TagHelper\Helpers\LinkHelper;
use BeyondCode\TagHelper\Helpers\FormMethodHelper;

class TagHelperServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(TagHelper::class);

        $this->app->alias(TagHelper::class, 'tag-helper');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app['blade.compiler']->extend(function ($view) {
            return $this->app[TagHelperCompiler::class]->compile($view);
        });

        $this->app['tag-helper']->helper(LinkHelper::class);
        $this->app['tag-helper']->helper(FormMethodHelper::class);
        $this->app['tag-helper']->helper(CsrfHelper::class);
    }
}
