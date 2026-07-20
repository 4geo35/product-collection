<div class="mt-indent">
    @php(list($count, $list) = \GIS\ProductCollection\Facades\ProductCollectionActions::getShortItemList($product))
    Hello {{ $count }}
</div>
