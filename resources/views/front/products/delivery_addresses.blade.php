
        <!-- Show existing Delivery Address /- -->
        <h4 class="section-h4 deliveryText">Add New Delivery Address</h4>
        <div class="u-s-m-b-24">
            <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent" />
            @if(count($deliveryAddresses)>0) 
                <label class="label-text newAddress" for="ship-to-different-address">Ship to a different address?</label>
            @else
                <label class="label-text newAddress" for="ship-to-different-address">Click to Add Delivery Address</label>
            @endif
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

