<?php if(!isset($_COOKIE['returnPolicyCheck'])){ ?>
<div class="over"></div>
<div class="returnPolicyAction">
    <div class="innerCover">
        <div class="topHead">
            <h3>Return Policy</h3>
        </div>
        <div class="bottomHold">
            <div class="back">
                <p>Welcome popup test</p>
            </div>
            <div class="bottomButton">
                <form action="" method="post" id="returnPolicyForm">
                    <input type="hidden" id="csrf" value="{{ csrf_token() }}" />
                    <button class="removeReturnPolicy">I agree!</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<header class="header main-header">
    <div class="headerSubTop">

    </div>
    <div class="mainHeaderInner container">
        <div class="leftResponsiveAction pull-left">

        </div>
        <div class="leftBranding pull-left col-lg-4 col-md-4">

        </div>
        <div class="rightNavigation pull-right col-lg-8 col-md-8 col-sm-3">
            <div class="middleNavigation hidden-sm hidden-xs">
                <div class="innerMiddleNav">
                    <div class="innerBranding">
                        <a href="<?php echo url('/'); ?>">
                        </a>
                    </div>

                    <ul style="display: none;">
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
                        </li>
                        <?php
                        }
                        }
                        ?>
                        <li class="hoverLi <?php if($category['special'] == 1) { ?>specialNavigationCategory<?php } ?>">
                            <a href="">Journel</a>
                        </li>
                        <li class="hoverLi <?php if($category['special'] == 1) { ?>specialNavigationCategory<?php } ?>">
                            <a href="{{ route('about.index') }}">About Us</a>
                        </li>
                    </ul>
                </div>
            </div><div class="vert-divider"></div>
            <div class="rightActions">
                <div class="innerActions">
                    <ul>
                        <li style="display: none;"><a href="{{ route('search.index') }}"><i class="fas fa-search"></i></a></li>
                        <li><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i></a></li>
                        <li style="display: none;"><a href="{{ route('account.index') }}"><i class="fas fa-user"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>