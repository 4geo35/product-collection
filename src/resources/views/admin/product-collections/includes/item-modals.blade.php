<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">Добавить товар</x-slot>
    <x-slot name="content">
        <div class="space-y-indent-half">
            <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
                <input type="text" aria-label="Заголовок" placeholder="Заголовок" class="form-control"
                       wire:model.live="searchTitle">
                <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
                    Очистить
                </button>
            </div>

            <x-tt::notifications.error prefix="products-modal-" />
            <x-tt::notifications.success prefix="products-modal-" />

            <ul>
                @foreach($productList as $productItem)
                    <li class="py-2 border-b border-secondary last-of-type:border-b-0">
                        <div class="flex items-start justify-between space-x-indent-half">
                            <a href="{{ route('admin.products.show', ['product' => $productItem]) }}"
                               target="_blank"
                               class="font-semibold hover:text-primary-hover">
                                {{ $productItem->title }}
                            </a>
                            <button type="button"
                                    wire:loading.attr="disabled"
                                    wire:click="addProduct({{ $productItem->id }})"
                                    class="cursor-pointer text-success hover:text-success-hover">
                                <x-tt::ico.circle-plus/>
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-slot>
</x-tt::modal.dialog>
