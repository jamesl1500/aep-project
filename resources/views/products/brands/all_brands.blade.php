@section('cpn', $cpn )
@section('wn', $wn )

@extends('layouts.store')

@section('website_content')
    <div class="mainProductBanner">
        <div class="innerProductBanner container">
            <h3>Brands</h3>
            <p>View all of the brands we offer</p>
        </div>
    </div>
    <div class="container allProducts">
        <ul class="responsiveCategories">
            <?php
            // For getting brands
            $brands = DB::table('brands')->get();

            if(count($brands) > 0)
            {
            foreach($brands as $brand)
            {
            ?>
            <li onClick="document.location.assign('<?php echo url('/'); ?>/products/brands/<?php echo $brand->name; ?>');">
                <div class="brand_image" style="background: <?php echo $brand->color; ?>;text-align: center;">
                    <img style="margin-top: 80px;width: 70%;" src="<?php echo url('images'); ?>/<?php echo $brand->image; ?>" />
                </div>
                <h3 style="padding-top: 30px;">
                    <?php echo $brand->name; ?>
                </h3>
            </li>
            <?php
            }
            }
            ?>
        </ul>
    </div>
@endsection