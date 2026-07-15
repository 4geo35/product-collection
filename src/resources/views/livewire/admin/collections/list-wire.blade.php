<div>
    <div class="card">
        <div class="card-header border-b-0">
            <div class="space-y-indent-half">
                @include("pct::admin.product-collections.includes.list-title")
                <x-tt::notifications.error prefix="product-collections-" />
                <x-tt::notifications.success prefix="product-collections-" />
            </div>
        </div>
        @include("pct::admin.product-collections.includes.list-table")
    </div>
    @include("pct::admin.product-collections.includes.list-modals")
    @include("pct::admin.product-collections.includes.list-order-modal")
</div>
