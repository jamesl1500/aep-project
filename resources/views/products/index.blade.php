<?php
$stylesheet = "products";
?>
@extends('layouts.app')

@section('content')
<div class="mainProductBanner">
    <div class="innerProductBanner container">
        <h3>All Products</h3>
        <p>View our entire stock of clothes, shoes and accessories</p>
    </div>
</div>
<div class="container allProducts">
        <?php
        use App\Libraries\ProductsSystem;

        // Use ordering system
        $productsSystem = new ProductsSystem();
        $products = $productsSystem->returnAllProducts();

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