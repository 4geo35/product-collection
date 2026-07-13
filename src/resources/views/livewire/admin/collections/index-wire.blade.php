<div class="card">
    <div class="card-body">
        @include("pct::admin.product-collections.includes.search")
        <x-tt::notifications.error />
        <x-tt::notifications.success />
    </div>
    @include("pct::admin.product-collections.includes.table")
    @include("pct::admin.product-collections.includes.table-modals")
</div>
