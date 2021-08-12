<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\BasketHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Website Name
    public $wn; 

    // Curent page name
    public $cpn = "Help";

    // Stylesheet
    public $ss = "help.css";

    // Constructor
    public function __construct()
    {

        // Popular vars
        $this->wn = env('APP_NAME');
    }

    // Vars
    private $addCartSizeId;
    private $addCartProductSizingId;
    private $addCartProductId;
    private $addCartSize;

    //
    public function index()
    {
        if(Auth::check())
        {
            return view('cart', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss]);
        }else{
            //return view('cart');
            return redirect("login")->with('error', 'Must be logged in!');
        }
    }

    public function addToCart(Request $request)
    {
        if(isset($_POST))
        {
            // Make sure they're logged in
            if(Auth::check())
            {
                // Get array
                $sizingInfo = explode("|", $_POST['sizeSelect']);

                // Plug vars
                $this->_addCartSizeId = $sizingInfo[0];
                $this->_addCartProductSizingId = $sizingInfo[1];
                $this->_addCartProductId = $sizingInfo[2];
                $this->_addCartSize = $sizingInfo[3];

                // Make sure this product exist
                $product = DB::table('products')->where('id', '' . $_POST['pid'] . '')->get();

                if (count($product) == 1)
                {
                    // Now lets check the sizes stock
                    $stock = DB::table('product_sizing')->where([
                        ['id', '=', $this->_addCartSizeId],
                        ['product_sizing_id', '=', $this->_addCartProductSizingId],
                        ['product_id', '=', $this->_addCartProductId],
                    ])->get();

                    // Check to see if it exist first
                    if (count($stock) == 1)
                    {
                        // Make sure its enough
                        if ($stock[0]->product_size_stock >= 1)
                        {
                            // Now add it to their cart
                            BasketHelper::addToCart(auth()->user()->id, array('product_id'=>$this->_addCartProductId, 'product_size'=>$this->_addCartProductSizingId, 'product_size_number'=>$this->_addCartSize));
                            
                            return redirect("cart")->with('success', 'Product has been added to your cart');
                        } else {
                            return redirect("products/single/" . $this->_addCartProductId)->with('error', 'This size is out of stock');
                        }
                    } else {
                        return redirect("products/single/" . $this->_addCartProductId)->with('error', 'Size does not exist!');
                    }
                } else {
                    return redirect("cart")->with('error', 'Product does not exist!');
                }
            }else{
                // See if cart cookie exist
                if(isset($_COOKIE['user_ip']) && isset($_COOKIE['user_cart']))
                {
                    // Get IP
                    $ip = $_COOKIE['user_ip'];

                    // Get cart
                    $cart = json_decode($_COOKIE['user_cart'], true);

                    if($cart['user_id'] == $ip)
                    {
                        // Get array
                        $sizingInfo = explode("|", $_POST['sizeSelect']);

                        // Plug vars
                        $this->_addCartSizeId = $sizingInfo[0];
                        $this->_addCartProductSizingId = $sizingInfo[1];
                        $this->_addCartProductId = $sizingInfo[2];
                        $this->_addCartSize = $sizingInfo[3];

                        // Make sure this product exist
                        $product = DB::table('products')->where('id', '' . $_POST['pid'] . '')->get();

                        if (count($product) == 1)
                        {
                            // Now lets check the sizes stock
                            $stock = DB::table('product_sizing')->where([
                                ['id', '=', $this->_addCartSizeId],
                                ['product_sizing_id', '=', $this->_addCartProductSizingId],
                                ['product_id', '=', $this->_addCartProductId],
                            ])->get();

                            // Check to see if it exist first
                            if (count($stock) == 1)
                            {
                                // Make sure its enough
                                if ($stock[0]->product_size_stock >= 1)
                                {
                                    // Now add it to their cart
                                    BasketHelper::addToCart($_COOKIE['user_ip'], array('product_id'=>$this->_addCartProductId, 'product_size'=>$this->_addCartProductSizingId, 'product_size_number'=>$this->_addCartSize));

                                    return redirect("cart")->with('success', 'Product has been added to your cart');
                                } else {
                                    return redirect("products/single/" . $this->_addCartProductId)->with('error', 'This size is out of stock');
                                }
                            } else {
                                return redirect("products/single/" . $this->_addCartProductId)->with('error', 'Size does not exist!');
                            }
                        } else {
                            return redirect("cart")->with('error', 'Product does not exist!');
                        }
                    }
                }
                return redirect("login")->with('error', 'Must be logged in!');
            }
        }
    }
    
    public function emptyCart(Request $request)
    {
        if(Auth::check())
        {
            BasketHelper::emptyCart(auth()->user()->id);
        }else{
            BasketHelper::emptyCart($_COOKIE['user_ip']);
        }
        return redirect("cart")->with('success', 'All products have been removed from your cart');
    }

    public function removeProduct(Request $request)
    {
        BasketHelper::removeFromCart($request->cid);
        return redirect("cart")->with('success', 'Product has been removed from your cart');
    }
}
