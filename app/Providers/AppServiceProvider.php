<?php

namespace App\Providers;

use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\WpRoleRepositoryInterface;
use App\Interfaces\WpSiteRepositoryInterface;
use App\Interfaces\WpUserRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\WpRoleRepository;
use App\Repositories\WpSiteRepository;
use App\Repositories\WpUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerUserRepo();
        $this->registerRoleRepo();
        $this->registerWpUserRepo();
        $this->registerWpRoleRepo();
        $this->registerWpSiteRepo();
    }


    public function registerUserRepo() {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function registerWpUserRepo() {
        $this->app->bind(WpUserRepositoryInterface::class, WpUserRepository::class);
    }

    public function registerRoleRepo() {
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }

    public function registerWpRoleRepo() {
        $this->app->bind(WpRoleRepositoryInterface::class, WpRoleRepository::class);
    }

    public function registerWpSiteRepo() {
        $this->app->bind(WpSiteRepositoryInterface::class, WpSiteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
