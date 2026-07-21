@php(list($count, $list) = \GIS\ProductCollection\Facades\ProductCollectionActions::getShortItemList($product))
@if ($count > config("product-collection.previewItemCount"))
    <x-tt::tabs.item name="collections" active="btn-primary" passive="btn-outline-primary"
                     class="w-full btn cursor-pointer">
        Рекомендуемые
    </x-tt::tabs.item>
@endif
