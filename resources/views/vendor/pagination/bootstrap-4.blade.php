
@if (request()->route()->getName() == 'subcategory.products') 
    @include('vendor.pagination._details.product')
@else
    @include('vendor.pagination._details.default')
@endif