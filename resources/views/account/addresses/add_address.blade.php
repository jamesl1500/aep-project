@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
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
                            <li><a href="/account">Account Dashboard</a></li>
                            <li class="active"><a href="/account/account_addresses">Account Addresses</a></li>
                            <li><a href="/account/order_history">Order History</a></li>
                            <li><a href="{{ route('account.payment_methods') }}">Payment Methods</a></li>
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
                            <li><a href="/account/admin/manage_categories">Manage Categories</a></li>
                            <li><a href="/account/admin/manage_products">Manage Products</a></li>
                            <li><a href="/account/admin/manage_orders">Manage Orders</a></li>
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
                        <h3>Add new address</h3>
                    </div>
                    <div class="accountInfo">
                        <div class="innerInfo">
                            <div class="quickOrderList">
                                <div class="innerOrders">
                                    <div class="innerOrdersHold">
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form action="/account/add_address/process" method="post">
                                            <div class="inputMain">
                                                <input type="text" name="address_one" id="address_one" placeholder="Address One" />
                                            </div>
                                            <div class="inputMain">
                                                <input type="text" name="address_two" id="address_two" placeholder="Address Two" />
                                            </div>
                                            <div class="inputMain">
                                                <input type="text" name="city" id="city" placeholder="City" />
                                            </div>
                                            <div class="inputMain">
                                                <input type="text" name="state" id="state" placeholder="State" />
                                            </div>
                                            <div class="inputMain">
                                                <input type="text" name="zip_code" id="zip_code" placeholder="Zip Code" />
                                            </div>
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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