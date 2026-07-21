<?php

namespace GIS\ProductCollection\Facades;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductCollection\Helpers\ProductCollectionActionsManager;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getShortItemList(ProductInterface $product)
 * @method static array getItemListByCollections(ProductInterface $product)
 * @method static array getTotalItemList(ProductInterface $product)
 *
 * @method static EloquentCollection getIncludesCollectionsWithItems(ProductInterface $product)
 * @method static EloquentCollection getCollectionsWithItems(ProductInterface $product)
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
