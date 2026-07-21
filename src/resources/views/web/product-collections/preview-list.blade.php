@php(list($count, $list) = \GIS\ProductCollection\Facades\ProductCollectionActions::getShortItemList($product))
@if ($count)
    <div class="mt-indent mb-indent space-y-indent-half">
        @foreach($list as $item)
            <div>
                {{ $item->title }} ({{ $item->id }})
            </div>
        @endforeach
    </div>
    @if ($count > config("product-collection.previewItemCount"))
        <div x-data>
            <button type="button"
                    @click="$dispatch('tab-collections', {}, { window: true })"
                    class="text-primary hover:text-primary-hover cursor-pointer">
                Показать еще
            </button>
        </div>
    @endif
@endif
