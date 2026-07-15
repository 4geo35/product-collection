<?php

namespace GIS\ProductCollection\Observers;

use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use Illuminate\Support\Facades\Log;

class ProductCollectionObserver
{
    public function deleted(ProductCollectionModelInterface $collection): void
    {
        try {
            $collection->items()->detach();
        } catch (\Exception $e) { Log::error($e->getMessage()); }
        try {
            $collection->products()->detach();
        } catch (\Exception $e) { Log::error($e->getMessage()); }
    }
}
