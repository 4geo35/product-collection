<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
        {{ $collection->title }}
    </h2>

    <div class="flex justify-end">
        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                @cannot("update", $collection) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit({{ $collection->id }})">
            <x-tt::ico.edit/>
        </button>
        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                @cannot("delete", $collection) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showDelete({{ $collection->id }})">
            <x-tt::ico.trash/>
        </button>
    </div>
</div>
