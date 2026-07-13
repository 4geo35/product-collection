<?php

namespace GIS\ProductCollection\Livewire\Admin\Collections;

use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use GIS\ProductCollection\Traits\ProductCollectionEditActionsTrait;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use ProductCollectionEditActionsTrait;

    public string $searchTitle = "";

    public function render(): View
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $query = $modelClass::query();
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        $query->orderBy("created_at", "DESC");
        $collections = $query->paginate();
        return view("pct::livewire.admin.collections.index-wire", compact("collections"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $modelClass::query()->create([
            "title" => trim($this->title),
        ]);

        session()->flash("success", "Коллекция успешно добавлена");
        $this->closeData();
    }
}
