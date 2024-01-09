<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
?>

    <!-- Products-List-Wrapper -->
    <div class="table-wrapper u-s-m-b-60">
        @php $total_price = 0 @endphp
        @foreach($groupedProducts as $vendorShop => $items)
        <table>
            <thead> <h2></h2>
                <tr>
                    <th><?php echo $vendorShop; ?> Shop</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr> <?php 
                            $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                         ?>
                        <td>
                            <div class="cart-anchor-image">
                                <a href="{{ url('product/'.$item['product_id']) }}">
                                    <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                    <h6>{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }}) <br>
                                        Size: {{ $item['size'] }}<br>
                                    </h6>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="cart-price">
                                @if($getDiscountAttributePrice['discount']>0)
                                    <div class="price-template">
                                        <div class="item-new-price">
                                            ₱ {{ $getDiscountAttributePrice['final_price'] }}
                                        </div>
                                        <div class="item-old-price" style="margin-left:-40px;">
                                            ₱ {{ $getDiscountAttributePrice['selling_price'] }}
                                        </div>
                                    </div>
                                @else
                                    <div class="price-template">
                                        <div class="item-new-price">
                                            ₱ {{ $getDiscountAttributePrice['final_price'] }}
                                        </div>
                                    </div>
                                @endif    
                            </div>
                        </td>
                        <td>
                            <div class="cart-quantity">
                                <div class="quantity">
                                    <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                                    <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}"  data-qty="{{ $item['quantity'] }}"
                                        data-max="1000">&#43;</a>
                                    <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}"  data-qty="{{ $item['quantity'] }}"
                                       data-min="1">&#45;</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="cart-price">
                                    ₱ {{ $getDiscountAttributePrice['final_price'] * $item['quantity']}}
                            </div>
                        </td>
                        <td>
                            <div class="action-wrapper">
                                {{-- <button class="button button-outline-secondary fas fa-sync"></button> --}}
                                <button title="Delete" class="button button-outline-secondary fas fa-trash deleteCartItem" data-cartid="{{ $item['id'] }}"></button>
                            </div>
                        </td>
                    </tr>
                    {{-- Calculate the subtotal for each produuct by its desired quantity --}}
                    @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                @endforeach
            </tbody>   
        </table> <h4></h4>
        <div class="coupon-continue-checkout u-s-m-b-60">
            <div class="button-area">
                {{-- <a href="{{ url('/') }}" class="continue">Continue Shopping</a> --}}
                <input value="{{ $vendorShop }}" type="hidden" id="vendorid" data-vendorid="{{ $vendorShop }}" >
                <a href="{{ url('checkout/'.$vendorShop) }}"  class="storecheckout">Proceed to Checkout</a>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Products-List-Wrapper /- -->

    <!-- Billing -->
    <div class="calculation u-s-m-b-60">
        <div class="table-wrapper-2">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Cart Totals</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h3 class="calc-h3 u-s-m-b-0">Sub Total</h3>
                        </td>
                        <td>
                            <span class="calc-text">₱ {{ $total_price }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="calc-h3 u-s-m-b-0">Grand Total</h3>
                        </td>
                        <td>
                            <span class="calc-text">₱ {{ $total_price }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Billing /- -->
