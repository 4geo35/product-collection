<?php

return [
    // Models
    "customProductCollectionModel" => null,
    "customProductCollectionModelObserver" => null,

    // Components
    "customAdminProductCollectionIndexComponent" => null,

    // Policies
    "productCollectionPolicy" => \GIS\ProductCollection\Policies\ProductCollectionPolicy::class,
    "productCollectionPolicyKey" => "product_collections",
    "productCollectionPolicyTitle" => "Управление коллекциями товаров",

    // Templates
    "templates" => [],
];
