<div class="card">
    <div class="card-header border-b-0">
        <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
            Товары, в которых есть коллекция
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
            @foreach($collection->products()->orderBy("title")->get() as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>
                        <div class="flex items-center justify-center">
                            <a href="{{ route('admin.products.show', ['product' => $product]) }}"
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
