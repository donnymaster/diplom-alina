<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapUserWebRoutes();

        $this->mapModeratorWebRoutes();

        $this->mapAdminWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
    /**
     * Define the "web-user" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserWebRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->group(base_path('routes/core/user.php'));
    }
    /**
     * Define the "web-moderator" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapModeratorWebRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->group(base_path('routes/core/moderator.php'));
    }

    /**
     * Define the "web-admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminWebRoutes()
    {
        Route::middleware(['web', 'auth'])
             ->namespace($this->namespace)
             ->group(base_path('routes/core/admin.php'));
    }

}
