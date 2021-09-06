<?php
$stylesheet = "products";

// See if it exists
$product = DB::table('products')->where('id',''. $product_id .'')->get();
$category = DB::table('category')->where('id',''. $product[0]->product_category .'')->get();
$brand = DB::table('brands')->where('id',''. $product[0]->product_brands .'')->get();

if(count($product) == 0){
    header('location: /');
}
?>
@section('cpn', $product[0]->product_title)
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
<div class="productViewContainer container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div><br />
    @endif
    @if (session('error'))
        <div class="alert alert-success">
            {{ session('error') }}
        </div><br />
    @endif

    <div class="breadCrumbs">
        <a style="color: #333;text-decoration: none;" href="{{  route('home.index') }}">Home</a> / <a style="color: #333;text-decoration: none;" href="<?php echo url('/'); ?>/products/category/<?php echo $category[0]->id; ?>"><?php echo $category[0]->name; ?></a>
    </div>

    <div class="topSection row clearfix">
        <div class="leftCont col-lg-5 clearfix">
            <img class="primaryImage" src="<?php echo url("/"); ?>/images/<?php echo $product[0]->product_photo; ?>" />
            <br /><br />
            <div class="thumbnails row">
                <div style="display: none;" class="col-sm-2 col-md-2 col-sm-2 col-xs-3" id="">
                    <a class="thumb thumbActive" data-src="<?php echo url("/"); ?>/images/<?php echo $product[0]->product_photo; ?>" id="">
                        <img src="<?php echo url("/"); ?>/images/<?php echo $product[0]->product_photo; ?>" style="" />
                    </a>
                </div>
                <?php
                $thumbnails = DB::table('product_thumbnails')->where('product_id', $product[0]->id)->get();

                foreach($thumbnails as $thumbnail)
                {
                ?>
                <div style="display: none;" class="col-sm-2 col-md-2 col-sm-2 col-xs-3" id="thumb<?php echo $thumbnail->id; ?>">
                    <a class="thumb" data-src="<?php echo url('images/thumbnails'); ?>/<?php echo $thumbnail->product_thumbnail; ?>" id="thumbMain<?php echo $thumbnail->id; ?>">
                        <img src="<?php echo url('images/thumbnails'); ?>/<?php echo $thumbnail->product_thumbnail; ?>" style="" />
                    </a>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="rightCont col-lg-7 clearfix">
            <div class="topEverythingTitle">
                <h3><?php echo $product[0]->product_title; ?></h3>
                <h4><a href="<?php url('/'); ?>/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a> &middot; Root Brothers SKU: <?php echo $product[0]->product_sku_root; ?></h4>
            </div>
            <div class="bottomDetails">
                <div class="descriptionMain">
                    <h3></h3>
                    <div class="mainDescription">
                        <p><?php echo $product[0]->product_desc; ?></p>
                        <ul>
                            <li><span>Type:</span> <?php echo $product[0]->product_gender; ?></li>
                            <li><span>Brand:</span> <?php echo ucwords($brand[0]->name); ?></li>
                            <li><span>Tags:</span> <?php echo $product[0]->product_tags; ?></li>
                            <?php
                                // Get category name
                                $category = @DB::table('category')->where('id',''. $product[0]->product_category .'')->get()[0];
                                $sub_category = @DB::table('sub_category')->where('id',''. $product[0]->product_sub_category .'')->get()[0];

                            ?>
                            <li><span>Category:</span> <a href="<?php echo url('/'); ?>/products/category/<?php echo @$category->id; ?>"><?php echo @$category->name; ?></a></li>
                            <li><span>Sub Category:</span> <a href="<?php echo url('/'); ?>/products/category/<?php echo @$sub_category->id; ?>"><?php echo @$sub_category->name; ?></a></li>
                            <li><span>Root Brothers SKU:</span> <?php echo $product[0]->product_sku_root; ?></li>
                            <li><span>Manufacturer SKU:</span> <?php echo $product[0]->product_sku; ?></li>
                        </ul>
                    </div>
                </div>
                <div class="pricingCont clearfix">
                    <form action="<?php echo url('/'); ?>/products/addToCart" method="post" id="addProductToCart">
                    <div class="infoByItself clearfix">
                        <h3 class="priceTxt">$<?php echo $product[0]->product_price; ?></h3>
                        <?php
                                // Get sizes for this product from DB
                                $sizing = DB::table('product_sizing')->where('product_id',''. $product_id .'')->get();

                                $sizes = '';

                        ?>
                        <div class="sizeSelect">
                            <div class="buttonInner href black">
                                <h3 class="" style="text-align: center;    margin-top: 10px;"><span class="sizeText">Select a variant</span> <span><i class="fas fa-angle-down"></i></span></h3>
                            </div>
                            <div class="buttonDropdown">
                                <ul>
                                    <?php
                                    foreach($sizing as $size)
                                    {
                                        if($size->product_size_stock > 0)
                                        {
                                        ?>
                                            <li class="selectSystem" data-value="<?php echo $size->id; ?>|<?php echo $size->product_sizing_id; ?>|<?php echo $size->product_id; ?>|<?php echo $size->product_size; ?>"><?php echo $size->product_size; ?> </li>
                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <select id="sizeSelect" name="sizeSelect">
                                <?php
                                foreach($sizing as $size)
                                {
                                if($size->product_size_stock > 0)
                                {
                                ?>
                                    <option value="<?php echo $size->id; ?>|<?php echo $size->product_sizing_id; ?>|<?php echo $size->product_id; ?>|<?php echo $size->product_size; ?>"><?php echo $size->product_size; ?></option>
                                <?php
                                }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                        // Check stock & make sure they're sizes
                        if($product[0]->product_sizing != "")
                        {
                            // Check size stock
                            $stock = 0;
                            foreach($sizing as $size)
                            {
                                $stock = $stock + $size->product_size_stock;
                            }

                            if($stock >= 1)
                            {
                        ?>
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="pid" id="pid" value="<?php echo $product_id; ?>" />

                            <button class="href black disabled addToCartBtn" disabled="true"><span><i class="fas fa-plus"></i></span> Add To Cart</button>
                            </form>
                        <?php
                            }else{
                                echo $stock;
                                ?>

                                    <div class="outOfStock">Out of Stock</div>
                                <?php
                            }
                        }else{
                    ?>
                        <div class="outOfStock">Out of Stock</div>
                    <?php
                         }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="relatedProducts">
        <div class="topArea col-lg-12">
            <h3>Key features, and Specs</h3>
        </div>
        <div class="showRelated col-lg-12" style="font-size: 20px;">
            <?php echo $product[0]->product_key_features; ?>
        </div>
    </div>
    <div class="relatedProducts">
        <div class="topArea col-lg-12">
            <h3>Related Products</h3>
        </div>
        <div class="showRelated col-lg-12">
            <div class="row">
            <?php
            $products = DB::table('products')->where('product_brands', 'like', '%'. $product[0]->product_brands .'%')->get();

            foreach($products as $product2){
            $brand2 = DB::table('brands')->where('id',''. $product2->product_brands .'')->get();
            ?>
                <div class="productBox col-lg-3">
                    <a href="/products/single/<?php echo $product2->id; ?>">
                        <div class="innerProductBox">
                            <div class="topProductBox">
                                <img class="innerProductImage" src="<?php echo url("/"); ?>/images/<?php echo $product2->product_photo; ?>"/>
                            </div>
                            <div class="bottomProductBox">
                                <div class="innerBottomProductBox">
                                    <h3><a href="/products/single/<?php echo $product2->id; ?>"><?php echo $product2->product_title; ?></a></h3>
                                    <h4><a href="/products/brands/<?php echo $brand2[0]->name; ?>"><?php echo $brand2[0]->name; ?></a> &middot; #sku1234</h4>
                                    <p><?php echo (strlen($product2->product_desc) > 100) ? substr($product2->product_desc, 0, 100) . '...' : $product2->product_desc; ?></p>
                                    <h5>$<?php echo $product2->product_price; ?></h5>
                                    <a class="btn-view" href="/products/single/<?php echo $product2->id; ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
</div>
@endsection