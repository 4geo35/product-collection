<?php

namespace GIS\ProductCollection\Livewire\Web\Collections;

use GIS\ProductVariation\Traits\InitFirstVariation;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CollectionProductTeaserChooseVariationWire extends Component
{
    use InitFirstVariation;

    public bool $isPreview = false;

    public function mount(): void
    {
        $this->setFirstVariation();
    }

    public function updatedVariationId($value): void
    {
        $this->variation = $this->variations->find($value);
        $this->changeVariationEvent();
    }

    public function render(): View
    {
        return view("pct::livewire.web.product-collection.collection-product-teaser-choose-variation-wire");
    }

    #[On("switch-collection-variation")]
    public function processChangeVariationEvent(int $variationId, int $productId): void
    {
        if ($this->product->id != $productId) { return; }
        if ($this->variationId == $variationId) { return; }
        $result = $this->variations->find($variationId);
        if (!$result) { return; }
        $this->variation = $result;
        $this->variationId = $this->variation->id;
    }

    protected function changeVariationEvent(): void
    {
        $this->dispatch("switch-collection-variation", $this->variationId, $this->product->id);
    }
}
