<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Товар</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($productItems as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    <div class="flex justify-center">
                        <a href="{{ route('admin.products.show', ['product' => $item]) }}"
                           class="btn btn-primary px-btn-x-ico rounded-e-none">
                            <x-tt::ico.eye />
                        </a>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $collection) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete()">
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
