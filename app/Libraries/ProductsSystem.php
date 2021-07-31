<?php
namespace App\Libraries;

use App\Libraries\CategoriesHelper;
use Illuminate\Support\Facades\DB;

/*
    ProductsSystem
    ----
    Desc: This will help display things on the header dynamically!
    Ver: 0.0.1
*/
class ProductsSystem
{

    public function returnAllProducts($specific = "")
    {
        // First query
        if($specific == "")
        {
            $products = DB::table('products')->get();
        }else{
            $products = DB::table('products')->where('product_brands',''. $specific .'')->get();
        }
        return $products;
    }
    
}