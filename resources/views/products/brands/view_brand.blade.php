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
        <ul>
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
                <li class="col-lg-3">
                    <div class="innerProduct">
                        <div class="topProductImage" style="background: url(<?php echo url("/"); ?>/images/<?php echo $product->product_photo; ?>);background-position: center;background-size: cover;"></div>
                        <div class="bottomProduct">
                            <div class="topName">
                                <h3><a href="/products/single/<?php echo $product->id; ?>"><?php echo $product->product_title; ?></a></h3>
                                <div class="bottomInfo">
                                    <span class="price">$<?php echo $product->product_price; ?></span>
                                    <span class="brand"><a href="/products/brands/<?php echo $brand[0]->name; ?>"><?php echo $brand[0]->name; ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            }
            }
            ?>
        </ul>
    </div>
@endsection