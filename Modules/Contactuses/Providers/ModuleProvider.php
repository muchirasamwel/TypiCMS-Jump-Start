<?php

namespace TypiCMS\Modules\Contactuses\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Contactuses\Composers\SidebarViewComposer;
use TypiCMS\Modules\Contactuses\Facades\Contactuses;
use TypiCMS\Modules\Contactuses\Models\Contactus;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.contactuses'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/permissions.php', 'typicms.permissions'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['contactuses' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'contactuses');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        AliasLoader::getInstance()->alias('Contactuses', Contactuses::class);

        // Observers
        Contactus::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('contactuses::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('contactuses');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Contactuses', Contactus::class);
    }
}
