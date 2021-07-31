@extends('layouts.app')

@section('content')
    <div class="accountMainContainer">
        <div class="bannerMainTop admin" style="">
            <div class="innerBanner">
                <h3>Admin Panel</h3>
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
                            <li><a href="{{ route('account.account_addresses') }}">Account Addresses</a></li>
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
                            <li class="active"><a href="{{ route('account.admin.manage_categories') }}">Manage Categories</a></li>
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
                        <h3>Manage Categories</h3>
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
                                        <h3>Parent Categories</h3>
                                        <div class="topButtonMain">
                                            <a href="{{ route('account.admin.add_category') }}">Add new Category</a>
                                        </div><br />
                                        <?php
                                        // For getting category
                                        $categories = DB::table('category')->get();

                                        if(count($categories) > 0)
                                        {
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Hidden</td>
                                                <td>Special</td>
                                                <td>Navbar</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($categories as $category)
                                            {
                                            ?>
                                            <tr>
                                                <td class=""><?php echo $category->name; ?></td>
                                                <td class="">
                                                    <?php
                                                        if($category->status == 1)
                                                        {
                                                            ?>
                                                                <a href="#" id="status" class="change2" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Hide this category?">No</a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <a href="#" id="status" class="change2" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Hide this category?">Yes</a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td class="">
                                                    <?php
                                                        if($category->special == 1)
                                                        {
                                                            ?>
                                                                <a href="#" id="special" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Highlight this category?">Yes</a>
                                                        <?php
                                                        }else{
                                                            ?>
                                                                <a href="#" id="special" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Highlight this category?">No</a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td class="">
                                                    <?php
                                                        if($category->display_nav == 1)
                                                        {
                                                            ?>
                                                                <a href="#" id="display_nav" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Display on navbar?">Yes</a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                                <a href="#" id="display_nav" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $category->id; ?>" data-url="/account/manage_categories/update" data-title="Display on navbar?">No</a>
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
                                        <h3 class="orderMsg">There are no categories</h3>
                                        <?php
                                        }
                                        ?>
                                        <br />
                                        <h3>Sub Categories</h3>
                                        <div class="topButtonMain">
                                            <a href="{{ route('account.admin.add_sub_category') }}">Add new Sub-Category</a>
                                        </div><br />
                                        <?php
                                        // For getting category
                                        $sub_categories = DB::table('sub_category')->get();

                                        if(count($sub_categories) > 0)
                                        {
                                        ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Parent</td>
                                                <td>Hidden</td>
                                                <td>Special</td>
                                                <td>Navbar</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($sub_categories as $sub_category)
                                            {
                                            ?>
                                            <tr>
                                                <td class=""><?php echo $sub_category->name; ?></td>
                                                <?php
                                                    $parent_category = DB::table('category')->where('id', ''.$sub_category->parent_cat.'')->get()[0];
                                                ?>
                                                <td class=""><?php echo $parent_category->name; ?></td>
                                                <td class="">
                                                    <?php
                                                    if($sub_category->status == 1)
                                                    {
                                                    ?>
                                                    <a href="#" id="status" class="change2" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Hide this category?">No</a>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a href="#" id="status" class="change2" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Hide this category?">Yes</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="">
                                                    <?php
                                                    if($sub_category->special == 1)
                                                    {
                                                    ?>
                                                    <a href="#" id="special" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Highlight this category?">Yes</a>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a href="#" id="special" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Highlight this category?">No</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class="">
                                                    <?php
                                                    if($sub_category->display_nav == 1)
                                                    {
                                                    ?>
                                                    <a href="#" id="display_nav" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Display on navbar?">Yes</a>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a href="#" id="display_nav" class="change" data-token="{{ csrf_token() }}" data-type="select" data-pk="<?php echo $sub_category->id; ?>" data-url="/account/manage_sub_categories/update" data-title="Display on navbar?">No</a>
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
@endsection