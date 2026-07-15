<?php

namespace GIS\ProductCollection\Observers;

use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;

class ProductCollectionObserver
{
    public function deleted(ProductCollectionModelInterface $collection): void
    {
        // TODO: clear relations
    }
}
