<?php

namespace GIS\ProductCollection;

use GIS\Fileable\Traits\ExpandTemplatesTrait;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use GIS\ProductCollection\Observers\ProductCollectionObserver;
use GIS\UserManagement\Traits\ExpandPoliciesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\ProductCollection\Livewire\Admin\Collections\IndexWire as AdminProductCollectionIndexWire;
use GIS\ProductCollection\Livewire\Admin\Collections\ShowWire as AdminProductCollectionShowWire;
use GIS\ProductCollection\Livewire\Admin\Collections\ItemList as AdminProductCollectionItemsListWire;

class ProductCollectionServiceProvider extends ServiceProvider
{
    use ExpandPoliciesTrait, ExpandTemplatesTrait;

    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . "/config/product-collection.php", 'product-collection');
        $this->initFacades();
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "pct");

        $this->loadRoutesFrom(__DIR__ . "/routes/admin.php");

        $this->expandConfiguration();
        $this->observeModels();
        $this->setPolicies();

        $this->addLivewireComponents();
    }

    protected function initFacades(): void
    {
    }

    protected function observeModels(): void
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $observerClass = config("product-collection.customProductCollectionModelObserver") ?? ProductCollectionObserver::class;
        $modelClass::observe($observerClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("product-collection.customAdminProductCollectionIndexComponent");
        Livewire::component(
            "pct-admin-product-collections-index",
            $component ?? AdminProductCollectionIndexWire::class
        );

        $component = config("product-collection.customAdminProductCollectionShowComponent");
        Livewire::component(
            "pct-admin-product-collections-show",
            $component ?? AdminProductCollectionShowWire::class
        );

        $component = config("product-collection.customAdminProductCollectionItemsListComponent");
        Livewire::component(
            "pct-admin-product-collections-items-list",
            $component ?? AdminProductCollectionItemsListWire::class
        );
    }

    protected function bindInterfaces(): void
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $this->app->bind(ProductCollectionModelInterface::class, $modelClass);
    }

    protected function expandConfiguration(): void
    {
        $pct = app()->config["product-collection"];
        $this->expandTemplates($pct);
        $this->expandPolicies($pct, ["productCollectionPolicy"]);
    }

    protected function setPolicies(): void
    {
        Gate::policy(
            config("product-collection.customProductCollectionModel") ?? ProductCollection::class,
            config("product-collection.productCollectionPolicy")
        );
    }
}
