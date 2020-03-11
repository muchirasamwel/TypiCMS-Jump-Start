<?php

namespace TypiCMS\Modules\Contactuses\Providers;

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
    protected $namespace = 'TypiCMS\Modules\Contactuses\Http\Controllers';

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
            if ($page = TypiCMS::getPageLinkedToModule('contactuses')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = $page->private ? ['middleware' => 'auth'] : [];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-contactuses');
                            $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::contactus');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('contactuses', 'AdminController@index')->name('admin::index-contactuses')->middleware('can:see-all-contactuses');
                $router->get('contactuses/create', 'AdminController@create')->name('admin::create-contactus')->middleware('can:create-contactus');
                $router->get('contactuses/{contactus}/edit', 'AdminController@edit')->name('admin::edit-contactus')->middleware('can:update-contactus');
                $router->post('contactuses', 'AdminController@store')->name('admin::store-contactus')->middleware('can:create-contactus');
                $router->put('contactuses/{contactus}', 'AdminController@update')->name('admin::update-contactus')->middleware('can:update-contactus');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('contactuses', 'ApiController@index')->middleware('can:see-all-contactuses');
                    $router->patch('contactuses/{contactus}', 'ApiController@updatePartial')->middleware('can:update-contactus');
                    $router->delete('contactuses/{contactus}', 'ApiController@destroy')->middleware('can:delete-contactus');

                    $router->get('contactuses/{contactus}/files', 'ApiController@files')->middleware('can:update-contactus');
                    $router->post('contactuses/{contactus}/files', 'ApiController@attachFiles')->middleware('can:update-contactus');
                    $router->delete('contactuses/{contactus}/files/{file}', 'ApiController@detachFile')->middleware('can:update-contactus');
                });
            });
        });
    }
}
