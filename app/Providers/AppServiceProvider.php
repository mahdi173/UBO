<?php

namespace App\Providers;

use App\Interfaces\CrudInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\WpRoleRepository;
use App\Repositories\WpSiteRepository;
use App\Repositories\WpUserRepository;
use App\Repository\RepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\PoleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use App\Modules\Poles\Service\PoleService;
use App\Modules\Roles\Service\RoleService;
use App\Modules\Types\Service\TypeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->app->when(WpUserRepository::class)
        ->needs(CrudInterface::class)
        ->give(function () {
            return new WpUserRepository();
        });
        $this->app->when(WpRoleRepository::class)
        ->needs(CrudInterface::class)
        ->give(function () {
            return new WpRoleRepository();
        });
        $this->app->when(WpSiteRepository::class)
        ->needs(CrudInterface::class)
        ->give(function () {
            return new WpSiteRepository();
        });
        $this->app->when(UserRepository::class)
        ->needs(CrudInterface::class)
        ->give(function () {
            return new UserRepository();
        });

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->when(PoleController::class)
        ->needs(RepositoryInterface::class)
        ->give(function () {
            return new PoleService();
        });
        $this->app->when(TypeController::class)
        ->needs(RepositoryInterface::class)
        ->give(function () {
            return new TypeService();
        });
        $this->app->when(RoleController::class)
        ->needs(RepositoryInterface::class)
        ->give(function () {
            return new RoleService();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
