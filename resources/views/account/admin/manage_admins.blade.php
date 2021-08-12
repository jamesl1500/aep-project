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
                                <li class="active"><a href="/account/admin/manage_admins">Manage Admins</a></li>
                                <li><a href="{{ route('account.admin.manage_categories') }}">Manage Categories</a></li>
                                <li><a href="{{ route('account.admin.manage_brands') }}">Manage Brands</a></li>
                                <li><a href="{{ route('account.admin.manage_products') }}">Manage Products</a></li>
                                <li><a href="{{ route('account.admin.manage_orders') }}">Manage Orders</a></li>
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
                        <div class="topPartMain" style="padding-bottom: 20px;border-bottom: 1px solid #eee;">
                            <h3>Manage Admins</h3>
                        </div><br />
                        <div class="accountInfo">
                            <?php
                            // For getting category
                            $admins = DB::table('users')->where('type', 'admin')->get();

                            if(count($admins) > 0)
                            {
                            ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Status</td>
                                    <td>Actions</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($admins as $admin)
                                {
                                ?>
                                <tr>
                                    <td class=""><?php echo ucwords($admin->name); ?></td>
                                    <td class=""><?php echo $admin->email; ?></td>
                                    <td class=""><?php if($admin->type == "admin") { echo 'Current Admin'; } ?></td>
                                    <td class=""><a class="adminRevoke" data-token="{{ csrf_token() }}" data-id="<?php echo $admin->id; ?>" href="{{ route('account.admin.manage_site_properties.revoke_admin') }}">Revoke</a></td>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                            }else{
                            ?>
                            <h3 class="orderMsg">There are no admins</h3>
                            <?php
                            }
                            ?>
                            <hr />
                            <div class="non-admins">
                                <?php
                                // For getting category
                                $admins = DB::table('users')->where('type', 'client')->get();

                                if(count($admins) > 0)
                                {
                                ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Email</td>
                                        <td>Status</td>
                                        <td>Actions</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($admins as $admin)
                                    {
                                    ?>
                                    <tr>
                                        <td class=""><?php echo ucwords($admin->name); ?></td>
                                        <td class=""><?php echo $admin->email; ?></td>
                                        <td class=""><?php if($admin->type == "client") { echo 'Not an Admin'; } ?></td>
                                        <td class=""><a class="adminMake" data-token="{{ csrf_token() }}" data-id="<?php echo $admin->id; ?>" href="{{ route('account.admin.manage_site_properties.make_admin') }}">Make admin</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                                }else{
                                ?>
                                <h3 class="orderMsg">There are no non-admins</h3>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br />
</div>
@endsection