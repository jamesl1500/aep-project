@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="accountMainContainer">
        <div class="bannerMainTop admin" style="">
            <div class="innerBanner">
                <h3>Admin Panel</h3>
            </div>
        </div>
        <div class="bottomMainContainer container">
            <div class="row">
                <div class="leftNavigations col-lg-3">
                    <!-- Main User Settings -->
                    <div class="navigationBlock">
                        <div class="innerBlock">
                            <h3>Navigation</h3>
                            <ul>
                                <li><a href="{{ route('account.index') }}">Account Dashboard</a></li>
                                <li><a href="{{ route('account.account_addresses') }}">Account Addresses</a></li>
                                <li><a href="{{ route('account.order_history') }}">Order History</a></li>
                            </ul>
                        </div>
                    </div>

                    <?php
                    if(auth()->user()->type == "admin"){
                    ?>
                            <!-- Main Admin Settings -->
                    <div class="navigationBlock">
                        <div class="innerBlock">
                            <h3>Admin Settings</h3>
                            <ul>
                                <li><a href="/account/admin/manage_admins">Manage Admins</a></li>
                                <li><a href="{{ route('account.admin.manage_categories') }}">Manage Categories</a></li>
                                <li><a href="{{ route('account.admin.manage_brands') }}">Manage Brands</a></li>
                                <li><a href="{{ route('account.admin.manage_products') }}">Manage Products</a></li>
                                <li><a href="{{ route('account.admin.manage_orders') }}">Manage Orders</a></li>
                                <li class="active"><a href="{{ route('account.admin.manage_site_properties') }}">Manage Site</a></li>
                                <li><a href="{{ route('account.admin.manage_users') }}">Manage Users</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="rightInfoContainer col-lg-9">
                    <div class="innerContainer">
                        <div class="topPartMain">
                            <h3>Manage Site Properties</h3>
                        </div>
                        <div class="accountInfo">
                            <div class="innerInfo">
                                <div class="quickOrderList">
                                    <div class="innerOrders">
                                        <div class="innerOrdersHold">
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            <form action="{{ route('account.admin.manage_site_properties.update') }}" id="editSiteProperties" method="post" enctype="multipart/form-data">
                                                <?php
                                                    $props = DB::table('site_props')->where('id', 1)->get();
                                                ?>
                                                <div class="inputMain">
                                                    <h3>Site Description</h3>
                                                    <p>*Will be displayed on the "About Us" page*</p>
                                                    <textarea style="max-height: 300px;" name="site_desc" id="site_desc" placeholder="Site description" value="<?php echo $props[0]->about_us_text; ?>"><?php echo $props[0]->about_us_text; ?></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Return Policy</h3>
                                                    <textarea style="max-height: 300px;" name="site_return_policy" id="site_return_policy" placeholder="Return policy" value="<?php echo $props[0]->return_policy; ?>"><?php echo $props[0]->return_policy; ?></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>FAQ Text</h3>
                                                    <textarea style="max-height: 300px;" name="faq_text" id="faq_text" placeholder="FAQ Text" value="<?php echo $props[0]->faq_text; ?>"><?php echo $props[0]->faq_text; ?></textarea>
                                                </div>
                                                <hr />

                                                <div class="inputMain">
                                                    <h3>Instagram</h3>
                                                    <textarea style="max-height: 300px;" name="instagram_link" id="instagram_link" placeholder="Instagram Link" value="<?php echo $props[0]->instagram_link; ?>"><?php echo $props[0]->instagram_link; ?></textarea>
                                                </div>
                                                <div class="inputMain">
                                                    <h3>Twitter</h3>
                                                    <textarea style="max-height: 300px;" name="twitter_link" id="twitter_link" placeholder="Twitter Link" value="<?php echo $props[0]->twitter_link; ?>"><?php echo $props[0]->twitter_link; ?></textarea>
                                                </div>
                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div><br />
                                        <div class="innerOrdersHold" style="padding-top: 20px;border-top: 1px solid #eee;">
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            <form action="{{ route('account.admin.manage_site_properties.upload_hero_image') }}" method="post" enctype="multipart/form-data" class="addHeroImage">
                                                <?php
                                                    $props = DB::table('site_props')->where('id', 1)->get();
                                                ?>
                                                <h3>Storefront Hero Images</h3>
                                                <div class="innerHeroImage">
                                                    <div class="currentPictures">
                                                        <p style="font-weight: bold;">Current Images</p>
                                                    <?php
                                                        $hero_images = DB::table('hero_banner_images')->get();

                                                        foreach($hero_images as $hero_image)
                                                        {
                                                        ?>
                                                        <div class="hero-item" id="hero-<?php echo $hero_image->id; ?>" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                                                            <img style="width: 250px;" class="d-block" src="{{ asset("images/") }}/<?php echo $hero_image->hero_image_url; ?>" alt="First slide">
                                                            <div class="hero-item-inner" style="padding-top: 10px;">
                                                                <h5 style="font-size: 20px;"><b>Hero Title:</b> <?php echo $hero_image->hero_image_title; ?></h5>
                                                                <p style="font-size: 15px;"><b>Hero Text:</b> <?php echo $hero_image->hero_image_text; ?></p>
                                                                <button data-token="{{  csrf_token() }}" data-hid="<?php echo $hero_image->id; ?>" data-link="{{ route('account.admin.manage_site_properties.delete_hero_image') }}" style="margin-bottom: 20px;" class="btn btn-danger delete_hero_image_btn">Delete Image</button>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                    ?>
                                                    </div>
                                                    <div class="addNewHeroImage">
                                                        <p style="font-weight: bold;">Add new image</p>
                                                        <div class="innerAddNew">
                                                                <div class="inputMain">
                                                                    <h3>Hero Image</h3>
                                                                    <input type="file" name="hero_image" id="hero_image" placeholder="Product Image" />
                                                                </div>
                                                                <div class="inputMain">
                                                                    <h3>Hero Title</h3>
                                                                    <input type="text" name="hero_title" id="hero_title" placeholder="Hero Title"/>
                                                                </div>
                                                                <div class="inputMain">
                                                                    <h3>Hero Text</h3>
                                                                    <input type="text" name="hero_text" id="hero_title" placeholder="Hero Title"/>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br /><br /><br />
@endsection