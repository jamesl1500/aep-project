<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\BasketHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    //
    public function index()
    {
        // Make sure the cart is full
        if(Auth::check())
        {
            if (count(BasketHelper::fetchCart(auth()->user()->id)) >= 1)
            {
                return view('checkout', [
                    'braintree_customer_id' => auth()->user()->customer_id
                ]);
            } else {
                return redirect("cart")->with('error', 'Your cart is not full yet');
            }
        }else{
            if(count(BasketHelper::fetchCart($_COOKIE['user_ip'])) >= 1)
            {
                return view('checkout');
            }else {
                return redirect("cart")->with('error', 'Your cart is not full yet');
            }
        }
    }

    public function shipping(Request $request)
    {
        if(Auth::check())
        {
            $products = BasketHelper::fetchCart(auth()->user()->id);
        }else{
            $products = BasketHelper::fetchCart($_COOKIE['user_ip']);
        }

        $dimensions = array();

        // Get dimensions
        foreach($products as $product)
        {
            $p = DB::table("products")->where('id', $product->product_id)->get()[0];

            // Decode dimensions
            $d = json_decode($p->product_dimensions, true);

            // Add to array
            $dimensions[] = array('parcel' => $d);
        }

        // Make shipment
        \EasyPost\EasyPost::setApiKey('FGET2SomNVI1rR1mXQajRQ');

        $to_address = \EasyPost\Address::create(array(
            'street1' => $request->address_one,
            'street' => $request->address_two,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => '44053',
        ));
        $from_address = \EasyPost\Address::create(array(
            'street1' => '2914 york dr',
            'street' => '',
            'city' => 'lorain',
            'state' => 'Ohio',
            'zip' => '44053',
        ));
        $shipment = \EasyPost\Order::create(array(
            'from_address' => $to_address,
            'to_address' => $from_address,
            'shipments' => $dimensions
        ));

        // Run through the rates
        $rates = array();

        foreach($shipment['rates'] as $rate)
        {
            $rates[] = array(
                'rate_id' => $rate['id'],
                'service' => $rate['service'],
                'carrier' => $rate['carrier'],
                'price' => $rate['rate'],
                'shipment_id' => $rate['shipment_id'],
                'est_delivery' => $rate['est_delivery_days']
            );
        }

        arsort($rates);
        echo json_encode($rates);
    }
}
