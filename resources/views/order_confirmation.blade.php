
<?php
$stylesheet = "order_summary";

use App\Libraries\OrderingSystem;

// Fetch order
$order = OrderingSystem::fetchOrder($order_id);

// Fetch address
$address = json_decode($order[0]->order_address, true);

// Fetch products
$products = json_decode($order[0]->order_products, true);

// Shipping
$shipping = json_decode($order[0]->order_shipping);

?>
@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container">
            <h3>Order Summary</h3>
            <?php if($order[0]->order_status == "paid" or $order[0]->order_status == "unpaid"){ ?>
                <h4>Order processing</h4>
            <?php } else if($order[0]->order_status == "shipped"){ ?>
                <h4>Order shipped!</h4>
            <?php } ?>
        </div>
    </div>
    <div class="bottomMain">
        <div class="innerPart container">
            <div class="row">
            <div class="leftShipping col-lg-6 col-xs-12">
                <div class="module">
                    <h3>Shipping address</h3>
                    <div class="innerMod">
                        <ul>
                            <li><b>Address 1:</b> <?php echo $address['address1']; ?></li>
                            <?php if($address['address2'] != ""){ ?>
                            <li><b>Address 2:</b> <?php echo $address['address2']; ?></li>
                            <?php } ?>
                            <li><b>City:</b> <?php echo $address['city']; ?></li>
                            <li><b>State:</b> <?php echo $address['state']; ?></li>
                            <li><b>Zip Code:</b> <?php echo $address['zip_code']; ?></li>
                        </ul>
                    </div>
                </div>
                <div class="module">
                    <h3>Billing address</h3>
                    <div class="innerMod">
                        <ul>
                            <li><b>Address 1:</b> <?php echo $address['address1']; ?></li>
                            <?php if($address['address2'] != ""){ ?>
                            <li><b>Address 2:</b> <?php echo $address['address2']; ?></li>
                            <?php } ?>
                            <li><b>City:</b> <?php echo $address['city']; ?></li>
                            <li><b>State:</b> <?php echo $address['state']; ?></li>
                            <li><b>Zip Code:</b> <?php echo $address['zip_code']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="orderInfoRight col-lg-6 col-xs-12">
                <div class="module">
                    <h3>Order Information</h3>
                    <div class="innerMod">
                        <ul>
                            <li><b>Total:</b> <span class="special-price">$<?php echo $order[0]->order_cost; ?></span></li>
                            <li><b>Status:</b> <span class="special-price"><?php echo $order[0]->order_status; ?></span></li>
                            <li style="word-wrap: break-word;"><b>Order ID:</b> <?php echo $order[0]->order_id; ?></li>
                            <li><b>Order Date:</b> <?php echo date_format(date_create($order[0]->order_date), 'g:ia \o\n l jS F Y');; ?></li>
                            <li><b>Tracking Number: </b>
                                <?php if($order[0]->order_tn == ""){ ?> Pending <?php } else { ?>
                                <?php
                                $tracker = json_decode($order[0]->order_tn, true);
                                ?>
                                <a href="<?php echo $tracker['public_url']; ?>"><?php echo $tracker['tracking_code'] ?></a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="module clearfix" style="display: none;">
                    <h3>Shipping information</h3>
                    <div class="innerMod">
                        <ul>
                            <li><b>Carrier:</b> <?php //echo $shipping[2]; ?></li>
                            <li><b>Method:</b> <?php //echo $shipping[1]; ?></li>
                            <li><b>Price:</b> $<?php //echo $shipping[3]; ?></li>
                            <li><b>Est Delivery:</b> <?php //echo $shipping[5]; ?> Day(s)</li>
                        </ul>
                    </div>
                </div>
                <div class="module">
                    <h3>Products</h3>
                    <div class="innerMod">
                        <?php
                        foreach($products as $items)
                        {
                        $product = DB::table('products')->where('id', $items['product_id'])->get();

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
                                <h5>Size: <?php echo $items['product_size_number']; ?></h5>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="buyTheseProducts col-lg-12 clearfix">
                <h3 class="fi">Check out these other products</h3>
                <div class="bottomProducts row">
                    <?php
                    use App\Libraries\ProductsSystem;

                    // Use ordering system
                    $productsSystem = new ProductsSystem();
                    $products = $productsSystem->returnAllProducts();

                    if(count($products) > 0)
                    {
                    foreach($products as $product)
                    {
                    // Get brand
                    $brand = DB::table('brands')->where('id',''. $product->product_brands .'')->get();
                    ?>
                        <div style="margin-bottom: 30px;" class="productBox col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <a href="/products/single/<?php echo $product->id; ?>">
                                <div class="innerProductBox">
                                    <div class="topProductBox">
                                        <img class="innerProductImage" src="<?php echo url("/"); ?>/images/<?php echo $product->product_photo; ?>"/>
                                    </div>
                                    <div class="bottomProductBox">
                                        <div class="innerBottomProductBox">
                                            <h3><a href="/products/single/<?php echo $product->id; ?>"><?php echo (strlen($product->product_title) > 45) ? substr($product->product_title, 0, 45) . '...' : $product->product_title; ?></a></h3>
                                            <h4><a href="/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a></h4>
                                            <h5>$<?php echo $product->product_price; ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div><br /><br />
                    <?php
                    }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
@endsection
