<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить коллекцию у товара</x-slot>
    <x-slot name="text">Коллекция перестанет отображаться на странице товара!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">Добавить коллекцию</x-slot>
    <x-slot name="content">
        <div class="space-y-indent-half">
            <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
                <input type="text" aria-label="Заголовок" placeholder="Заголовок" class="form-control"
                       wire:model.live="searchTitle">
                <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
                    Очистить
                </button>
            </div>

            <x-tt::notifications.error prefix="product-collections-modal-" />
            <x-tt::notifications.success prefix="product-collections-modal-" />

            <ul>
                @if (!$collectionList->count())
                    <li class="py-2">
                        По вашему запросу ничего не нашлось. Возможно, коллекции, которые вас интересуют, уже добавлены к товару.
                    </li>
                @endif
                @foreach($collectionList as $collectionItem)
                    <li class="py-2 border-b border-secondary last-of-type:border-b-0">
                        <div class="flex items-start justify-between space-x-indent-half">
                            @if ($displayAdd && $collectionId == $collectionItem->id)
                                <div class="font-semibold">Сделать товар видимым для товаров коллекции?</div>
                                <div class="flex items-center justify-end space-x-2">
                                    <button type="button"
                                            wire:click="addCollection(false)"
                                            class="text-dark hover:text-dark-hover font-semibold cursor-pointer">
                                        Нет
                                    </button>
                                    <button type="button"
                                            wire:click="addCollection(true)"
                                            class="text-success hover:text-success-hover font-semibold cursor-pointer">
                                        Да
                                    </button>
                                </div>
                            @else
                                <a href="{{ route('admin.product-collections.show', ['collection' => $collectionItem]) }}"
                                   target="_blank"
                                   class="font-semibold hover:text-primary-hover">
                                    {{ $collectionItem->title }}
                                </a>
                                <button type="button"
                                        wire:loading.attr="disabled"
                                        wire:click="showAddCollection({{ $collectionItem->id }})"
                                        class="cursor-pointer text-success hover:text-success-hover">
                                    <x-tt::ico.circle-plus/>
                                </button>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-slot>
</x-tt::modal.dialog>
