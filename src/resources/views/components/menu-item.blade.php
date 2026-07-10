@can("viewAny", config("product-collection.customProductCollectionModel") ?? \GIS\ProductCollection\Models\ProductCollection::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.product-collections.index') }}"
        :active="in_array(Route::currentRouteName(), ['admin.product-collections.index', 'admin.product-collections.show'])">
        <x-slot name="ico"><x-pct::ico.more /></x-slot>
        Коллекции товаров
    </x-tt::admin-menu.item>
@endcan
