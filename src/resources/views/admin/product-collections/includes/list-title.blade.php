<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
        Коллекции товара
    </h2>

    @can("update", $product)
        <div class="flex items-center space-x-2 ml-indent-half">
            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x" wire:click="showCreate">
                <x-tt::ico.circle-plus/>
                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
            </button>
            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x" wire:click="showOrder">
                <x-tt::ico.bars />
                <span class="hidden lg:inline-block pl-btn-ico-text">Порядок</span>
            </button>
        </div>
    @endcan
</div>
