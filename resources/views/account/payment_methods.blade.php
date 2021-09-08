@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="accountMainContainer">
        <div class="bannerMainTop">
            <div class="innerBanner">
                <h3>Settings</h3>
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
                            <li class="active"><a href="{{ route('account.payment_methods') }}">Payment Methods</a></li>
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
                        <h3>Payment Methods</h3>
                    </div>
                    <div class="accountInfo">
                        <div class="innerInfo">
                            <div class="quickOrderList">
                                <div class="innerOrders">
                                    @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                    <h3><h4>Current Payment Methods</h4></h3>
                                    <div class="innerOrdersHold">
                                        <?php
                                        use Illuminate\Support\Facades\Auth;
                                        $payment_methods = DB::table('payment_methods')->where('user_id', Auth::id())->get();
                                        
                                        if(count($payment_methods) > 0)
                                        {
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <td>Last 4-Digits</td>
                                                <td>Exp Date</td>
                                                <td>Actions</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($payment_methods as $payment_method)
                                            {
                                            ?>
                                            <tr id="method-<?php echo $payment_method->id; ?>">
                                                <td class="payment_method_last_four"><?php echo Crypt::decrypt($payment_method->cc_number); ?></td>
                                                <td class="payment_method_exp"><?php echo Crypt::decrypt($payment_method->cc_exp_date); ?></td>
                                                <td class="payment_method_actions">
                                                    <?php 
                                                        if($payment_method->is_primary == "yes"){
                                                    ?>
                                                        Primary card
                                                    <?php 
                                                        }else{
                                                    ?>
                                                        <a href="{{ route('account.payment_methods.makePrimary') }}" class="makePrimaryPayment" data-token="{{ csrf_token() }}" data-pid="<?php echo $payment_method->id; ?>">Make Primary</a>
                                                    <?php
                                                        }
                                                    ?>
                                                    &middot; <a href="{{ route('account.payment_methods.deletePaymentMethod') }}" class="deletePaymentMethod" data-token="{{ csrf_token() }}" data-pid="<?php echo $payment_method->id; ?>">Remove</a>
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
                                        <h3 class="orderMsg">You have no payment methods</h3>
                                        <?php
                                        }
                                        ?>
                                    </div><br />
                                    <div class="addNewMethod">
                                        <h4>Add new payment method</h4><br />
                                        <div class="innerAddNew">
                                            <form action="{{ route('account.payment_methods.addMethod') }}" method="post">
                                                <div class="form-header">
                                                    <div class="form-group">
                                                        <label for="fullname">Credit Card Number</label>
                                                        <input type="number" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="Credit Card Number" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fullname">Credit Card CVV</label>
                                                        <input type="number" id="credit_card_cvv" name="credit_card_cvv" maxlength="4" class="form-control" placeholder="Credit Card CVV" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fullname">Credit Card Exp Date</label>
                                                        <input type="text" id="credit_card_exp_date" name="credit_card_exp_date" maxlength="5" class="form-control" placeholder="Credit Card Exp Date" value="">
                                                    </div>
                                                    {{ csrf_field() }}
                                                    <input class="btn btn-success" type="submit" value="Add payment" />
                                                </div>
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
    </div>
@endsection