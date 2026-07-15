@php($wordArray = ["товар", "товара", "товаров"])
<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Состав</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Ссылки</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($collections as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    @php($itemsCount = $item->orderedItems->count())
                    <div class="text-nowrap">
                        <span class="font-semibold">{{ $itemsCount }}</span> {{ num2word($itemsCount, $wordArray) }}
                    </div>
                </td>
                <td>
                    @php($productsCount = $item->products->count())
                    <div class="text-nowrap">
                        <span class="font-semibold">{{ $productsCount }}</span> {{ num2word($productsCount, $wordArray) }}
                    </div>
                </td>
                <td>
                    <div class="flex justify-center">
                        <a href="{{ route('admin.product-collections.show', ['collection' => $item]) }}"
                           class="btn btn-primary px-btn-x-ico rounded-e-none">
                            <x-tt::ico.eye />
                        </a>
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-none"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit/>
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $item) disabled
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
    <x-slot name="caption">
        <div class="flex justify-between">
            <div>{{ __("Total") }}: {{ $collections->total() }}</div>
            {{ $collections->links("tt::pagination.live") }}
        </div>
    </x-slot>
</x-tt::table>
