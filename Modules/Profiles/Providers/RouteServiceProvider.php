<?php

namespace TypiCMS\Modules\Profiles\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Profiles\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('profiles')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-profiles');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::profile');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('profiles', 'AdminController@index')->name('admin::index-profiles')->middleware('can:see-all-profiles');
                $router->get('profiles/create', 'AdminController@create')->name('admin::create-profile')->middleware('can:create-profile');
                $router->get('profiles/{profile}/edit', 'AdminController@edit')->name('admin::edit-profile')->middleware('can:update-profile');
                $router->post('profiles', 'AdminController@store')->name('admin::store-profile')->middleware('can:create-profile');
                $router->put('profiles/{profile}', 'AdminController@update')->name('admin::update-profile')->middleware('can:update-profile');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('profiles', 'ApiController@index')->middleware('can:see-all-profiles');
                    $router->patch('profiles/{profile}', 'ApiController@updatePartial')->middleware('can:update-profile');
                    $router->delete('profiles/{profile}', 'ApiController@destroy')->middleware('can:delete-profile');

                    $router->get('profiles/{profile}/files', 'ApiController@files')->middleware('can:update-profile');
                    $router->post('profiles/{profile}/files', 'ApiController@attachFiles')->middleware('can:update-profile');
                    $router->delete('profiles/{profile}/files/{file}', 'ApiController@detachFile')->middleware('can:update-profile');
                });
            });
        });
    }
}
