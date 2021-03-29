<?php

namespace App\Providers;

use App\Repositories\HomestayPrice\HomestayPriceRepositoryInterface;
use App\Repositories\HomestayUtility\HomestayUtilityRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Homestay\HomestayRepositoryInterface::class,
            \App\Repositories\Homestay\HomestayRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Location\LocationRepositoryInterface::class,
            \App\Repositories\Location\LocationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\HomestayPolicyType\HomestayPolicyTypeRepositoryInterface::class,
            \App\Repositories\HomestayPolicyType\HomestayPolicyTypeRepository::class
        );

        $this->app->singleton(
            \App\Repositories\HomestayPolicy\HomestayPolicyRepositoryInterface::class,
            \App\Repositories\HomestayPolicy\HomestayPolicyRepository::class
        );

        $this->app->singleton(
            \App\Repositories\HomestayUtility\HomestayUtilityRepositoryInterface::class,
            \App\Repositories\HomestayUtility\HomestayUtilityRepository::class
        );

        $this->app->singleton(
            \App\Repositories\HomestayPrice\HomestayPriceRepositoryInterface::class,
            \App\Repositories\HomestayPrice\HomestayPriceRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
