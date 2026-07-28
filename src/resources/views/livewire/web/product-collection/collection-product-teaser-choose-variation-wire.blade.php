@php($moreVariations = $variations->count() - 1)

<div class="w-full flex flex-col-reverse xs:flex-row items-start xs:items-end justify-between space-x-indent-xs">
    @if ($variation && $moreVariations)
        <div class="relative" x-data="{ show: false }">
            <div class="inline-flex items-center text-primary hover:text-primary-hover cursor-pointer"
                 @click="show = true" @click.outside="show = false">
                <div class="text-nowrap truncate text-sm">
                    {{ $variation->title }}
                </div>
                <x-tt::ico.arrow-down class="ml-2" />
            </div>
            <div class="select-variation py-2 absolute left-0 min-w-[150px] max-w-[300px] max-h-[200px] rounded-base bg-white shadow-lg border border-stroke beautify-scrollbar overflow-y-auto"
                 style="display: none" x-show="show" x-transition>
                @foreach($variations as $item)
                    <div class="group">
                        <input class="hidden peer" id="collectionProductVariation-{{ $item->sku }}{{ $isPreview ? '-preview' : '' }}"
                               type="radio" name="collectionProductVariation-{{ $item->product_id }}{{ $isPreview ? '-preview' : '' }}" value="{{ $item->id }}" wire:model.live="variationId">
                        <label class="flex items-center justify-between w-full px-indent-half py-1.5 text-sm font-semibold hover:bg-primary/5 cursor-pointer peer-checked:bg-primary/5 peer-checked:text-body/60 peer-checked:after:content-['✓'] peer-checked:after:ml-indent-half"
                               for="collectionProductVariation-{{ $item->sku }}{{ $isPreview ? '-preview' : '' }}" @click="show = false">
                            <span class="text-nowrap truncate">{{ $item->title }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($variation)
        <div class="flex items-start xs:items-end xs:ml-auto">
            <div class="text-h5-mobile sm:text-h5 font-semibold">
                {{ $variation->human_price }} р. <span class="text-body/60 text-sm">/ {{ $variation->unit_text }}</span>
            </div>
            @if ($variation->sale)
                <div class="text-sm line-through ml-indent-xs">
                    {{ $variation->human_old_price }} р.
                </div>
            @endif
        </div>
    @endif
</div>
