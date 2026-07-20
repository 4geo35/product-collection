<?php

namespace GIS\ProductCollection\Helpers;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ProductCollectionActionsManager
{
    public function getShortItemList(ProductInterface $product): array
    {
        $items = $this->getTotalItemList($product);
        $count = count($items);

        debugbar()->info($items);
        return [$count, $items];
    }

    public function getTotalItemList(ProductInterface $product): array
    {
        $items = [];

        $includes = $this->getIncludesCollectionsWithItems($product);
        foreach ($includes as $collection) {
            foreach ($collection->products as $item) {
                if (! $item->published_at) { continue; }
                if (! $item->pivot->visible) { continue; }
                if (! empty($item[$item->id])) { continue; }
                $items[$item->id] = (object)[
                    "id" => $item->id,
                    "title" => $item->title,
                    "slug" => $item->slug,
                ];
            }
        }

        $collections = $this->getCollectionsWithItems($product);
        foreach ($collections as $collection) {
            foreach ($collection->orderedItems as $item) {
                if (! $item->published_at) { continue; }
                if (! empty($item[$item->id])) { continue; }
                $items[$item->id] = (object)[
                    "id" => $item->id,
                    "title" => $item->title,
                    "slug" => $item->slug,
                ];
            }
        }

        return $items;
    }

    public function getIncludesCollectionsWithItems(ProductInterface $product): EloquentCollection
    {
        $includes = $product->collectionIncludes()
            ->select("id", "title", "slug")
            ->with(["products" => function ($query) {
                $query->select("id", "title", "slug", "published_at")
                    ->orderBy("title", "DESC");
            }])
            ->get();
        // TODO: make cache
        return $includes;
    }

    public function getCollectionsWithItems(ProductInterface $product): EloquentCollection
    {
        $collections = $product->orderedCollections()
            ->select("id", "title", "slug")
            ->with(["orderedItems" => function ($query) {
                $query->select("id", "title", "slug", "published_at");
            }])
            ->get();
        // TODO: make cache
        return $collections;
    }
}
