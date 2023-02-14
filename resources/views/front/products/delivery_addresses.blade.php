{{--check if the array comes --}}
    @if(count($deliveryAddresses)>0) 
        <h4 class="section-h4">Delivery Details</h4>
        @foreach($deliveryAddresses as $address)
            <div class="control-group" style="float:left; margin-right:8px;"><input type="radio" name="address_id" id="address{{ $address['id'] }}" value="{{ $address['id'] }}" /></div>
            <div>
                <label class="control-label">
                    {{ $address['name'] }} , {{ $address['address'] }} , {{ $address['city'] }} ( {{ $address['mobile'] }} )
                </label>
                <a style="float:right; margin-left:10px" href="javascript:;" data-addressid="{{ $address['id'] }}"
                    class="removeAddress">Remove</a>
                <a style="float:right;" href="javascript:;" data-addressid="{{ $address['id'] }}"
                    class="editAddress">Edit</a>
            </div>
            <br />
        @endforeach <br />
        <!-- Show existing Delivery Address /- -->
        <h4 class="section-h4 deliveryText">Add New Delivery Address</h4>
        <div class="u-s-m-b-24">
            <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent" />
            <label class="label-text newAddress" for="ship-to-different-address">Ship to a different address?</label>
        </div>
        <div class="collapse" id="showdifferent">
            <form id="addressAddEditForm" action="javascript:;" method="post"> @csrf
                <input type="hidden" name="delivery_id">
                <!-- Form-Fields -->
                <div class="group-inline u-s-m-b-13">
                    <div class="group-1 u-s-p-r-16">
                        <label for="first-name-extra">
                            Name
                            <span class="astk">*</span>
                        </label>
                        <input type="text" name="delivery_name" id="delivery_name" class="text-field" />
                        <p id="delivery-delivery_name"></p>
                    </div>
                    <div class="group-2">
                        <label for="last-name-extra">
                            Mobile Number
                            <span class="astk">*</span>
                        </label>
                        <input type="text" name="delivery_mobile" id="delivery_mobile" class="text-field" />
                        <p id="delivery-delivery_mobile"></p>
                    </div>
                </div>
                <div class="street-address u-s-m-b-13">
                    <label for="req-st-address-extra">
                        Address
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_address" id="delivery_address" class="text-field" placeholder="House name and street name" />
                    <p id="delivery-delivery_address"></p>
                </div>
                <div class="u-s-m-b-13">
                    <label for="town-city-extra">
                        Town / City
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_city" id="delivery_city" class="text-field" />
                    <p id="delivery-delivery_city"></p>
                </div>
                <div class="group-inline u-s-m-b-13">
                    <div class="group-1 u-s-p-r-16">
                        <label for="email-extra">
                            Email address
                            <span class="astk">*</span>
                        </label>
                        <input type="text" name="delivery_email" id="delivery_email" class="text-field" />
                        <p id="delivery-delivery_email"></p>
                    </div>
                </div>
                {{-- Save Button --}}
                <div class="u-s-m-b-13">
                    <button type="submit" id="btnDelivery" class="button button-outline-secondary" style="width:100%;"
                        >Save</button>
                </div>
            </form>
            <!-- Form-Fields /- -->
        </div>
        <div>
            <label for="order-notes">Order Notes</label>
            <textarea class="text-area" id="order-notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
        </div>

    @else
    <!-- If No delivery Address then Add /- -->
        <h4 class="section-h4">Add New Delivery Address</h4>
        <!-- Form-Fields -->
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name">
                    First Name
                    <span class="astk">*</span>
                </label>
                <input type="text" id="first-name" class="text-field" />
            </div>
            <div class="group-2">
                <label for="last-name">
                    Last Name
                    <span class="astk">*</span>
                </label>
                <input type="text" id="last-name" class="text-field" />
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="select-country">
                Country
                <span class="astk">*</span>
            </label>
            <div class="select-box-wrapper">
                <select class="select-box" id="select-country">
                    <option selected="selected" value="">Choose your country...</option>
                    <option value="">United Kingdom (UK)</option>
                    <option value="">United States (US)</option>
                    <option value="">United Arab Emirates (UAE)</option>
                </select>
            </div>
        </div>
        <div class="street-address u-s-m-b-13">
            <label for="req-st-address">
                Street Address
                <span class="astk">*</span>
            </label>
            <input type="text" id="req-st-address" class="text-field" placeholder="House name and street name" />
            <label class="sr-only" for="opt-st-address"></label>
            <input type="text" id="opt-st-address" class="text-field" placeholder="Apartment, suite unit etc. (optional)" />
        </div>
        <div class="u-s-m-b-13">
            <label for="town-city">
                Town / City
                <span class="astk">*</span>
            </label>
            <input type="text" id="town-city" class="text-field" />
        </div>
        <div class="u-s-m-b-13">
            <label for="select-state">
                State / Country
                <span class="astk"> *</span>
            </label>
            <div class="select-box-wrapper">
                <select class="select-box" id="select-state">
                    <option selected="selected" value="">Choose your state...</option>
                    <option value="">Alabama</option>
                    <option value="">Alaska</option>
                    <option value="">Arizona</option>
                </select>
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="postcode">
                Postcode / Zip
                <span class="astk">*</span>
            </label>
            <input type="text" id="postcode" class="text-field" />
        </div>
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="email">
                    Email address
                    <span class="astk">*</span>
                </label>
                <input type="text" id="email" class="text-field" />
            </div>
            <div class="group-2">
                <label for="phone">
                    Phone
                    <span class="astk">*</span>
                </label>
                <input type="text" id="phone" class="text-field" />
            </div>
        </div>
    @endif