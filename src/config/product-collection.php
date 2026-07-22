<?php

return [
    // Settings
    "useShufflePreview" => false, // По умолчанию сортируется по заголовку
    "previewItemCount" => 3,

    // Models
    "customProductCollectionModel" => null,
    "customProductCollectionModelObserver" => null,

    // Controllers
    "customProductCollectionAdminController" => null,

    // Components
    "customAdminProductCollectionIndexComponent" => null,
    "customAdminProductCollectionShowComponent" => null,
    "customAdminProductCollectionItemsListComponent" => null,
    "customAdminProductCollectionListComponent" => null,

    "customWebCollectionProductTeaserChooseVariationComponent" => null,

    // Managers
    "customProductCollectionActionsManager" => null,

    // Policies
    "productCollectionPolicy" => \GIS\ProductCollection\Policies\ProductCollectionPolicy::class,
    "productCollectionPolicyKey" => "product_collections",
    "productCollectionPolicyTitle" => "Управление коллекциями товаров",

    // Templates
    "templates" => [
        "product-collection-teaser" => \GIS\ProductCollection\Templates\ProductCollectionTeaser::class,
    ],
];
