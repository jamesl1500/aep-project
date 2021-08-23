<?php
use App\Libraries\OrderingSystem;

// Fetch order
$order = OrderingSystem::fetchOrder($order_id);

// Fetch address
$address = json_decode($order[0]->order_address, true);

// Fetch products
$products = json_decode($order[0]->order_products, true);

// Fetch order braintree transaction
$transaction = OrderingSystem::fetchOrderPaymentInfo($order[0]->order_transaction_id);

?>
@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <style>
        .modal-backdrop{
            display: none !important;
        }
    </style>
    <div class="accountMainContainer">
        <div class="bannerMainTop admin" style="">
            <div class="innerBanner">
                <h3>Admin Panel</h3>
            </div>
        </div>
        <div class="bottomMainContainer container">
            <div class="row">
                <div class="leftNavigations col-lg-3">
                    <!-- Main User Settings -->
                    <div class="navigationBlock">
                        <div class="innerBlock">
                            <h3>Navigation</h3>
                            <ul>
                                <li><a href="{{ route('account.index') }}">Account Dashboard</a></li>
                                <li><a href="{{ route('account.account_addresses') }}">Account Addresses</a></li>
                                <li><a href="{{ route('account.order_history') }}">Order History</a></li>
                            </ul>
                        </div>
                    </div>

                    <?php
                    if(auth()->user()->type == "admin"){
                    ?>
                            <!-- Main Admin Settings -->
                    <div class="navigationBlock">
                        <div class="innerBlock">
                            <h3>Admin Settings</h3>
                            <ul>
                                <li><a href="/account/admin/manage_admins">Manage Admins</a></li>
                                <li><a href="{{ route('account.admin.manage_categories') }}">Manage Categories</a></li>
                                <li><a href="{{ route('account.admin.manage_brands') }}">Manage Brands</a></li>
                                <li><a href="{{ route('account.admin.manage_products') }}">Manage Products</a></li>
                                <li class="active"><a href="{{ route('account.admin.manage_orders') }}">Manage Orders</a></li>
                                <li><a href="{{ route('account.admin.manage_site_properties') }}">Manage Site</a></li>
                                <li><a href="{{ route('account.admin.manage_users') }}">Manage Users</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="rightInfoContainer col-lg-9">
                    <div class="innerContainer">
                        <div class="topPartMain" style="padding-bottom: 10px;border-bottom: 1px solid #eee;">
                            <h3>Manage Order</h3>
                            <p>Order ID: <?php echo $order_id; ?></p>
                        </div>
                        <div class="accountInfo">
                            <div class="innerInfo order">
                                <div class="actions" style="padding-top: 20px;">
                                    @if (session('success'))
                                        <br />
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <br />
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <h3>Actions</h3>
                                    <div class="buttonHolds" style="">
                                        <button class="btn btn-success" id="openShippingModal" data-toggle="modal" data-target="#shippingModal">Mark as shipped</button>
                                        <button class="btn btn-default" id="openOrderStatusModal" data-toggle="modal" data-target="#orderStatusChange">Change order status</button>
                                        <!-- <button class="btn btn-danger" id="openRefundModal" data-toggle="modal" data-target="#refundMake">Refund order</button> -->
                                    </div>
                                </div>
                                <hr>
                                <h3>Customer Information</h3>
                                <div class="module customer">
                                    <div class="innerMod">

                                    </div>
                                </div>
                                <div class="module shipping_address">
                                    <h3>Shipping Address</h3>
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
                                <div class="module billing_address">
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
                                <hr />
                                <h3>Order Details</h3>
                                <div class="module order_details">
                                    <div class="module">
                                        <h3>Order Information</h3>
                                        <div class="innerMod">
                                            <ul>
                                                <li><b>Total:</b> <span class="special-price">$<?php echo $order[0]->order_cost; ?></span></li>
                                                <li><b>Status:</b> <span class="special-price"><?php echo $order[0]->order_status; ?></span></li>
                                                <li><b>Order ID:</b> <?php echo $order[0]->order_id; ?></li>
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
                                    <div class="module">
                                        <h3>Products</h3>
                                        <div class="innerMod">
                                            <?php
                                            foreach($products as $items)
                                            {
                                            $product = DB::table('products')->where('id', $items['product_id'])->get();

                                            if(count($product) == 0){
                                                ?>
                                                    Product not found
                                                <?php
                                            }else{

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
                                                    }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="module">
                                        <h3 style="margin-top: 0px;">Shipping</h3>
                                        <div class="innerMod">
                                            <?php
                                            // Shipping
                                            $shipping = json_decode($order[0]->order_shipping);
                                            ?>
                                            <ul>
                                                <li><b>Carrier:</b> <?php echo $shipping[2]; ?></li>
                                                <li><b>Method:</b> <?php echo $shipping[1]; ?></li>
                                                <li><b>Price:</b> $<?php echo $shipping[3]; ?></li>
                                                <li><b>Est Delivery:</b> <?php echo $shipping[5]; ?> Day(s)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                {{--  <h3>Payment Info</h3>
                                <div class="module payment_info">
                                    <div class="innerMod">
                                        <ul>
                                            <li><b>Transaction ID:</b> <?php //echo $transaction->id; ?></li>
                                            <li><b>Status:</b> <?php //echo $transaction->status; ?></li>
                                            <li><b>Type:</b> <?php //echo $transaction->type; ?></li>
                                            <li><b>Currency:</b> <?php //echo $transaction->currencyIsoCode; ?></li>
                                            <li><b>Amount:</b> <span class="special-price">$<?php //echo $transaction->amount; ?></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="module payment_info">
                                    <h3 style="font-weight: 300;">Payment Method</h3>
                                    <div class="innerMod">
                                        <ul>
                                            <li><b>Type:</b> <?php if($transaction->paymentInstrumentType == "paypal_account"){ ?> Paypal <?php } else {?> Credit/Debit <?php } ?></li>
                                            <?php if($transaction->paymentInstrumentType == "paypal_account"){ ?>
                                                <li><b>Paypal Email:</b> <?php echo $transaction->paypalDetails->payerEmail; ?></li>
                                                <li><b>Paypal First Name:</b> <?php echo $transaction->paypalDetails->payerFirstName; ?></li>
                                                <li><b>Paypal First Name:</b> <?php echo $transaction->paypalDetails->payerLastName; ?></li><br />
                                                <li><b>Transaction Fee:</b> <?php echo $transaction->paypalDetails->transactionFeeAmount; ?></li>
                                                <li><b>Transaction Fee Currency:</b> <?php echo $transaction->paypalDetails->transactionFeeCurrencyIsoCode; ?></li>
                                            <?php } else{ ?>

                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <pre style="display: none">
                                    <?php
                                    //print_r($transaction);
                                    ?>
                                </pre>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br />
    <div class="modalHolder">
        <!-- Shipping -->
        <div class="modal fade" style="background: rgba(0,0,0,.5);padding-top: 100px;" tabindex="-1" id="shippingModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('order.edit.markAsShipped') }}" method="post">
                        <div class="modal-header">
                            <button  style="display:none;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Mark the order as "Shipped"</h4>
                        </div>
                        <div class="modal-body">
                            <label for="tracking">Tracking number*</label>
                            <input type="text" name="tracking_number" class="form-control" placeholder="Tracking Number" value="" required/>
                            <br />
                            <p>In order to mark this order as "Shipped" you must provide a valid tracking number</p>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-primary" value="Save changes" />
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Changing order status -->
        <div class="modal fade" style="background: rgba(0,0,0,.5);padding-top: 100px;" tabindex="-1" id="orderStatusChange" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('order.edit.changeStatus') }}" method="post">
                        <div class="modal-header">
                            <button type="button" style="display:none;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" style="text-align: center;">Change order status</h4>
                        </div>
                        <div class="modal-body">
                            <label for="statusChange">Status</label>
                            <select class="form-control" name="statusChange">
                                <?php
                                    $statuses = array('refunded', 'paid', 'unpaid', 'shipped', 'processing', 'approved', 'declined');

                                    foreach($statuses as $status)
                                    {
                                        ?>
                                            <option <?php if($status == $order[0]->order_status){ ?> selected <?php } ?> value="<?php echo $status; ?>"><?php echo ucwords($status); ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <a class="btn btn-default" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-primary" value="Save changes" />
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Changing shipping/billing info -->
        <div class="modal fade" style="background: rgba(0,0,0,.5);padding-top: 100px;" tabindex="-1" id="orderAddresses" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <button style="display:none;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Change Billing/Shipping address</h4>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Refund order -->
        <div class="modal fade" style="margin-top: 100px;" tabindex="-1" id="refundMake" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('order.edit.refundOrder') }}" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Refund</h4>
                        </div>
                        <div class="modal-body">
                            <label for="statusChange">Refund amount</label>
                            <input type="number" class="form-control" name="refundAmount" placeholder="Refund amount" required/>
                            <br />
                            <p>You can process a full or partial refund!</p>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <input type="hidden" name="trans_id" value="<?php //echo $transaction->id; ?>" />
                            <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-primary" value="Process refund" />
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@endsection