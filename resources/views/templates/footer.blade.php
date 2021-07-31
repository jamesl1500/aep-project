<?php
$props = DB::table('site_props')->where('id', 1)->get();
?>
<!-- Footer Area -->
<div class="footerMain">
    <div class="container innerFooter">
        <div class="topFooterIcon">
            <div class="middleIcon">
                <img src="<?php echo url('images'); ?>/main_logo.jpg" />
            </div>
        </div>
        <div class="middleFooterLinks">
            <div class="innerFooterLinks">

                <ul>
                    <li><a href="{{ route('home.index') }}">Home</a></li>
                    <li><a href="{{ route('about.index') }}">About U.S</a></li>
                    <li><a href="{{ route('help.index') }}">Help</a></li>
                    <li><a href="/products">All Products</a></li>

                </ul>
            </div>
        </div>
        <div class="bottomFooterCopyright">
            <div class="innerFooterCopyright">
                <p style="color: white;font-weight: bold;">777 W.Market St, Akron, OH 44303 | W-S 1:00PM to 7:00PM</p>
                <p style="color: white;"><?php echo $props[0]->return_policy; ?></p>
                <h3>Unmovablestore.com &copy 20<?php echo date('y'); ?>; Site built and designed by <a href="https://sitelyftstudios.com/">Sitelyft Studios</a></h3>
            </div>
        </div>
    </div>
</div>