<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить коллекцию</x-slot>
    <x-slot name="text">Будет невозможно восстановить коллекцию!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $collectionId ? "Редактировать" : "Добавить" }} коллекцию</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $collectionId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="productCollectionDataForm">

            <div>
                <label for="title" class="inline-block mb-2">
                    Заголовок <span class="text-danger">*</span>
                </label>
                <input type="text" id="title"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="slug" class="inline-block mb-2">
                    Адресная строка
                </label>
                <input type="text" id="slug"
                       class="form-control {{ $errors->has("slug") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="slug">
                <x-tt::form.error name="slug"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="productCollectionDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $collectionId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
