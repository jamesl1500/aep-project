@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
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
                                <li><a href="{{ route('account.payment_methods') }}">Payment Methods</a></li>
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
                        <div class="topPartMain">
                            <h3>Manage Orders</h3>
                        </div>
                        <div class="accountInfo">
                            <div class="innerInfo">
                                <div class="quickOrderList">
                                    <div class="innerOrders">
                                        <h3><h4>Latest Orders</h4></h3>
                                        <div class="innerOrdersHold">
                                            <?php
                                            use App\Libraries\OrderingSystem;

                                            // Use ordering system
                                            $orderingSystem = new OrderingSystem();
                                            $orders = $orderingSystem->returnUsersOrders(auth()->user()->id);

                                            if(count($orders) > 0)
                                            {
                                            ?>
                                            <table class="table order-table table-striped table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <td>Order ID</td>
                                                    <td>Cost</td>
                                                    <td>Status</td>
                                                    <td>Tracking</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($orders as $order)
                                                {
                                                ?>
                                                <tr>
                                                    <td class="order_id_string"><a href="<?php echo url('/'); ?>/account/admin/manage_orders/<?php echo $order->order_id; ?>"><?php echo substr($order->order_id, 0, 30); ?>...</a></td>
                                                    <td class="order_cost">$<?php echo $order->order_cost; ?></td>
                                                    <td class="order_status"><?php echo ucwords($order->order_status); ?></td>
                                                    <td class="order_tracking">
                                                        <?php if($order->order_tn == ""){ ?> Pending <?php } else { ?>
                                                        <?php
                                                        $tracker = json_decode($order->order_tn, true);
                                                        ?>
                                                        <a href="<?php echo $tracker['public_url']; ?>"><?php echo $tracker['tracking_code'] ?></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?php
                                            }else{
                                            ?>
                                            <h3 class="orderMsg">You have no orders</h3>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection