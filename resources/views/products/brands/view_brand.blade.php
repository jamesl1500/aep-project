<?php
$stylesheet = "products";

// Validate this brand
$brand_info = DB::table('brands')->where('name',''. $brand .'')->get()[0];

if(!empty($brand_info)){
    header('location: /');
}
?>
@section('cpn', $cpn ?? '' )
@section('wn', $wn ?? '' )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container">
            <div class="brand_image col-lg-2">
                <img src="<?php echo url('images'); ?>/<?php echo $brand_info->image; ?>" />
            </div>
            <h3><?php echo $brand_info->name; ?></h3>
            <p><?php echo $brand_info->desc; ?></p>
        </div>
    </div>
    <div class="container allProducts">
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
                <div class="productBox col-lg-3">
                    <a href="/products/single/<?php echo $product->id; ?>">
                        <div class="innerProductBox">
                            <div class="topProductBox">
                                <img class="innerProductImage" src="<?php echo url("/"); ?>/images/<?php echo $product->product_photo; ?>"/>
                            </div>
                            <div class="bottomProductBox">
                                <div class="innerBottomProductBox">
                                    <h3><a href="/products/single/<?php echo $product->id; ?>"><?php echo $product->product_title; ?></a></h3>
                                    <h4><a href="/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a></h4>
                                    <p><?php echo (strlen($product->product_desc) > 100) ? substr($product->product_desc, 0, 100) . '...' : $product2->product_desc; ?></p>
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