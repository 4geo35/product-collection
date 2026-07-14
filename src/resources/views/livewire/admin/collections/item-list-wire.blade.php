<div>
    <div class="card">
        <div class="card-header border-b-0">
            <div class="space-y-indent-half">
                @include("pct::admin.product-collections.includes.item-title")

                <x-tt::notifications.error prefix="products-" />
                <x-tt::notifications.success prefix="products-" />
            </div>
        </div>

        @include("pct::admin.product-collections.includes.item-table")
    </div>

    @include("pct::admin.product-collections.includes.item-modals")
</div>
