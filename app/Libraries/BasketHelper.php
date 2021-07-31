<?php
namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/*
    BasketHelper
    ----
    Desc: This will handle everything for our cart
    Ver: 0.0.1
*/
class BasketHelper
{
    static public $subtotal = 0;

    /*
     * This will catch the
     */
    static public function fetchCart($user_id)
    {
        return DB::table('cart')->where('user_id', $user_id)->get();
    }

    /*
     * This will fetch the cart subtotal before shipping and tax
     */
    static public function fetchCartSubTotal($cart)
    {
        if(count($cart) != 0)
        {
            foreach($cart as $items)
            {
                // Get products
                $product =  DB::table('products')->where('id', $items->product_id)->get();
                $products[] = $product;

                // Create subtotal by adding prices
                self::$subtotal = self::$subtotal + $product[0]->product_price;
            }

            return self::$subtotal;
        }else{
            return 0;
        }

    }

    /*
     * This will empty the entire cart
     */
    static public function emptyCart($user_id)
    {
        DB::table('cart')->where('user_id', $user_id)->delete();
        return redirect("cart")->with('success', 'All products have been removed from your cart');
    }

    /*
     * This will add a product to the cart
     */
    static public function addToCart($user_id, $product = array())
    {
        $insert = DB::table('cart')->insert(
            ['user_id' => $user_id, 'product_id' => $product['product_id'], 'product_size' => $product['product_size'], 'product_size_number' => $product['product_size_number'], 'quantity' => '1']
        );

        return true;
    }

    /*
     * This will remove a product from the cart
     */
    static public function removeFromCart($cartItemId)
    {
        DB::table('cart')->where('id', $cartItemId)->delete();
        return redirect("cart")->with('success', 'Product has been removed from your cart');
    }
}
