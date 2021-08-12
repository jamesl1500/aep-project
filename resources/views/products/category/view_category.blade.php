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
                    <div class="sub_cat_card col-lg-3" onClick="window.location.assign('/products/category/<?php echo $sub_category->id; ?>');">
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
                <div class="productBox col-lg-4">
                    <a href="/products/single/<?php echo $product->id; ?>">
                        <div class="innerProductBox">
                            <div class="topProductBox">
                                <img class="innerProductImage" src="<?php echo url("/"); ?>/images/<?php echo $product->product_photo; ?>"/>
                            </div>
                            <div class="bottomProductBox">
                                <div class="innerBottomProductBox">
                                    <h3><a href="/products/single/<?php echo $product->id; ?>"><?php echo $product->product_title; ?></a></h3>
                                    <h4><a href="/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a></h4>
                                    <h5>$<?php echo $product->product_price; ?></h5>
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
@endsection