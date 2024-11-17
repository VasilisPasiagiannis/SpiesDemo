<?php

namespace App\Providers;

use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Repositories\PermissionRepositoryInterface;
use App\Domains\Auth\Repositories\RoleRepository;
use App\Domains\Auth\Repositories\RoleRepositoryInterface;
use App\Domains\Auth\Repositories\UserRepository;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Spies\Repositories\SpyRepository;
use App\Domains\Spies\Repositories\SpyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(SpyRepositoryInterface::class, SpyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
