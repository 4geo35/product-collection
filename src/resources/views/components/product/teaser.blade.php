@props(["product", "isPreview" => false])
@php($url = route("web.product", ["product" => $product]))

<div class="p-indent-xs bg-white rounded-base shadow-md flex">
    <a href="{{ $url }}" class="shrink-0 block w-[98px] h-[98px] mr-indent-half rounded-base overflow-hidden">
        @if ($product->cover)
            <img src="{{ route('thumb-img', ['template' => 'product-collection-teaser', 'filename' => $product->cover->file_name]) }}"
                 class=""
                 alt="">
        @else
            @include("cp::web.catalog.includes.product.empty")
        @endif
    </a>
    <div class="flex-auto flex flex-col justify-between">
        <div class="flex items-start justify-between space-x-indent-xs mb-indent-xs">
            <a href="{{ $url }}" class="text-h5-mobile sm:text-h5 font-semibold hover:text-primary-hover">
                {{ $product->title }}
            </a>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                В корзину
            </button>
        </div>

        @php($chooseKey = "product-collection-item-variation-choose-{$product->id}-" . now()->timestamp)
        <livewire:pct-web-collection-product-teaser-choose-variation :$product :$isPreview wire:key="{{ $chooseKey }}" />
    </div>
</div>
