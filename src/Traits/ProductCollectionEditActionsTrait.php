<?php

namespace GIS\ProductCollection\Traits;

use GIS\ProductCollection\Interfaces\ProductCollectionModelInterface;
use GIS\ProductCollection\Models\ProductCollection;
use Illuminate\Auth\Access\AuthorizationException;

trait ProductCollectionEditActionsTrait
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $collectionId = null;

    public string $title = "";
    public string $slug = "";

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:250"],
            "slug" => ["nullable", "string", "max:250"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
        ];
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->collectionId = $modelId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", $model)) { return; }

        $this->title = (string) $model->title;
        $this->slug = (string) $model->slug;

        $this->displayData = true;
    }

    public function update(): void
    {
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", $model)) { return; }
        $this->validate();

        $slugHasChanged = $this->slug !== $model->slug;

        $model->update([
            "title" => trim($this->title),
            "slug" => trim($this->slug),
        ]);

        session()->flash("success", "Коллекция успешно обновлена");
        $this->closeData();
        if (isset($this->collection)) {
            $model->fresh();
            $this->collection = $model;
            if ($slugHasChanged) {
                $this->redirectRoute("admin.product-collections.show", ['collection' => $this->collection]);
            }
        }
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
        if (! $this->checkAuth("delete", $model)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("delete", $model)) { return; }

        try {
            $model->delete();
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении коллекции");
            $this->closeDelete();
            return;
        }

        session()->flash("success", "Коллекция успешно удалена");
        $this->closeDelete();
        if (method_exists($this, "resetPage")) { $this->resetPage(); }
        if (isset($this->collection)) {
            $this->redirectRoute("admin.product-collections.index");
        }
    }

    protected function findModel(): ?ProductCollectionModelInterface
    {
        $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
        $model = $modelClass::query()->find($this->collectionId);
        if (! $model) {
            session()->flash("error", "Коллекция не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $model;
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "collectionId");
    }

    protected function checkAuth(string $action, ?ProductCollectionModelInterface $modelObject = null): bool
    {
        try {
            $modelClass = config("product-collection.customProductCollectionModel") ?? ProductCollection::class;
            $this->authorize($action, $modelObject ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
