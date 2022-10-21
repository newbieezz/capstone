<?php 
    use App\Models\ProductsFilter; 
    $productFilters = ProductsFilter::productFilters();
    // dd($productFilters);
?>
@foreach($productFilters as $filter)
@if(isset($category_id))
    {{-- calling the function filterAvailable passing with filter_id and category id withing tha categoryDetails array--}}
    <?php 
        $filterAvailable = ProductsFilter::filterAvailable($filter['id'], $category_id);
    ?> {{-- If filterAvailable is yes then display, none if not--}}
        @if($filterAvailable=="Yes")
            <div class="form-group">
                <label for="{{ $filter['filter_column'] }}">Select {{ $filter['filter_name'] }}</label>
                <select name="{{ $filter['filter_column'] }}" id="{{ $filter['filter_column'] }}" class="form-control text-dark" >
                    <option value="">Select</option>
                    @foreach($filter['filter_values'] as $value) <!--BRANDS -->
                        <option value="{{ $value['filter_value'] }}">{{ ucwords($value['filter_value']) }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endif
@endforeach