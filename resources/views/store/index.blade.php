<?php
/**
 * Store Template File
 * --------
 * This will serve as the full template file for the store 
 * and will also be used for the categories and things
 * of that nature
 **/
?>
@extends('layouts.store')

@section('cpn', $cpn )
@section('wn', $wn )

<!-- Full content -->
@section('website_content')
    <div class="topHeroContent">
        <div class="innerCover">
            <div class="middleContent">
                <h3>This belong to the hero statement and <br>this is the 2nd line</h3>
                <div class="inner-search-bar">
                    <input type="search" class="searchBarMain-index" name="search" placeholder="Search" />
                    <span class="searchBarBtn-index" style="cursor: pointer;margin-bottom: -35px;position: relative;top: -32px;left: -15px;float: right;"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="middleBrands">
        <div class="insideMiddleBrands row">
            <div class="row expand-column-wrapper">
                <div class="column dewalt">
                    <img src="https://www.dewalt.com/~/media/dewalt/images/global/54.png?h=35&w=129&la=en-US" />
                </div>
                <div class="column milwaukee">
                    <img src="https://www.milwaukeetool.com/-/media/Feature/Identity/logo-milwaukee.png?sc_lang=en&mh=84&la=en&h=84&w=155&mw=155&hash=B2A6E2608CD542DAE95A96649C55D2E3" />
                </div>
                <div class="column makita">
                    <img src="https://www.logolynx.com/images/logolynx/7e/7e10b719e79dfd4edfbbbb6cb2b59763.png" />
                </div>
                <div class="column greenlee">
                    <img src="http://127.0.0.1:8001/images/1628636738.png" />
                </div>
              </div>
{{--              <div class="brandHold dewalt col-lg-3" onClick="window.location.assign('/products/brands/DeWALT')">
                <img src="https://www.dewalt.com/~/media/dewalt/images/global/54.png?h=35&w=129&la=en-US" />
            </div>
            <div class="brandHold milwaukee col-lg-3" onClick="window.location.assign('/products/brands/Milwaukee')">
                <img src="https://www.milwaukeetool.com/-/media/Feature/Identity/logo-milwaukee.png?sc_lang=en&mh=84&la=en&h=84&w=155&mw=155&hash=B2A6E2608CD542DAE95A96649C55D2E3" />
            </div>
            <div class="brandHold makita col-lg-3" onClick="window.location.assign('/products/brands/Makita')">
                <img src="https://www.logolynx.com/images/logolynx/7e/7e10b719e79dfd4edfbbbb6cb2b59763.png" />
            </div>
            <div class="brandHold greenlee col-lg-3" onClick="window.location.assign('/brands/Greenlee')">
                <img src="http://127.0.0.1:8001/images/1628636738.png" />
            </div>  --}}
        </div>
    </div>
    <div class="bottomContent">
        <div class="middle container">
            <div class="block">
                <h3>Shop by categories</h3>
                <div class="productHold row">
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
                                            <p><?php echo (strlen($product->product_desc) > 100) ? substr($product->product_desc, 0, 100) . '...' : $product->product_desc; ?></p>
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

            <div class="block">
                <h3>Shop by most popular</h3>
                <div class="productHold row">
                    <?php
            
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
                                            <p><?php echo (strlen($product->product_desc) > 100) ? substr($product->product_desc, 0, 100) . '...' : $product->product_desc; ?></p>
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

            <div class="block">
                <h3>Shop by newest</h3>
                <div class="productHold row">
                    <?php
            
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
                                            <p><?php echo (strlen($product->product_desc) > 100) ? substr($product->product_desc, 0, 100) . '...' : $product->product_desc; ?></p>
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
        </div>
    </div>
@stop