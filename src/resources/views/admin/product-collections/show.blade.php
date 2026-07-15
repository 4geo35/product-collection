<x-admin-layout>
    <x-slot name="title">Просмотр коллекции товаров</x-slot>
    <x-slot name="pageTitle">Просмотр коллекции товаров</x-slot>

    <div class="space-y-indent-half">
        <livewire:pct-admin-product-collections-show :$collection />
        <livewire:pct-admin-product-collections-items-list :$collection />
        @include("pct::admin.product-collections.includes.related-list")
    </div>
</x-admin-layout>
