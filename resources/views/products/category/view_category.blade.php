<?php
$stylesheet = "products";

// Validate this brand
$category_info = DB::table('category')->where('id',''. $category .'')->get();

if(count($category_info) == 0)
{
    // Check to see if its a sub
    $category_info = DB::table('sub_category')->where('id',''. $category .'')->get();

    if(count($category_info) == 0)
    {
        header('location: /');
    }
}
?>
@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container" style="padding-bottom: 30px">
            <!-- <div class="brand_image col-lg-2">
                <img src="<?php //echo url('images'); ?>/<?php //echo $brand_info->image; ?>" />
            </div> -->
            <h3><?php echo $category_info[0]->name; ?></h3>
            <p><?php if($category_info[0]->subline_text != ""){ echo $category_info[0]->subline_text; } ?></p>
            <?php
            // Check to see if its a sub
            $sub_categories = DB::table('sub_category')->where('parent_cat',''. $category .'')->get();

            if(count($sub_categories) > 0)
            {
            ?>
            <div class="sub_categories" style="padding-top: 20px;">
                <div class="row">
                    <?php
                    foreach($sub_categories as $sub_category)
                    {
                    ?>
                    <div style="background: white;padding-right:0px;padding-left:0px;" class="sub_cat_card col-lg-3" onClick="window.location.assign('/products/category/<?php echo $sub_category->id; ?>');">
                        <div class="inner_cat_card">
                           <span><?php echo $sub_category->name; ?></span>
                        </div>
                    </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="container allProducts">
        <div class="row" style="padding: 0px;">
            <?php
            use App\Libraries\ProductsSystem;

            // Use ordering system
            $products = DB::table('products')->where('product_category', '=', $category)->orWhere('product_sub_category', '=', $category)->get();

            if(count($products) > 0)
            {
            foreach($products as $product)
            {
            // Get brand
            $brand = DB::table('brands')->where('id',''. $product->product_brands .'')->get();
            ?>
                <div class="productBox col-lg-3" style="margin-bottom: 30px;">
                    <a href="/products/single/<?php echo $product->id; ?>">
                        <div class="innerProductBox">
                            <div class="topProductBox">
                                <img class="innerProductImage" src="<?php echo url("/"); ?>/images/<?php echo $product->product_photo; ?>"/>
                            </div>
                            <div class="bottomProductBox">
                                <div class="innerBottomProductBox">
                                    <h3><a href="/products/single/<?php echo $product->id; ?>"><?php echo (strlen($product->product_title) > 35) ? substr($product->product_title, 0, 25) . '...' : $product->product_title; ?></a></h3>
                                    <h4><a href="/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a></h4>
                                    <p style="display: none;"><?php echo (strlen($product->product_desc) > 100) ? substr($product->product_desc, 0, 100) . '...' : $product->product_desc; ?></p>
                                    <h5>$<?php echo $product->product_price; ?></h5>
                                    <a class="btn-view" href="/products/single/<?php echo $product->id; ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            }
            ?>
        </div>
    </div>
@endsection