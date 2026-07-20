<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($productItems as $item)
            <tr>
                <td>
                    <div>{{ $item->title }}</div>
                    @if (! $item->published_at)
                        <div class="font-semibold text-xs text-danger text-nowrap">
                            Не опубликован
                        </div>
                    @endif
                </td>
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
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
