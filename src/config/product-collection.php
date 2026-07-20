<?php

return [
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

    // Managers
    "customProductCollectionActionsManager" => null,

    // Policies
    "productCollectionPolicy" => \GIS\ProductCollection\Policies\ProductCollectionPolicy::class,
    "productCollectionPolicyKey" => "product_collections",
    "productCollectionPolicyTitle" => "Управление коллекциями товаров",

    // Templates
    "templates" => [],
];
