<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Traits\ProductCollectionEditActionsTrait;
use Illuminate\View\View;
use Livewire\Component;

class ShowWire extends Component
{
    use ProductCollectionEditActionsTrait;

    public ProductCollectionModelInterface $collection;

    public function render(): View
    {
        return view("pct::livewire.admin.collections.show-wire");
    }
}
