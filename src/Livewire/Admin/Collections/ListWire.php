<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public ProductInterface $product;

    public bool $displayData = false;
    public bool $displayAdd = false;
    public bool $displayDelete = false;
    public bool $displayOrder = false;

    public int|null $collectionId = null;

    public string $searchTitle = "";

    public Collection $collectionList;

    public Collection|null $list = null;

    public function mount(): void
    {
        $this->freshCollectionList();
    }

    public function updatedSearchTitle(): void
    {
        $this->freshCollectionList();
    }

    public function render(): View
    {
        $collections = $this->product->orderedCollections;
        return view("pct::livewire.admin.collections.list-wire", compact("collections"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
        $this->freshCollectionList();
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
        $this->freshCollectionList();
    }

    public function showAddCollection(int $collectionId): void
    {
        $this->collectionId = $collectionId;
        $model = $this->findModel();
        if (! $model) { return; }
        $this->displayAdd = true;
    }

    public function addCollection(bool $visible = false): void
    {
        $this->displayAdd = false;
        $model = $this->findModel();
        if (! $model) { return; }

        $exists = $this->product->collections()->where("product_collection_id", $this->collectionId)->exists();
        if ($exists) {
            session()->flash("product-collections-modal-error", "Коллекция уже добавлена к товару");
            $this->freshCollectionList();
            return;
        }

        $latestItem = $this->product->collections()->orderByPivotDesc("priority")->first();
        if (! $latestItem) { $maxPriority = 0; }
        else { $maxPriority = $latestItem->pivot->priority; }
        $this->product->collections()->attach($this->collectionId, [
            "priority" => $maxPriority + 1,
            "visible" => $visible ? now() : null,
        ]);
        $this->freshCollectionList();
        session()->flash("product-collections-modal-success", "Коллекция добавлена к товару");
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->collectionId = $modelId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth()) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        if (! $this->checkAuth()) { return; }

        try {
            $this->product->collections()->detach($this->collectionId);
        } catch (\Exception $exception) {
            session()->flash("product-collections-error", "Ошибка при удалении коллекции");
            $this->closeDelete();
            return;
        }

        session()->flash("product-collections-success", "Коллекция успешно удалена из товара");
        $this->closeDelete();
        $this->freshCollectionList();
    }

    public function showOrder(): void
    {
        if (! $this->checkAuth()) { return; }
        $this->displayOrder = true;
        $this->setItemList();
        $this->dispatch("update-list-product-collections");
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth()) { return; }

        foreach ($newOrder as $priority => $id) {
            $this->product->collections()->updateExistingPivot($id, [
                "priority" => $priority
            ]);
        }

        $this->resetFields();
        $this->setItemList();
        $this->freshCollectionList();
    }

    public function toggleVisible(int $collectionId): void
    {
        $this->collectionId = $collectionId;
        $model = $this->findModel();
        if (! $model) { return; }
        $current = $this->product->collections()->where("product_collection_id", $this->collectionId)->first();
        if (! $current) { return; }
        $currentVisible = $current->pivot->visible;
        $this->product->collections()->updateExistingPivot($this->collectionId, [
            "visible" => $currentVisible ? null : now(),
        ]);
    }

    protected function setItemList(): void
    {
        $this->list = $this->product->orderedCollections;
    }

    protected function freshCollectionList(): void
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $existingCollections = DB::table("product_collection_item")
            ->select("product_collection_id")
            ->where("product_id", $this->product->id);
        $this->collectionList = $modelClass::query()
            ->leftJoinSub($existingCollections, "exists", function ($join) {
                $join->on("product_collections.id", "=", "exists.product_collection_id");
            })
            ->whereNull("product_collection_id")
            ->where("title", "LIKE", "%{$this->searchTitle}%")
            ->orderBy("title")
            ->limit(10)
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset("searchTitle", "collectionId");
    }

    protected function findModel(): ?ProductCollectionModelInterface
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $model = $modelClass::query()->find($this->collectionId);
        if (! $model) {
            session()->flash("product-collections-error", "Коллекция не найдена");
            $this->closeData();
            $this->closeDelete();
            $this->freshCollectionList();
            return null;
        }
        return $model;
    }

    protected function checkAuth(): bool
    {
        try {
            $this->authorize("update", $this->product);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("product-collections-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
