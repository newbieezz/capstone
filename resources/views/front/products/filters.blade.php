<?php 
    use App\Models\ProductsFilter; 
    $productFilters = ProductsFilter::productFilters();
    // dd($productFilters);
?>
<!-- Shop-Left-Side-Bar-Wrapper -->
<div class="col-lg-3 col-md-3 col-sm-12">
    
    <!-- Filters -->
    <?php $getBrands = ProductsFilter::getBrands($url); ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Brand</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                <!-- display the size whatever is being added-->
                @foreach($getBrands as $key => $brands)
                <input type="checkbox" class="check-box brands" name="brands[]" id="brands{{$key}}" value="{{ $brands['id'] }}">
                <label class="label-text" for="brands{{$key}}">{{ $brands['name'] }}
                    {{-- <span class="total-fetch-items">(2)</span> --}}
                </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-Size Calling the function from productsFilter model -->
    <?php $getSizes = ProductsFilter::getSizes($url); ?>
    <div class="facet-filter-associates">
        <h3 class="title-name">Measurements</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                <!-- display the size whatever is being added-->
                @foreach($getSizes as $key => $size)
                <input type="checkbox" class="check-box size" name="size[]" id="size{{$key}}" value="{{ $size }}">
                <label class="label-text" for="size{{$key}}">{{ $size }}
                    {{-- <span class="total-fetch-items">(2)</span> --}}
                </label>
                @endforeach
            </div>
        </form>
    </div>
    <!-- Filter-PRICE -->
    {{-- <div class="facet-filter-associates">
        <h3 class="title-name">Price</h3>
        <form class="facet-form" action="#" method="post">
            <div class="associate-wrapper">
                <?php $prices = array('0-100','100-300','300-500','500-1000','1000-5000'); ?>
                <!-- display the prices-->
                @foreach($prices as $key => $price)
                <input type="checkbox" class="check-box price" name="price[]" id="price{{$key}}" value="{{ $price }}">
                <label class="label-text" for="price{{$key}}">₱ {{ $price }}
                    {{-- <span class="total-fetch-items">(2)</span> --}}
                {{-- </label>
                @endforeach
            </div>
        </form>
    </div> --}}
    <!-- Filter $productFilters-->
    @foreach($productFilters as $filter)
    {{-- calling the function filterAvailable passing with filter_id and category id withing tha categoryDetails array--}}
        <?php 
            $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $categoryDetails['categoryDetails'] ['id']);
        ?> {{-- If filterAvailable is yes then display, none if not--}}
        @if($filterAvailable=="Yes")
        @if(count($filter['filter_values']) > 0)
            <div class="facet-filter-associates">
                <h3 class="title-name">{{ $filter['filter_name'] }}</h3>
                <form class="facet-form" action="#" method="post">
                    <div class="associate-wrapper">
                        @foreach ($filter['filter_values'] as $value)
                            <input type="checkbox" class="check-box {{$filter['filter_column']}}" 
                                    id="{{ $value['filter_value'] }}" value="{{ $value['filter_value'] }}" name="{{ $filter['filter_column'] }}[]">
                            <label class="label-text" for="{{ $value['filter_value'] }}">{{ ucwords($value['filter_value']) }}
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
        @endif
        @endif
    @endforeach

</div>
<!-- Shop-Left-Side-Bar-Wrapper /- -->
