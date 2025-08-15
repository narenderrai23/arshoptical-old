
<style>
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
.col-sm-6{width:50% !important;}
}
</style>

<div class="container">
    <div class="shop-toolbar mb--30">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-6">
                <!-- Product View Mode -->
                <div class="product-view-mode">
                    <a href="#" class="sorting-btn" data-target="grid"><i class="fas fa-th"></i></a>
                    <a href="#" class="sorting-btn active" data-target="grid-four">
                        <span class="grid-four-icon">
                            <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                        </span>
                    </a>
                   <!--  <a href="#" class="sorting-btn" data-target="list "><i class="fas fa-list"></i></a> -->
                </div>
            </div>
            <div class="col-xl-5 col-md-4 col-sm-12  mt--10 mt-sm--0">
                <span class="toolbar-status page-info">
                    @include('templates.basic.products.partials.paginationInfo', [
                        'product' => $products,
                        'info'    =>0
                    ])
                </span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                @include('templates.basic.products.partials.paginationInfo', [
                    'product' => $products,
                    'info'    =>1
                ])
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                @include('templates.basic.products.partials.paginationInfo', [
                    'product' => $products,
                    'info'    =>2
                ])
            </div>
        </div>
    </div>
    <div class="shop-toolbar d-none">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-6">
                <!-- Product View Mode -->
                <div class="product-view-mode">
                    <a href="#" class="sorting-btn " data-target="grid"><i class="fas fa-th"></i></a>
                    <a href="#" class="sorting-btn active" data-target="grid-four">
                        <span class="grid-four-icon">
                            <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                        </span>
                    </a>
                    <a href="#" class="sorting-btn" data-target="list "><i class="fas fa-list"></i></a>
                </div>
            </div>
            <div class="col-xl-5 col-md-4 col-sm-12  mt--10 mt-sm--0">
                <span class="toolbar-status page-info">
                    @include('templates.basic.products.partials.paginationInfo', [
                        'product' => $products,
                        'info'    =>0
                    ])
                </span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6  mt--10 mt-md--0">
                @include('templates.basic.products.partials.paginationInfo', [
                    'product' => $products,
                    'info'    =>1
                ])
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                @include('templates.basic.products.partials.paginationInfo', [
                    'product' => $products,
                    'info'    =>2
                ])
            </div>
        </div>
    </div>

    @if ($products->count() > 0)
        <div class="shop-product-wrap with-pagination row space-db--30 shop-border grid-four">
            @include('templates.basic.products.partials.product', [
                'products' => $products,
            ])
        </div>
    @endif

    {{ $products->links() }}
</div>