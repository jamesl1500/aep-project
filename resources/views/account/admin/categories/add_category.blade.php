@extends('layouts.app')

@section('content')
    <div class="accountMainContainer">
        <div class="bannerMainTop admin">
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
                                <li class="active"><a href="{{ route('account.admin.manage_categories') }}">Manage Categories</a></li>
                                <li><a href="{{ route('account.admin.manage_brands') }}">Manage Brands</a></li>
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
                            <h3>Add new Category</h3>
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

                                            <form action="/account/admin/add_category/process" method="post">
                                                <div class="inputMain">
                                                    <input type="text" name="category_name" id="category_name" placeholder="Category Name" />
                                                </div>
                                                <div class="inputMain">
                                                    <input type="text" name="category_subline_text" id="category_subline_text" placeholder="Subline Text" /><br/>
                                                    <span>*Short text to go under name*</span>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Is this category hidden?</h3>
                                                    <select name="status">
                                                        <option value="">Is this category hidden?</option>
                                                        <option value="0">Yes</option>
                                                        <option value="1">No</option>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Highlight this category?</h3>
                                                    <select name="special">
                                                        <option value="">Highlight this category?</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Display this on the navbar?</h3>
                                                    <select name="display_nav">
                                                        <option value="">Display this on the navbar?</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
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
    </div>
@endsection