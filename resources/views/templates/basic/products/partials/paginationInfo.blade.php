<?php 
    $itemsPerPage = getPaginate(); // Set your desired number of items per page
    $pageNumber = $products->currentPage(); // Set the page number you want to retrieve

    $firstItemSerialNumber = (($pageNumber - 1) * $itemsPerPage) + 1;
    $lastItemSerialNumber = min($products->total(), ($pageNumber * $itemsPerPage));

    $totalRecords=$products->total();

    $totalPages=$products->lastPage();

    $url=url()->current();
?>

@if($info == 0) 
    Showing {{$firstItemSerialNumber}} to {{$lastItemSerialNumber}} of {{$totalRecords}} ({{$totalPages}} Pages)
@elseif($info == 1)
    <div class="sorting-selection">
        <span>Show:</span>
        <select class="form-control nice-select sort-select sort-using-page">
            @for($i =1; $totalPages >= $i; $i++ )
                <?php 
                    $sel=$pageNumber == $i ? 'selected' : '';
                ?>
                <option value="{{$url.'?page='.$i}}" {{$sel}}>{{ $i }}</option>
            @endfor
        </select>
    </div>
@elseif($info == 2)

    <div class="sorting-selection">
        
        <select class="form-control nice-select sort-select mr-0 sort-using-column">
            <option value="" selected disabled>@lang('Sort By')</option>
            <option value="id" {{$orderBy == 'id' ? 'selected' : ''}}>@lang('Latest')</option>
            <option value="price_asc" {{$orderBy == 'price_asc' ? 'selected' : ''}}>@lang('From low to high')</option>
            <option value="price_desc" {{$orderBy == 'price_desc' ? 'selected' : ''}}>@lang('From high to low')</option>
        </select>
    </div>

@endif