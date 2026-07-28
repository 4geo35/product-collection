@props(["product", "isPreview" => false])
@php($url = route("web.product", ["product" => $product]))
@php($keyPostfix = $product->id . "-" . now()->timestamp . ($isPreview ? '-preview' : ''))

<div class="p-indent-xs bg-white rounded-base shadow-md flex flex-col sm:flex-row space-y-indent-half xs:space-y-indent-xs sm:space-y-0 {{ $isPreview ? 'lg:flex-col xl:flex-row lg:space-y-indent-xs xl:space-y-0' : '' }}">
    <div class="shrink-0 flex items-start justify-start">
        <a href="{{ $url }}" class="shrink-0 block w-[98px] h-[98px] mr-indent-half rounded-base overflow-hidden">
            @if ($product->cover)
                <img src="{{ route('thumb-img', ['template' => 'product-collection-teaser', 'filename' => $product->cover->file_name]) }}"
                     class=""
                     alt="">
            @else
                @include("cp::web.catalog.includes.product.empty")
            @endif
        </a>
        <a href="{{ $url }}" class="text-h5-mobile font-semibold xs:hidden">
            {{ $product->title }}
        </a>
    </div>
    <div class="flex-auto flex flex-col-reverse xs:flex-col justify-between">
        <div class="flex items-start justify-between space-x-indent-xs mb-0 mt-indent-half xs:mt-0 xs:mb-indent-xs">
            <a href="{{ $url }}" class="hidden xs:inline-block text-h5-mobile sm:text-h5 font-semibold hover:text-primary-hover">
                {{ $product->title }}
            </a>
            @php($cartKey = "product-collection-item-variation-add-to-cart-$keyPostfix")
            <livewire:pct-web-collection-product-teaser-variation-to-cart :$product :$isPreview wire:key="{{ $cartKey }}" />
        </div>

        @php($chooseKey = "product-collection-item-variation-choose-$keyPostfix")
        <livewire:pct-web-collection-product-teaser-choose-variation :$product :$isPreview wire:key="{{ $chooseKey }}" />
    </div>
</div>
