@extends('layouts.app')

@section('content')
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
                                <li class="active"><a href="{{ route('account.admin.manage_brands') }}">Manage Brands</a></li>
                                <li><a href="{{ route('account.admin.manage_products') }}">Manage Products</a></li>
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
                            <h3>Manage Brands</h3>
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
                                                <a href="/account/admin/add_brand">Add new Brand</a>
                                            </div><br />
                                            <?php
                                            // For getting brands
                                            $brands = DB::table('brands')->get();

                                            if(count($brands) > 0)
                                            {
                                            ?>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <td>Name</td>
                                                    <td>Hidden</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($brands as $brand)
                                                {
                                                ?>
                                                <tr>
                                                    <td class=""><?php echo $brand->name; ?></td>
                                                    <td class="">
                                                        <?php
                                                            if($brand->hidden == 0)
                                                            {
                                                                ?>
                                                                    <a href="#" id="hidden" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $brand->id; ?>" data-url="/account/manage_brands/update" data-title="Hide this category?">No</a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                    <a href="#" id="hidden" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $brand->id; ?>" data-url="/account/manage_brands/update" data-title="Hide this category?">Yes</a>
                                                                <?php
                                                            }
                                                        ?>
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
                                            <h3 class="orderMsg">There are no brands</h3>
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