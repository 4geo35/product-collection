@php(list($count, $list) = \GIS\ProductCollection\Facades\ProductCollectionActions::getShortItemList($product))
@if ($count)
    <div class="mt-indent-double mb-indent">
        <x-tt::h4 class="font-semibold">Добавить к покупке</x-tt::h4>
        <div class="mt-indent space-y-indent-xs">
            @foreach($list as $item)
                @php($product = \GIS\CategoryProduct\Facades\ProductActions::getTeaserData($item->id))
                <x-pct::product.teaser :$product :is-preview="true" />
            @endforeach
        </div>
    </div>
    @if ($count > config("product-collection.previewItemCount"))
        <div x-data>
            <button type="button"
                    @click="$dispatch('tab-collections', {}, { window: true })"
                    class="text-sm leading-tight font-medium text-primary hover:text-primary-hover border-b border-primary hover:border-primary-hover cursor-pointer flex items-center space-x-indent-half">
                <span>Показать еще</span> <x-tt::ico.arrow-right />
            </button>
        </div>
    @endif
@endif
