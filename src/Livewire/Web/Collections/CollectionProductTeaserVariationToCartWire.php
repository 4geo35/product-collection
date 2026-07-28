<?php

namespace GIS\ProductCollection\Livewire\Web\Collections;

use GIS\VariationCart\Traits\ChangeVariationCartQuantityTrait;
use GIS\ProductVariation\Traits\InitFirstVariation;
use GIS\VariationCart\Facades\CartActions;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CollectionProductTeaserVariationToCartWire extends Component
{
    use InitFirstVariation, ChangeVariationCartQuantityTrait;

    public int $quantity = 0;

    public function mount(): void
    {
        $this->setFirstVariation();
        if ($this->variationId) {
            $this->quantity = CartActions::getCartItemQuantity($this->variationId);
        }
    }

    public function updated($property, $value): void
    {
        if ($property === 'quantity' && $value <= 0) {
            $this->quantity = 0;
        }
    }

    public function render(): View
    {
        return view("pct::livewire.web.product-collection.collection-product-teaser-variation-to-cart-wire");
    }

    #[On("switch-collection-variation")]
    public function setVariation(int $variationId, int $productId): void
    {
        if ($this->product->id != $productId) { return; }
        if ($this->variationId == $variationId) { return; }
        $this->reset("quantity", "variationId");
        $result = $this->variations->find($variationId);
        if (! $result) { return; }
        $this->variation = $result;
        $this->variationId = $variationId;
        $this->quantity = CartActions::getCartItemQuantity($variationId);
    }
}
