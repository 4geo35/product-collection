@php
    $productCollections = \GIS\ProductCollection\Facades\ProductCollectionActions::getItemListByCollections($product)
@endphp
<x-tt::tabs.content name="collections">
    <x-slot name="title">Рекомендуемые</x-slot>

    <div class="flex flex-col gap-y-indent">
        @foreach($productCollections as $collection)
            @if ($collection->title)
                <x-tt::h4>{{ $collection->title }}</x-tt::h4>
            @endif
            <div class="space-y-indent-half">
                @foreach($collection->items as $item)
                    <div>{{ $item->title }}</div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-tt::tabs.content>
