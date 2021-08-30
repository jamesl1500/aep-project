<?php
$stylesheet = "products";

// Validate this brand
$brand_info = DB::table('brands')->where('name',''. $brand .'')->get()[0];

if(!empty($brand_info)){
    header('location: /');
}

if($brand_info->name == "Dewalt"){
    $color = "#febd17";
    $text_color = "#333";
    $nav_color = "#fff";
    $nav_color_a = "#333";
}else if($brand_info->name == "Milwaukee"){
    $color = "#db011c";
    $text_color = "#fff";
    $nav_color = "#fff";
    $nav_color_a = "#333";
}else if($brand_info->name == "Makita"){
    $color = "#008290";
    $text_color = "#fff";
    $nav_color = "#fff";
    $nav_color_a = "#333";
}else if($brand_info->name == "Greenlee"){
    $color = "#7ac436";
    $text_color = "#fff";
    $nav_color = "#fff";
    $nav_color_a = "#333";
}
?>
@section('cpn', $cpn ?? '' )
@section('wn', $wn ?? '' )

@extends('layouts.store')

@section('website_content')
<style>
    .nav-links ul li a{
        color: <?php echo $nav_color; ?> !important;
    }

    .nav-links ul li.active a{
        color: <?php echo $nav_color_a; ?> !important;
    }

    .top-header{
        background: <?php echo $color; ?> !important;
    }

    .copyright{
        background: <?php echo $color; ?> !important;
    }
</style>
    <div class="mainProductBanner" style="background: <?php echo $color; ?>;">
        <div class="innerProductBanner container">
            <div class="brand_image col-lg-6" style="margin: 0% auto;padding-bottom: 30px;text-align: center;padding: 0px;">
                <img src="<?php echo url('images'); ?>/<?php echo $brand_info->image; ?>" style="padding-bottom: 30px;width: 250px;"/>
            </div>
            <h3 style="color: <?php echo $text_color; ?>;"><?php echo $brand_info->name; ?></h3>
            <p style="color: <?php echo $text_color; ?>;"><?php echo $brand_info->desc; ?></p>
        </div>
    </div>
    <div class="container allProducts">
        <div class="row">
            <?php
            use App\Libraries\ProductsSystem;

            // Use ordering system
            $products = DB::table('products')->where('product_brands', '=', $brand_info->id)->get();

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