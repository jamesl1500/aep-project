<?php

use App\Libraries\HeaderFunctions;

$headerFunctions = new HeaderFunctions();
?>
<header class="header primary-header solid-header">
    <div class="inner-header">
        <div class="top-header">
            <div class="inner-top-header container-fluid">
                <div class="row">
                    <div class="branding col col-lg-1">
                        <h3><a href="{{ route('home.index') }}">AEP</a></h3>
                    </div>
                    <div class="nav-links col col-lg-2">
                        <ul>
                            <li <?php if($cpn == "Store"){?>class="active"<?php } ?>><a href="{{ route('home.index') }}">Home</a></li>
                            <li <?php if($cpn == "Brands"){?>class="active"<?php } ?>><a href="{{ route('brands.all_brands') }}">Brand</a></li>
                            <li <?php if($cpn == "Help"){?>class="active"<?php } ?>><a href="{{ route('help.index') }}">Support</a></li>
                        </ul>
                    </div>
                    <div class="search-bar col col-lg-6">
                        <div class="inner-search-bar">
                            <input type="text" class="searchBarMain-header" name="search" placeholder="Search" />
                            <span class="searchBarBtn-header" style="cursor: pointer;margin-bottom: -35px;position: relative;top: -30px;left: -15px;float: right;"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <div class="nav-btns col col-lg-3">
                        <a class="shoppingCartBtn" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a>
                        <a style="background: white;border: 1px solid #333;color: #333;" class="navBtn" href="{{ route('account.index') }}">Account</a>
                        <a class="navBtn" href="{{ route('logout.index') }}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-header">
            <div class="inner-sub-header container-fluid">
                <ul>
                    <?php
                        $categories = $headerFunctions->returnCategories();

                        // Display categories
                        foreach($categories as $category)
                        {
                            // Make sure its a nav link
                            if($category['display_nav'] == 1)
                            {
                            ?>
                                <li><a href="/products/category/<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
                            <?php
                            }
                        }
                    ?>
                    <li style="float: right;"><a href="{{ route('brands.all_brands') }}">See All</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>