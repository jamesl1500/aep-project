<?php
$stylesheet = "coming_soon";
?>
@extends('layouts.message')

@section('content')
<div class="fullWebsiteCoverFill">
    <div class="cover">
        <div class="middleInfo container">
            <div class="topMessage col-lg-7">
                <div class="topCompanyLogo">
                    <img src="<?php echo url('images'); ?>/main_logo.jpg" />
                </div>
                <div class="topTitle">
                    <h3>We're on our way</h3>
                </div>
                <div class="middleDescription">
                    <p>We're currently building our new online store! Check back soon to witness something amazing!</p>
                </div>
            </div>
            <div class="bottomEmailNotification">
                <!-- Begin MailChimp Signup Form -->
                <div id="mc_embed_signup">
                    <form action="https://unmovablestore.us17.list-manage.com/subscribe/post?u=38134ff6ce4992b637f22b249&amp;id=676854c500" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">
                            <a class="button trans" href="https://www.instagram.com/unmovablestore/">Shop our Instagram page</a>
                            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email address" required>
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_38134ff6ce4992b637f22b249_676854c500" tabindex="-1" value=""></div>
                            <input type="submit" value="Notify Me" name="subscribe" id="mc-embedded-subscribe" class="button">
                        </div>
                    </form>
                </div>
                <!--End mc_embed_signup-->
            </div>
        </div>
    </div>
</div>
@endsection