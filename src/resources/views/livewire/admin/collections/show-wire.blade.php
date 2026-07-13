<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("pct::admin.product-collections.includes.show-title")
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Адресная строка</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $collection->slug }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include("pct::admin.product-collections.includes.table-modals")
</div>
