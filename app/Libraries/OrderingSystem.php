<?php
namespace App\Libraries;

use App\Mail\OrderConfirmation;

use App\Http\Controllers\Cart;
use Illuminate\Http\Request;
use App\Libraries\BasketHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Braintree_Transaction;

/*
    OrderingSystem
    ----
    Desc: This will help display things on the header dynamically!
    Ver: 0.0.1
*/
class OrderingSystem
{

    /*
     * This will create the order
     */
    public function create($order)
    {
        // Now we will get the cart info
        $cart = BasketHelper::fetchCart($order['user_id']);

        // Insert order
        $new = DB::table('orders')->insert(
          [
              'user_id'=>$order['user_id'],
              'order_id'=>$order['hash'],
              'order_date'=>date('y-m-d H:i:s'),
              'order_status'=>$order['status'],
              'order_products'=>json_encode($cart),
              'order_cost'=>$order['total'],
              'order_tn'=>'',
              'order_address'=>$order['address'],
              'order_transaction_id'=>$order['transaction_id'],
              'order_shipping' => json_encode($order['shipping'])
          ]
        );
        
        // Now return true since everything is working
        return true;
    }

    /*
     * This will make that payment
     */
    public function payment($payment)
    {
        // We will now verify the order
        $order = DB::table('orders')->where('order_id', $payment['order_id'])->get();

        if(count($order) == 1)
        {
            // Get user info
            //$user = DB::table('users')->where('id', $order[0]->user_id)->get();

            // Users name split up
            if(count(explode(" ", $payment['fullname'])) == 2)
            {
                // First & Lastname
                $firstname = explode(" ", $payment['fullname'])[0];
                $lastname = explode(" ", $payment['fullname'])[1];
            }else{
                $firstname = explode(" ", $payment['fullname'])[0];
                $lastname = explode(" ", $payment['fullname'])[1] . ' ' . explode(" ", $payment['fullname'])[2];
            }

            // Address
            $address = json_decode($order[0]->order_address, true);

            // Now we have the info, lets process payment
            $result = Braintree_Transaction::sale([
                'amount' => $order[0]->order_cost,
                'paymentMethodNonce' => $payment['payment_method_nonce'],
                'options' => [
                    'submitForSettlement' => True
                ],
                'customer' => [
                  'firstName' => $firstname,
                  'lastName' => $lastname,
                  'email' => $payment['email']
                ],
                'billing' => [
                    'firstName' => $firstname,
                    'lastName' => $lastname,
                    'streetAddress' => $address['address1'],
                    'extendedAddress' => $address['address2'],
                    'locality' => $address['city'],
                    'region' => $address['state'],
                    'postalCode' => $address['zip_code'],
                    'countryCodeAlpha2' => 'US'
                ],
                'shipping' => [
                    'firstName' => $firstname,
                    'lastName' => $lastname,
                    'streetAddress' => $address['address1'],
                    'extendedAddress' => $address['address2'],
                    'locality' => $address['city'],
                    'region' => $address['state'],
                    'postalCode' => $address['zip_code'],
                    'countryCodeAlpha2' => 'US'
                ]
            ]);

            if($result->success)
            {
                // Create shipment
                $dimensions = array();

                $products = json_decode($order[0]->order_products, true);

                // Get dimensions
                foreach($products as $product)
                {
                    $p = DB::table("products")->where('id', $product['product_id'])->get()[0];

                    // Decode dimensions
                    $d = json_decode($p->product_dimensions, true);

                    // Add to array
                    $dimensions[] = array('parcel' => $d);
                }

                // Make shipment
                /*\EasyPost\EasyPost::setApiKey('FGET2SomNVI1rR1mXQajRQ');

                $to_address = \EasyPost\Address::create(array(
                    'street1' => $address['address1'],
                    'street' => $address['address2'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'zip' => $address['zip_code'],
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
                ));*/
                

                // Now update the order with new stuff
                DB::table('orders')->where('order_id', $payment['order_id'])->update(['order_transaction_id' => $result->transaction->id, 'order_status'=> 'paid']);

                // Now lets email both parties
                Mail::to($payment['email'])->send(new OrderConfirmation($payment['order_id'], $payment['fullname']));
                Mail::to('unmovablestore@gmail.com')->send(new OrderConfirmation($payment['order_id'], $payment['fullname']));

                // Update product stock & empty cart
                BasketHelper::emptyCart($order[0]->user_id);

                $products = json_decode($order[0]->order_products, true);

                // Inerate
                foreach($products as $product)
                {
                    // Get stock
                    $info = DB::table('product_sizing')->where([
                        ['product_sizing_id', '=', $product['product_size']],
                        ['product_size', '=', $product['product_size_number']],
                        ['product_id', '=', $product['product_id']]
                    ])->get();

                    // New stock
                    $stock = $info[0]->product_size_stock - $product['quantity'];

                    // Update stock
                    DB::table('product_sizing')->where([
                        ['product_sizing_id', '=', $product['product_size']],
                        ['product_size', '=', $product['product_size_number']],
                        ['product_id', '=', $product['product_id']]
                    ])->update(
                        ['product_size_stock' => $stock]
                    );
                }
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    static public function fetchOrderPaymentInfo($trans_id)
    {
        return Braintree_Transaction::find($trans_id);
    }

    static public function changeStatus($order_id, $change)
    {
        DB::table('orders')->where('order_id', $order_id)->update(['order_status'=>$change]);
        return true;
    }
    
    static public function fetchOrder($order_id)
    {
        $orders = DB::table('orders')->where('order_id',$order_id)->get();
        return $orders;
    }

    public function returnUsersOrders(int $userid)
    {
        // First query
        $orders = DB::table('orders')->where('user_id',''. $userid .'')->get();
        return $orders;
    }

}