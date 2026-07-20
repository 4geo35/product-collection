<?php

namespace GIS\ProductCollection\Facades;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductCollection\Helpers\ProductCollectionActionsManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getShortItemList(ProductInterface $product)
 *
 * @see ProductCollectionActionsManager
 */
class ProductCollectionActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "product-collection-actions";
    }
}
