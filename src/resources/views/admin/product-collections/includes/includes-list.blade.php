<div class="card">
    <div class="card-header border-b-0">
        <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
            Коллекции, в которых есть товар
        </h2>
    </div>
    <x-tt::table>
        <x-slot name="head">
            <tr>
                <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
                <x-tt::table.heading>Действия</x-tt::table.heading>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($product->collectionIncludes()->orderBy("title")->get() as $collection)
                <tr>
                    <td>
                        <div>{{ $collection->title }}</div>
                    </td>
                    <td>
                        <div class="flex items-center justify-center">
                            <a href="{{ route('admin.product-collections.show', ['collection' => $collection]) }}"
                               class="btn btn-primary px-btn-x-ico">
                                <x-tt::ico.eye />
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-tt::table>
</div>
