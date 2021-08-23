<?php
$stylesheet = "cart";

use App\Libraries\BasketHelper;

// Get cart items
if(Auth::check()){
    $cart = BasketHelper::fetchCart(auth()->user()->id);

    if(count($cart) != 0)
    {
        // Subtotal
        $subtotal = basketHelper::fetchCartSubTotal($cart);
    }else{
        $subtotal = "0";
    }
}else{
    if(isset($_COOKIE['user_ip']))
    {
        $cart = BasketHelper::fetchCart($_COOKIE['user_ip']);

        if(count($cart) != 0)
        {
            // Subtotal
            $subtotal = basketHelper::fetchCartSubTotal($cart);
        }else{
            $subtotal = "0";
        }
    }else{
        $cart = array();
    }
}
?>
@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
 <div class="mainProductBanner">
	<div class="innerProductBanner container">
		<h3>Cart</h3>
        <h4 style="text-align: center;">
            <?php
                if(count($cart) == 1)
                {
            ?>
                1 item
            <?php
                }else if (count($cart) == 0){
                    echo "0 Items";
                }else{
                    echo count($cart) . " items";
                }
            ?>
        </h4>
	</div>
</div>
 <div class="bottomMain" style="padding-top: 40px;">
	<div class="container innerPart">
        <div class="row">
		<div class="leftProducts col-lg-8 col-xs-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                                <p><?php echo substr($product[0]->product_desc, 0, 150); ?>...</p>
                                <form action="{{ route('cart.removeProduct') }}" method="post">
                                    <h5>Variant: <?php echo $items->product_size_number; ?></h5>
                                    <input type="hidden" name="cid" value="<?php echo $items->id; ?>" />
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger">Remove from Cart</button>
                                </form>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
        <div class="rightSummary col-lg-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cart Total</h4>
                </div>
                <div class="card-total">
                    <h3>$<?php echo $subtotal; ?></h3>
                    <h4>+ shipping</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cart.emptyCart') }}" method="post" style="margin-bottom: 0px;padding-bottom: 0px;">
                        {{ csrf_field() }}
                        <button class="btn btn-danger">Empty Cart</button>
                        <a href="{{ route('checkout.index') }}" class="btn btn-success pull-right">Checkout</a>
                    </form>
                </div>
            </div>
        </div>
        </div>
	</div>
 </div>
@endsection