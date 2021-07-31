<?php
$props = DB::table('site_props')->where('id', 1)->get();
?>
<div class="sidebar">
    <div class="innerSidebar">
        <div class="sidebarActions">
            <a class="retractSidebar" href="">X</a>
        </div>
        <div class="sidebarTop">
            <a href="">
                <img src="<?php echo url('images'); ?>/main_logo.jpg" />
                <h3>Unmovable Store</h3>
            </a>
        </div>
        <?php
        if(Auth::check())
        {
            ?>
                <div class="loggedSidebarNav" style="">
                    <div class="innerLoggedNav">
                        <ul>
                            <li><a href="{{ route('account.index') }}">Settings</a></li> &middot;
                            <li><a href="{{ route('cart.index') }}">Cart (<?php echo count(\App\Libraries\BasketHelper::fetchCart(auth()->user()->id)); ?>)</a></li>
                        </ul>
                    </div>
                </div>
            <?php
        }else {
        ?>
            <div class="loggedSidebarNav" style="">
                <div class="innerLoggedNav">
                    <ul>
                        <li><a href="{{ route('login') }}">Login</a></li> &middot;
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="sidebarMiddle">
            <div class="innerSidebarMiddle">
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
                            <li class="hoverLi <?php if($category['special'] == 1) { ?>specialNavigationCategory<?php } ?>">
                                <a href="/products/category/<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>

                                <ul>
                                    <?php
                                        $sub_cats = DB::table("sub_category")->where('parent_cat', $category['id'])->get();

                                        foreach($sub_cats as $sub_cat)
                                        {
                                    ?>
                                            <li class="hoverLi <?php if($sub_cat->special == 1) { ?>specialNavigationCategory<?php } ?>">
                                                <a href="/products/category/<?php echo $sub_cat->id; ?>"><?php echo $sub_cat->name; ?></a>
                                            </li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        }
                    }
                    ?>
                    <li class="hoverLi">
                        <a href="{{ route('journal.index') }}">Journal</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebarFooter">
            <div class="secondaryNav">
                <ul>
                    <li><a href="{{ route('about.index') }}">About U.S</a></li>
                    <li><a href="{{ route('help.index') }}">Help</a></li>
                    <li><a href="{{ route('help.index') }}#contact_form">Contact Us</a></li>
                </ul>
            </div>
            <div class="footerSocial">
                <ul>
                    <li>
                        <a href="<?php echo $props[0]->instagram_link; ?>">
                            <span class="fa-layers fa-fw"><i class="fab fa-instagram"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $props[0]->twitter_link; ?>">
                            <span class="fa-layers fa-fw"><i class="fab fa-twitter"></i></span>
                        </a>
                    </li>
                    <li style="display: none;">
                        <a href="{{ route('search.index') }}">
                            <span class="fa-layers fa-fw"><i class="fab fa-facebook-f"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>