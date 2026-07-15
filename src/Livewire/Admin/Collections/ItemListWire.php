<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Models\Product;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class ItemListWire extends Component
{
    public ProductCollectionModelInterface $collection;

    public bool $displayData = false;
    public bool $displayDelete = false;
    public bool $displayOrder = false;

    public int|null $productId = null;

    public string $searchTitle = "";

    public Collection $productList;

    public Collection|null $list = null;
    public bool $hasSearch = false;

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
        $productItems = $this->collection->orderedItems;
        return view("pct::livewire.admin.collections.item-list-wire", compact("productItems"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
        $this->freshProductList();
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

    public function addProduct(int $productId): void
    {
        $this->productId = $productId;
        $model = $this->findModel();
        if (! $model) { return; }

        $exists = $this->collection->items()->where('product_id', $productId)->exists();
        if ($exists) {
            session()->flash("products-modal-error", "Товар уже добавлен в коллекцию");
            $this->freshProductList();
            return;
        }

        $latestItem = $this->collection->items()->orderByPivotDesc('priority')->first();
        if (! $latestItem) { $maxPriority = 0; }
        else { $maxPriority = $latestItem->pivot->priority; }
        $this->collection->items()->attach($productId, [
            "priority" => $maxPriority + 1,
        ]);
        $this->freshProductList();
        session()->flash("products-modal-success", "Товар добавлен в коллекцию");
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->productId = $modelId;
        if (! $this->checkAuth()) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        if (! $this->checkAuth()) { return; }

        try {
            $this->collection->items()->detach($this->productId);
        } catch (\Exception $exception) {
            session()->flash("products-error", "Ошибка при удалении товара");
            $this->closeDelete();
            return;
        }

        session()->flash("products-success", "Товар успешно удален из коллекции");
        $this->closeDelete();
        $this->freshProductList();
    }

    public function showOrder(): void
    {
        if (! $this->checkAuth()) { return; }
        $this->displayOrder = true;
        $this->setItemList();
        $this->dispatch("update-list");
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth()) { return; }

        foreach ($newOrder as $priority => $id) {
            $this->collection->items()->updateExistingPivot($id, [
                "priority" => $priority
            ]);
        }

        $this->resetFields();
        $this->setItemList();
        $this->freshProductList();
    }

    protected function setItemList(): void
    {
        $this->list = $this->collection->orderedItems;
    }

    protected function freshProductList(): void
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        $existingProducts = DB::table("collection_product_item")
            ->select("product_id")
            ->where("product_collection_id", $this->collection->id);
        $this->productList = $modelClass::query()
            ->leftJoinSub($existingProducts, 'exists', function ($join) {
                $join->on("products.id", "=", "exists.product_id");
            })
            ->whereNull("product_id")
            ->where("title", "LIKE", "%{$this->searchTitle}%")
            ->orderBy("title")
            ->limit(10)
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset("searchTitle");
    }

    protected function findModel(): ?ProductInterface
    {
        $modelClass = config("category-product.customProductModel") ?? Product::class;
        $model = $modelClass::query()->find($this->productId);
        if (! $model) {
            session()->flash("products-modal-error", "Товар не найден");
            $this->closeData();
            $this->closeDelete();
            $this->freshProductList();
            return null;
        }
        return $model;
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
