<x-tt::modal.dialog wire:model="displayOrder">
    <x-slot name="title">Порядок коллекций товара</x-slot>
    <x-slot name="content">
        @if ($list)
            <x-tt::table drag-root-product-collections>
                <x-slot name="head">
                    <tr>
                        <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($list as $key => $item)
                        <tr drag-item="{{ $item->id }}" drag-item-order="{{ $key }}" wire:key="{{ $item->id }}">
                            <td>
                                <div class="flex items-center">
                                    <x-tt::ico.bars drag-grab class="text-secondary cursor-grab mr-indent"/>
                                    <span class="text-nowrap">{{ $item->title }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-tt::table>
        @endif
    </x-slot>
</x-tt::modal.dialog>

@include("tt::admin.draggable-script", ["postfix" => "-product-collections"])
