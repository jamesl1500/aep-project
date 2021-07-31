@extends('layouts.app')

@section('content')
    <div class="accountMainContainer">
        <div class="bannerMainTop">
            <div class="innerBanner">
                <h3>Account Settings</h3>
            </div>
        </div>
        <div class="bottomMainContainer container">
            <div class="leftNavigations col-lg-3">
                <!-- Main User Settings -->
                <div class="navigationBlock">
                    <div class="innerBlock">
                        <h3>Navigation</h3>
                        <ul>
                            <li><a href="{{ route('account.index') }}">Account Dashboard</a></li>
                            <li class="active"><a href="{{ route('account.account_addresses') }}">Account Addresses</a></li>
                            <li><a href="{{ route('account.order_history') }}">Order History</a></li>
                        </ul>
                    </div>
                </div>

                <?php
                if(auth()->user()->admin == 1){
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
                            <li><a href="{{ route('account.admin.manage_orders') }}">Manage Orders</a></li>
                            <li><a href="{{ route('account.admin.manage_site_properties') }}">Manage Site</a></li>
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
                        <h3>Account Addresses</h3>
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
                                            <a href="{{ route('account.add_new_address') }}">Add new address</a>
                                        </div><br />
                                        <?php
                                        // For getting addresses
                                        $addresses = DB::table('account_addresses')->where('user_id',''. auth()->user()->id .'')->get();

                                        if(count($addresses) > 0)
                                        {
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <td>Address One</td>
                                                <td>Address Two</td>
                                                <td>City</td>
                                                <td>Status</td>
                                                <td>Zip Code</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($addresses as $address)
                                            {
                                            ?>
                                            <tr>
                                                <td class=""><?php echo $address->address_one; ?></td>
                                                <td class=""><?php echo $address->address_two; ?></td>
                                                <td class=""><?php echo $address->city; ?></td>
                                                <td class=""><?php echo $address->state; ?></td>
                                                <td class=""><?php echo $address->zip_code; ?></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }else{
                                        ?>
                                        <h3 class="orderMsg">You have no saved addresses</h3>
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
@endsection