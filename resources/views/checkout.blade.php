<?php
$stylesheet = "checkout";

use App\Libraries\BasketHelper;

// Get cart items
if(Auth::check()){
    $cart = BasketHelper::fetchCart(auth()->user()->id);
}else{
    if(isset($_COOKIE['user_ip']))
    {
        $cart = BasketHelper::fetchCart($_COOKIE['user_ip']);
    }
}

// Subtotal
$subtotal = basketHelper::fetchCartSubTotal($cart);
?>
@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container">
            <h3>Checkout</h3>
            <h4>
                <?php
                if(count($cart) == 1)
                {
                ?>
                1 item
                <?php
                }else{
                    echo count($cart) . " items";
                }
                ?>
            </h4>
        </div>
    </div>
    <div class="bottomMain">
        <div class="container innerPart">
            @if (session('success'))
                <br />
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <br />
                <div class="alert alert-success">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('order.create') }}" method="post">
                <div class="row">
                <div class="leftProducts col-lg-8 col-xs-12">
                    <div class="module user-info col-lg-6 col-md-6"><br />
                        <div class="form-header">
                            <h3>Your Info</h3>
                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" name="fullname" class="form-control" placeholder="Fullname" value="<?php if(Auth::check()){ echo auth()->user()->name; } ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(Auth::check()){ echo auth()->user()->email; } ?>">
                            </div>
                        </div>
                    </div><br/>
                    <div class="module shipping-address col-lg-6 col-md-6">
                        <div class="form-header">
                            <h3>Shipping Address</h3>
                                <?php
                                $address = DB::table("account_addresses")->where("user_id", Auth::user()->id)->get();

                                if(count($address) > 0){
                                    ?>
                                    <select name="shipping_address" id="shipping_address">
                                        <?php
                                            foreach($address as $a){
                                        ?>
                                            <option value="<?php echo $a->id; ?>"><?php echo $a->address_one; ?><?php if($a->address_two != ""){ echo ', ' . $a->address_two; }; ?>, <?php echo $a->city; ?>, <?php echo $a->state; ?> <?php echo $a->zip_code; ?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <?php
                                }else{
                                    ?>
                                        <h4>You need to add an address to your account before placing your order</h4>
                                    <?php
                                }
                                ?>
                        </div>
                    </div>
                    <div style="display: none;" class="module payment-info col-lg-6"><br />
                        <div class="form-header">
                            <h3>Payment</h3><br />
                            <div class="form-group">
                                <label for="fullname">Credit Card Number</label>
                                <input type="text" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="Credit Card Number" value="">
                            </div>
                            <div class="form-group">
                                <label for="fullname">Credit Card CVV</label>
                                <input type="text" id="credit_card_cvv" name="credit_card_cvv" class="form-control" placeholder="Credit Card CVV" value="">
                            </div>
                            <div class="form-group">
                                <label for="fullname">Credit Card Exp Date</label>
                                <input type="text" id="credit_card_exp_date" name="credit_card_exp_date" class="form-control" placeholder="Credit Card Exp Date" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rightSummary col-lg-4 col-xs-12">
                    <div class="card" style="display: none;">
                        <div class="card-header">
                            <h4>Shipping Options</h4>
                        </div>
                        <div class="card-total">
                            <div class="innerShipping">
                                <p>Enter your address, then click the "Calculate Shipping" to view your shipping options</p>
                                <div class="shippingMod clearfix" style="display: none;">
                                    <div class="col-lg-1 shipping-actions">
                                        <input type="radio" name="shipping" value=""/>
                                    </div>
                                    <div class="col-lg-10 shipping-main">
                                        <div class="shipping-visible">
                                            <h3><b>USPS - First Class</b></h3>
                                            <h4><b>$7</b> &middot; Est Delivery: 2 days</h4>
                                        </div>
                                        <div class="shipping-hidden-info">
                                            <input type="hidden" id="shipping_rate-id" value="" />
                                            <input type="hidden" id="shipping_rate-service" value="" />
                                            <input type="hidden" id="shipping_rate-carrier" value="" />
                                            <input type="hidden" id="shipping_rate-price" value="" />
                                            <input type="hidden" id="shipping_rate-shipment_id" value="" >
                                            <input type="hidden" id="shipping_rate-est_delivery" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="ajax_token" value="{{ csrf_token() }}" />
                            <a class="btn btn-default" id="calculate_shipping">Calculate Shipping</a>
                        </div>
                    </div><br />
                    <div class="card hidden" id="order-total">
                        <div class="card-header">
                            <h4>Order Total</h4>
                        </div>
                        <div class="card-total">
                            <h3 id="order-total-number">$<?php echo $subtotal; ?></h3>
                            <h4>Includes shipping</h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('cart.index') }}" class="btn btn-default">Back to cart</a>
                            {{ csrf_field() }}

                            <input type="hidden" id="subtotal" value="<?php echo $subtotal; ?>" />
                            <button  class="btn btn-success pull-right">Place Order</button>
                        </div>
                    </div><br />
                    <div class="productsHold">
                        <h3>Cart</h3>
                        <?php
                        // Interate through all the products
                        foreach($cart as $items)
                        {
                        $product = DB::table('products')->where('id', $items->product_id)->get();

                        // Display product info
                        ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="<?php echo url('/'); ?>/products/single/<?php echo $product[0]->id; ?>">
                                    <img class="media-object thumbnail" src="<?php echo url("/"); ?>/images/<?php echo $product[0]->product_photo; ?>" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $product[0]->product_title; ?></h4>
                                <form action="<?php echo url('/'); ?>/cart/removeProduct" method="post">
                                    <h5>Size: <?php echo $items->product_size_number; ?></h5>
                                    <input type="hidden" name="cid" value="<?php echo $items->id; ?>" />
                                </form>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
    <script type="text/javascript">
        $(function () {
            // Get token
            $.get('{{ route('braintree.token') }}', function(data){
                var obj = jQuery.parseJSON(data);
                braintree.setup(obj.token, 'dropin', {
                    container: 'payment'
                });
            });
        });
    </script>
@endsection