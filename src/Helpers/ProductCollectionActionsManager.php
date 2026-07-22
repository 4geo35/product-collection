<?php

namespace GIS\ProductCollection\Helpers;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;

class ProductCollectionActionsManager
{
    protected ProductInterface|null $product = null;
    protected EloquentCollection|null $collectionWithItems = null;
    protected EloquentCollection|null $includesWithItems = null;

    public function getShortItemList(ProductInterface $product): array
    {
        $items = $this->getTotalItemList($product);
        $count = count($items);

        if ($count) {
            if (config("product-collection.useShufflePreview")) {
                $items = Arr::shuffle($items);
            } else {
                $items = array_values(Arr::sort($items, function ($item) {
                    return $item->title;
                }));
            }
        }
        $slice = Arr::take($items, config("product-collection.previewItemCount"));

        return [$count, $slice];
    }

    public function getItemListByCollections(ProductInterface $product): array
    {
        $this->setProductAndCollections($product);
        $collections = [];

        $pIds = [];
        if ($this->collectionWithItems && $this->collectionWithItems->count()) {
            foreach ($this->collectionWithItems as $collection) {
                $items = [];
                foreach ($collection->orderedItems as $item) {
                    $items[$item->id] = $this->productToObjectData($item);
                    $pIds[] = $item->id;
                }
                if (count($items)) {
                    $collections[] = (object) [
                        "title" => $collection->title,
                        "items" => $items
                    ];
                }
            }
        }

        if ($this->includesWithItems && $this->includesWithItems->count()) {
            $items = [];
            foreach ($this->includesWithItems as $collection) {
                foreach ($collection->products as $item) {
                    if (! empty($items[$item->id])) { continue; }
                    if (in_array($item->id, $pIds)) { continue; }
                    $items[$item->id] = $this->productToObjectData($item);
                }
            }
            if (count($items)) {
                $items = array_values(Arr::sort($items, function ($item) {
                    return $item->title;
                }));
                $collections = [(object) [
                    "title" => null,
                    "items" => $items
                ], ...$collections];
            }
        }

        return $collections;
    }

    public function getTotalItemList(ProductInterface $product): array
    {
        $this->setProductAndCollections($product);
        $items = [];

        if ($this->includesWithItems) {
            foreach ($this->includesWithItems as $collection) {
                foreach ($collection->products as $item) {
                    if (! empty($item[$item->id])) { continue; }
                    $items[$item->id] = $this->productToObjectData($item);
                }
            }
        }

        if ($this->collectionWithItems) {
            foreach ($this->collectionWithItems as $collection) {
                foreach ($collection->orderedItems as $item) {
                    if (! empty($item[$item->id])) { continue; }
                    $items[$item->id] = $this->productToObjectData($item);
                }
            }
        }

        return $items;
    }

    public function getIncludesCollectionsWithItems(ProductInterface $product): EloquentCollection
    {
        return $product->collectionIncludes()
            ->select("id", "title", "slug")
            ->with(["products" => function ($query) {
                $query->select("id", "title", "slug", "published_at")
                    ->whereNotNull("published_at")
                    ->wherePivotNotNull("visible")
                    ->orderBy("title", "DESC");
            }])
            ->get();
    }

    public function getCollectionsWithItems(ProductInterface $product): EloquentCollection
    {
        return $product->orderedCollections()
            ->select("id", "title", "slug")
            ->with(["orderedItems" => function ($query) {
                $query->select("id", "title", "slug", "published_at")
                    ->whereNotNull("published_at");
            }])
            ->get();
    }

    protected function setProductAndCollections(ProductInterface $product): void
    {
        if (! empty($this->product) && $this->product->id === $product->id) { return; }
        $this->product = $product;
        $this->collectionWithItems = $this->getCollectionsWithItems($product);
        $this->includesWithItems = $this->getIncludesCollectionsWithItems($product);
    }

    protected function productToObjectData(ProductInterface $product): object
    {
        return (object)[
            "id" => $product->id,
            "title" => $product->title,
            "slug" => $product->slug,
        ];
    }
}
