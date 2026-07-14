<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\CategoryProduct\Models\Product;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ItemList extends Component
{
    public ProductCollectionModelInterface $collection;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $searchTitle = "";

    public Collection $productList;

    public function mount(): void
    {
        $this->freshProductList();
    }

    public function updatedSearchTitle(): void
    {
        $this->freshProductList();
    }

    public function render(): View
    {
        return view("pct::livewire.admin.collections.item-list-wire");
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth()) { return; }
        $this->displayData = true;
    }


    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    protected function freshProductList(): void
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        $this->productList = $modelClass::query()
            ->where("title", "LIKE", "%{$this->searchTitle}%")
            ->orderBy("title")
            ->limit(10)
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset("searchTitle");
    }

    protected function checkAuth(): bool
    {
        try {
            $this->authorize("update", $this->collection);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("products-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
