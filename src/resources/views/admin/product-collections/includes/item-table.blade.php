<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Товар</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($collection->items as $item)
            <tr>
                <td></td>
                <td>
                    <div class="flex justify-center">
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
