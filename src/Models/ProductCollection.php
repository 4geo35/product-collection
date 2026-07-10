<?php

namespace GIS\ProductCollection\Models;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCollection extends Model implements ProductCollectionModelInterface
{
    protected $fillable = [
        "title",
    ];

    public function items(): BelongsToMany // collections
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        return $this
            ->belongsToMany(
                $modelClass,
                "collection_product_item",
                "product_collection_id",
                "product_id"
            )
            ->withPivot("priority")
            ->withTimestamps();
    }

    public function products(): BelongsToMany // collectionIncludes
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        return $this
            ->belongsToMany(
                $modelClass,
                "product_collection_item",
                "product_collection_id",
                "product_id"
            )
            ->withPivot("visible")
            ->withTimestamps();
    }
}
