<?php
$product = DB::table('products')->where('id',''. $product_id .'')->get();

if(Auth::check() && count($product) == 0){
    header('location: /');
}
?>
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
                                <li><a href="{{ route('account.payment_methods') }}">Payment Methods</a></li>
                            </ul>
                        </div>
                    </div>

                    <?php
                    if(auth::check() && auth()->user()->type == "admin"){
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
                            <h3>Edit Product: <a href="<?php echo url('/'); ?>/products/single/<?php echo $product[0]->id; ?>"><?php echo $product[0]->product_title; ?></a></h3>
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

                                            <form action="/products/edit" id="productEditForm" method="post" enctype="multipart/form-data">
                                                <div class="productImage">
                                                    <img style="max-height: 150px;" src="<?php echo url('images'); ?>/<?php echo $product[0]->product_photo; ?>" />
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Image</h3>
                                                    <input type="file" name="product_image" id="product_image" placeholder="Product Image" />
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Thumbnails</h3>
                                                    <input type="file" name="product_image_thumbnails[]" id="product_image_thumbnails" placeholder="Product Thumbnails" multiple/>
                                                    <br />
                                                    <div class="currentThumbnails row">
                                                        <?php
                                                            $thumbnails = DB::table('product_thumbnails')->where('product_id', $product[0]->id)->get();

                                                            foreach($thumbnails as $thumbnail)
                                                            {
                                                                ?>
                                                                <div class="col-sm-3 col-md-3" id="thumb<?php echo $thumbnail->id; ?>">
                                                                    <div class="thumbnail">
                                                                        <img src="<?php echo url('images/thumbnails'); ?>/<?php echo $thumbnail->product_thumbnail; ?>" style="height: 150px;width: 150px;" />
                                                                        <div class="caption">
                                                                            <a class="btn btn-primary removeThumbnail" data-tdotgoonscrapdvd="{{ csrf_token() }}" data-pid="<?php echo $product[0]->id; ?>" data-thumbid="<?php echo $thumbnail->id; ?>">Remove</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Name</h3>
                                                    <input type="text" name="product_title" id="product_title" placeholder="Product Name" value="<?php echo $product[0]->product_title; ?>"/>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Description</h3>
                                                    <textarea style="max-height: 300px;" name="product_desc" id="product_desc" placeholder="Product Description" value="<?php echo $product[0]->product_desc; ?>"><?php echo $product[0]->product_desc; ?></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Tags</h3>
                                                    <input type="text" name="product_tags" id="product_tags" placeholder="Product Tags" value="<?php echo $product[0]->product_tags; ?>">
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Key features, includes & Specs</h3>
                                                    <textarea type="text" name="product_key_features" id="product_key_features" placeholder="Product Keyfeatures, Includes & Specs"><?php echo $product[0]->product_key_features; ?></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Root Brothers SKU</h3>
                                                    <input type="text" name="product_sku_root" id="product_sku_root" placeholder="Root Brothers SKU" value="<?php echo $product[0]->product_sku_root; ?>"/>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Manufacturer SKU</h3>
                                                    <input type="text" name="product_sku" id="product_sku" placeholder="Manufacturers SKU" value="<?php echo $product[0]->product_sku; ?>"/>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Price</h3>
                                                    <input type="text" name="product_price" id="product_price" placeholder="Product Price" value="<?php echo $product[0]->product_price; ?>">
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Type</h3>
                                                    <select name="product_gender" id="product_gender">
                                                        <option>Select a type</option>
                                                        <?php
                                                            $genders = array("Unit Only", "Bundle", "Unit & Battery");

                                                            foreach($genders as $gender)
                                                            {
                                                        ?>
                                                        <option <?php if($gender == $product[0]->product_gender){?> selected <?php } ?> value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Brand</h3>
                                                    <select name="product_brand" id="product_brand">
                                                        <option>Select a brand</option>
                                                        <?php
                                                        $brands = DB::table('brands')->get();

                                                        foreach($brands as $brand)
                                                        {
                                                        ?>
                                                        <option <?php if($brand->id == $product[0]->product_brands){?> selected <?php } ?> value="<?php echo $brand->id; ?>"><?php echo $brand->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Category</h3>
                                                    <select name="product_category" id="product_category">
                                                        <option>Select a category</option>
                                                        <?php
                                                        $categories = DB::table('category')->get();

                                                        foreach($categories as $category)
                                                        {
                                                        ?>
                                                        <option <?php if($category->id == $product[0]->product_category){?> selected <?php } ?> value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Sub-Category</h3>
                                                    <select name="product_sub_category" id="product_sub_category">
                                                        <option>Select a category</option>
                                                        <?php
                                                        $sub_categories = DB::table('sub_category')->get();

                                                        foreach($sub_categories as $sub_category)
                                                        {
                                                        ?>
                                                        <option <?php if($sub_category->id == $product[0]->product_sub_category){?> selected <?php } ?> value="<?php echo $sub_category->id; ?>"><?php echo $sub_category->name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Product Variants</h3>
                                                    <a class="addSize btn btn-success">Add Variant</a><br /><br />
                                                    <table id="productSizeHold" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <td>Show</td>
                                                            <td>Variant</td>
                                                            <td>Stock</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        // Get sizes for this product from DB
                                                        $sizing = DB::table('product_sizing')->where('product_id',''. $product_id .'')->get();

                                                        $sizes = '';
                                                        foreach($sizing as $size)
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td style="width: 55px;">
                                                                    <a class="eraseSize btn btn-danger" data-id="<?php echo $size->id; ?>">Delete</a>
                                                                </td>
                                                                <td>
                                                                    <input  type="text" name="size_name[]" value="<?php echo $size->product_size; ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="small"  name="size_stock[]" value="<?php echo $size->product_size_stock; ?>">
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="inputMain">
                                                    <?php
                                                        $dimensions = json_decode($product[0]->product_dimensions, true);
                                                    ?>
                                                    <h3>Product Weight & Box dimensions</h3>
                                                    <div class="row" style='padding-left: 14px;margin-bottom: 15px;'>
                                                        <input style="width: 120px;" type="number" name="weight" id="weight" placeholder="Weight" value="<?php echo $dimensions['weight']; ?>"/>
                                                        <input style="width: 120px;" type="number" name="length" id="length" placeholder="Length" value="<?php echo $dimensions['length']; ?>"/>
                                                    </div>
                                                    <div class="row" style="padding-left: 14px;">
                                                        <input style="width: 120px;" type="number" name="width" id="width" placeholder="Width" value="<?php echo $dimensions['width']; ?>"/>
                                                        <input style="width: 120px;" type="number" name="height" id="height" placeholder="Height" value="<?php echo $dimensions['height']; ?>"/>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="pid" id="pid" value="<?php echo $product[0]->id; ?>" />
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