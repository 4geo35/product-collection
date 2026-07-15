<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Видимость</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($collections as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    <span class="text-nowrap">
                        Товар <span class="font-semibold">{{ $item->pivot->visible ? "виден" : "не виден" }}</span> для товаров коллекции
                    </span>
                </td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-outline-dark mr-indent-half"
                                @cannot("update", $product) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="toggleVisible({{ $item->id }})">
                            Переключить видимость
                        </button>

                        <a href="{{ route('admin.product-collections.show', ['collection' => $item]) }}"
                           target="_blank"
                           class="btn btn-primary px-btn-x-ico rounded-e-none">
                            <x-tt::ico.eye />
                        </a>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $product) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
