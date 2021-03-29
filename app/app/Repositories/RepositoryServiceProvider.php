<?php

namespace App\Repositories;

use App\Repositories\HomestayImage\HomestayImageRepository;
use App\Repositories\HomestayImage\HomestayImageRepositoryInterface;
use App\Repositories\Location\LocationRepository;
use App\Repositories\Location\LocationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
   /**
     * @return void
     */
    
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Homestay\HomestayRepositoryInterface::class,
            \App\Repositories\Homestay\HomestayRepository::class
        );
        $this->app->singleton(
            App\Repositories\Location\LocationRepositoryInterface::class,
            App\Repositories\Location\LocationRepository::class
        );

        $this->app->bind(
            HomestayImageRepositoryInterface::class,
            HomestayImageRepository::class
        );
    }
}