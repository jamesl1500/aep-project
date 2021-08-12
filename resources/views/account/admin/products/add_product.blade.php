@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
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
                            <h3>Add new Product</h3>
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

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            <form action="/account/admin/add_product/process" method="post" enctype="multipart/form-data">
                                                <div class="inputMain">
                                                    <h3>Product Image</h3>
                                                    <input type="file" name="product_image" id="product_image" placeholder="Product Image" />
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Name</h3>
                                                    <input type="text" name="product_title" id="product_title" placeholder="Product Name" />
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Description</h3>
                                                    <textarea type="text" name="product_desc" id="product_desc" placeholder="Product Description"></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Tags</h3>
                                                    <input type="text" name="product_tags" id="product_tags" placeholder="Product Tags">
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Price</h3>
                                                    <input type="text" name="product_price" id="product_price" placeholder="Product Price">
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Gender</h3>
                                                    <select name="product_gender">
                                                        <option>Select a gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="unisex">Unisex</option>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Brand</h3>
                                                    <select name="product_brand">
                                                        <option>Select a brand</option>
                                                        <?php
                                                        $brands = DB::table('brands')->get();

                                                        foreach($brands as $brand)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $brand->id; ?>"><?php echo $brand->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Category</h3>
                                                    <select name="product_category">
                                                        <option>Select a category</option>
                                                        <?php
                                                        $categories = DB::table('category')->get();

                                                        foreach($categories as $category)
                                                        {
                                                        ?>
                                                            <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Sub-Category</h3>
                                                    <select name="product_sub_category">
                                                        <option>Select a category</option>
                                                        <?php
                                                        $sub_categories = DB::table('sub_category')->get();

                                                        foreach($sub_categories as $sub_category)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Variants</h3>
                                                    <a class="addSize btn btn-success">Add variant</a><br /><br />
                                                    <table id="productSizeHold" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <td>Action</td>
                                                            <td>Variant</td>
                                                            <td>Stock</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 55px;">
                                                                    <a class="eraseSize btn btn-danger">Delete</a>
                                                                </td>
                                                                <td>
                                                                    <input  type="text" name="size_name[]" value="0">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="small"  name="size_stock[]" value="0">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Weight & Box dimensions</h3>
                                                    <div class="row" style='padding-left: 14px;margin-bottom: 15px;'>
                                                        <input style="width: 120px;" type="number" name="weight" placeholder="Weight"/>
                                                        <input style="width: 120px;" type="number" name="length" placeholder="Length"/>
                                                    </div>
                                                    <div class="row" style="padding-left: 14px;">
                                                        <input style="width: 120px;" type="number" name="width" placeholder="Width"/>
                                                        <input style="width: 120px;" type="number" name="height" placeholder="Height"/>
                                                    </div>
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