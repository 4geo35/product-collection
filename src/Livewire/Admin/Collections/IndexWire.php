<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public function render(): View
    {
        return view("pct::livewire.admin.collections.index-wire");
    }
}
