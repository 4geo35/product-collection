<?php

namespace GIS\ProductCollection;

use Illuminate\Support\ServiceProvider;

class ProductCollectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . "/config/product-collection.php", 'product-collection');
        $this->initFacades();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "pct");

        $this->observeModels();
        $this->addLivewireComponents();
    }

    protected function initFacades(): void
    {
    }

    protected function observeModels(): void
    {
    }

    protected function addLivewireComponents(): void
    {
    }
}
