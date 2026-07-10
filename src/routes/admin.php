<?php

use Illuminate\Support\Facades\Route;
use GIS\ProductCollection\Http\Controllers\Admin\ProductCollectionController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("product-collections")
            ->as("product-collections.")
            ->group(function () {
                $controllerClass = config("product-collection.customProductCollectionAdminController") ?? ProductCollectionController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
                Route::get("/{collection}", [$controllerClass, "show"])->name("show");
            });
    });
