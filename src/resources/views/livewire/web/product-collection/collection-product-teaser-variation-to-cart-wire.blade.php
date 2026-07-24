<div class="shrink-0 {{ ! $variationId ? 'hidden' : '' }}">
    @if ($variationId)
        @if (! $quantity)
            <div class="flex flex-col items-end">
                <button type="button" class="btn btn-sm btn-outline-secondary shrink-0"
                        wire:click="addToCart" wire:loading.attr="disabled">
                    В корзину
                </button>
                @if ($variation && $variation->minimal_order)
                    <div class="mt-indent-xs text-body/60 text-xs">
                        Минимум <span class="text-nowrap font-semibold">{{ $variation->minimal_order }} {{ $variation->unit_text }}</span>
                    </div>
                @endif
            </div>
        @else
            <div class="btn btn-sm px-btn-x-ico cursor-default text-sm text-secondary border-secondary"
                 wire:loading.class="opacity-25">
                <button type="button" class="cursor-pointer text-secondary hover:text-primary-hover"
                        wire:click="decreaseQuantity" wire:loading.attr="disabled" wire:loading.class="cursor-default">
                    <x-vc::ico.minus width="20" height="20" />
                </button>
                <div class="mx-2.5">В корзине ({{ $quantity }})</div>
                <button type="button" class="cursor-pointer text-secondary hover:text-primary-hover"
                        wire:click="increaseQuantity" wire:loading.attr="disabled" wire:loading.class="cursor-default">
                    <x-vc::ico.plus width="20" height="20" />
                </button>
            </div>
        @endif
    @endif
</div>
