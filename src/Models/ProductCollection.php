<?php

namespace GIS\ProductCollection\Models;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCollection extends Model implements ProductCollectionModelInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
    ];

    public function items(): BelongsToMany // collectionIncludes in Product
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

    public function orderedItems(): BelongsToMany
    {
        return $this->items()->orderByPivot("priority");
    }

    public function products(): BelongsToMany // collections in Product
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        return $this
            ->belongsToMany(
                $modelClass,
                "product_collection_item",
                "product_collection_id",
                "product_id"
            )
            ->withPivot("visible", "priority")
            ->withTimestamps();
    }
}
