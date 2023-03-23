<?php

namespace App\Providers;
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
