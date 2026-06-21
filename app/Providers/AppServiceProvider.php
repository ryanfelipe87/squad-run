<?php

namespace App\Providers;

use App\Contracts\CompetitorRepositoryInterface;
use App\Contracts\EventRepositoryInterface;
use App\Contracts\HomeRepositoryInterface;
use App\Contracts\OrganizationRepositoryInterface;
use App\Contracts\RegistrationRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\CompetitorRepository;
use App\Repositories\EventRepository;
use App\Repositories\HomeRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\RegistrationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(CompetitorRepositoryInterface::class, CompetitorRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);
        $this->app->bind(HomeRepositoryInterface::class, HomeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
