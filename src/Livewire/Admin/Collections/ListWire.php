<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public ProductInterface $product;

    public function render(): View
    {
        $collections = $this->product->orderedCollections;
        return view("pct::livewire.admin.collections.list-wire", compact("collections"));
    }

    public function test(): void
    {
        debugbar()->info($this->product);
        debugbar()->info($this->product->collections);
        debugbar()->info($this->product->collectionIncludes);
    }
}
