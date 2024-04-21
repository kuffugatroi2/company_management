<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            'App\Repositories\User\UserRepositoryInterface',
            'App\Repositories\User\UserRepository'
        );
        $this->app->bind(
            'App\Repositories\Company\CompanyRepositoryInterface',
            'App\Repositories\Company\CompanyRepository'
        );
        $this->app->bind(
            'App\Repositories\Person\PersonRepositoryInterface',
            'App\Repositories\Person\PersonRepository'
        );
        $this->app->bind(
            'App\Repositories\Role\RoleRepositoryInterface',
            'App\Repositories\Role\RoleRepository'
        );
        $this->app->bind(
            'App\Repositories\RoleUser\RoleUserRepositoryInterface',
            'App\Repositories\RoleUser\RoleUserRepository'
        );
    }
}
