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
                            <li class="active"><a href="{{ route('account.admin.manage_products') }}">Manage Products</a></li>
                            <li><a href="{{ route('account.admin.manage_orders') }}">Manage Orders</a></li>
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
                        <h3>Manage Products</h3>
                    </div>
                    <div class="accountInfo">
                        <div class="innerInfo">
                            <div class="quickOrderList">
                                <div class="innerOrders">
                                    <div class="innerOrdersHold">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        <div class="topButtonMain">
                                            <a href="{{ route('account.admin.add_product') }}">Add new Product</a>
                                        </div><br />
                                        <?php
                                        // For getting category
                                        $products = DB::table('products')->get();

                                        if(count($products) > 0)
                                        {
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <td>Image</td>
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>Variant</td>
                                                <td>Actions</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($products as $product)
                                            {
                                            ?>
                                            <tr id="product<?php echo $product->id; ?>">
                                                <td class="" style="max-height: 100px;"><img style="max-height: 150px;" src="<?php echo url('images'); ?>/<?php echo $product->product_photo; ?>" /></td>
                                                <td class=""><a href="<?php echo url('/'); ?>/products/single/<?php echo $product->id; ?>"><?php echo $product->product_title; ?></a></td>
                                                <td class="">$<?php echo $product->product_price; ?></td>
                                                <td class=""><?php echo $product->product_gender; ?></td>
                                                <td class=""><a href="<?php echo url('/'); ?>/account/admin/product/edit/<?php echo $product->id; ?>">Edit</a> &middot; <a class="productDelete" data-t="{{ csrf_token() }}" data-pid="<?php echo $product->id; ?>" href="">Delete</a></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }else{
                                        ?>
                                        <h3 class="orderMsg">There are no categories</h3>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <p style="margin: 0px;padding: 0px;">* Hover over blue links to edit those values</p>
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