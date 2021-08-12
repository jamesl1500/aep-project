<?php
$stylesheet = "products";

// Validate this brand
?>

@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container">
            <h3>Search</h3>
            <p>Search our entire inventory!</p>
            <br />
            <form action="" method="get">
                <input class="form-control" type="text" name="s" placeholder="Search for Products, Brands and Categories" <?php if(isset($_GET['s']) && $_GET['s'] != ""){ ?> value="<?php echo $_GET['s']; ?>" <?php } ?>/>
                <center><input style="text-align: center;margin-top: 15px" type="submit" class="btn btn-success" value="Search" /></center>
            </form>
        </div>
    </div>
    <div class="container allProducts">
        <?php
            if(isset($_GET['s']) && !empty($_GET['s']))
            {
        ?>
            <div class="searchModule products clearfix">
                <div class="moduleHead">
                    <h3>Products</h3>
                </div>
                <div class="moduleInner">
                    <?php
                    //use App\Libraries\ProductsSystem;

                    // Use ordering system
                    $products = DB::table('products')->where('product_title', 'like', '%'.$_GET['s'].'%')->get();

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
                    }else{
                        echo "No products could be found";
                    }
                    ?>
                </div>
            </div><br /><hr />
            <div class="searchModule products">
                <div class="moduleHead">
                    <h3>Brands</h3>
                </div>
                <div class="moduleInner">
                    <ul>
                        <?php
                        //use App\Libraries\ProductsSystem;

                        // Use ordering system
                        $brands = DB::table('brands')->where('name', 'like', '%'.$_GET['s'].'%')->get();

                        if(count($brands) > 0)
                        {
                        foreach($brands as $brand)
                        {
                        ?>
                        <li class="brand_item" onClick="document.location.assign('<?php echo url('/'); ?>/products/brands/<?php echo $brand->name; ?>');">
                            <div class="brand_image" style="background-image: url(<?php echo url('images'); ?>/<?php echo $brand->image; ?>);"></div>
                            <h3>
                                <?php echo $brand->name; ?>
                            </h3>
                        </li>
                        <?php
                        }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php
            }
        ?>
    </div>
@endsection