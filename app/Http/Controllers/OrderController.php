<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;

use EasyPost\Order;
use Illuminate\Http\Request;
use App\Libraries\BasketHelper;
use App\Libraries\OrderingSystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Braintree_Transaction;

class OrderController extends Controller
{
    protected $order_id;
    protected $shipping = 5;

    public function changeStatus(Request $request)
    {
        if(Auth::check())
        {
            // Validate
            $validate = $request->validate([
                'statusChange' => 'required',
                'order_id' => 'required'
            ]);

            // Now update everything
            OrderingSystem::changeStatus($request->order_id, $request->statusChange);

            // Redirect
            return redirect('account/admin/manage_orders/' . $request->order_id)->with('success', 'This order has been updated!');
        }
    }

    public function refundOrder(Request $request)
    {
        if(Auth::check())
        {
            // Validate
            $validate = $request->validate([
                'order_id' => 'required',
                'trans_id' => 'required',
                'refundAmount' => 'required'
            ]);
            
            // Quick refund
            $refund = Braintree_Transaction::refund($request->trans_id, $request->amount);
            if($refund->success)
            {
                // Change status
                OrderingSystem::changeStatus($request->order_id, 'refunded');

                // Email recipient

                // Redirect
                return redirect('account/admin/manage_orders/' . $request->order_id)->with('success', 'This order has been refunded');
            }else{
                return redirect('account/admin/manage_orders/' . $request->order_id)->with('error', 'Refund failed!');
            }
        }
    }

    public function markAsShipped(Request $request)
    {
        if(Auth::check())
        {
            // Validate
            $validate = $request->validate([
                'tracking_number' => 'required',
                'order_id' => 'required'
            ]);

            // Change status
            OrderingSystem::changeStatus($request->order_id, 'shipped');

            // Create tracker
            \EasyPost\EasyPost::setApiKey('FGET2SomNVI1rR1mXQajRQ');

            $tracker = \EasyPost\Tracker::create([
                'tracking_code' => $request->tracking_number,
                'carrier' => 'USPS'
            ]);

            // Get customer email
            $order = OrderingSystem::fetchOrder($request->order_id)[0];
            $user = DB::table('users')->where('id', $order->user_id)->get();

            // Email recipient
            Mail::to($user[0]->email)->send(new OrderShipped($request->order_id));

            // Update order
            DB::table('orders')->where('order_id', $request->order_id)->update(['order_tn'=>$tracker]);

            // Redirect
            return redirect('account/admin/manage_orders/' . $request->order_id)->with('success', 'Order has been marked as shipped, and the customer will be notified!');
        }else{
            return redirect('/');
        }
    }

    //
    public function create(Request $request)
    {
        // Instantiate id
        $id = "";

        // Make sure its valid
        if(isset($_POST))
        {
            // Validation
            $validation = $request->validate([
                'address_one' => 'required|max:255',
                'city' => 'required|max:255',
                'state' => 'required|max:255',
                'zip_code' => 'required|max:20',
                'shipping' => 'required',
                'fullname' => 'max:255',
                'email' => 'max:255'
            ]);

            // Now make sure the basket is full
            if(Auth::check())
            {
                $id = auth()->user()->id;
            }else{
                $id = $_COOKIE['user_ip'];
            }

            // Run stuff
            if(count(BasketHelper::fetchCart($id)) >= 1)
            {
                // Make sure we have the payment thingy
                if($request->payment_method_nonce)
                {
                    // Now lets make the order
                    $this->_order_id = bin2hex(random_bytes(32));
                    $this->_address = [
                        'address1' => $request->address_one,
                        'address2' => $request->address_two,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code
                    ];
                    
                    // Explode shipping
                    $shipping = explode('|', $request->shipping);

                    // Initiate
                    $orderingSystem = new OrderingSystem();
                    
                    // Put order in variable
                    $order = $orderingSystem->create([
                        'hash' => $this->_order_id,
                        'status' => 'unpaid',
                        'total' => BasketHelper::fetchCartSubTotal(BasketHelper::fetchCart($id)) + $shipping[3],
                        'address' => json_encode($this->_address),
                        'user_id' => $id,
                        'transaction_id' => '',
                        'shipping' => $shipping
                    ]);

                    // Check order
                    if($order)
                    {
                        // Now process payment
                        $payment = $orderingSystem->payment([
                            'order_id' => $this->_order_id,
                            'fullname' => $request->fullname,
                            'payment_method_nonce' => $request->payment_method_nonce,
                            'email' => $request->email,
                            'shipping' => $shipping
                        ]);

                        // Check payment
                        if($payment)
                        {
                            return redirect('order/' . $this->_order_id)->with('success', 'Your order has been placed!');
                        }else{
                            // Error
                            return redirect("checkout")->with('error', 'There was an error while processing your payment, try again');
                        }
                    }else{
                        // Error
                        return redirect("checkout")->with('error', 'There was an error while creating your order, try again');
                    }
                }else{
                    return redirect("checkout")->with('error', 'Please enter your payment info.');
                }
            }else{
                return redirect("cart")->with('error', 'Your cart can\'t be empty!');
            }
        }else{
            return redirect("login")->with('error', 'Must be logged in!');
        }
    }

    public function summary($order_id)
    {
        if(Auth::check() or isset($_COOKIE['user_ip']))
        {
            // Make sure the order exists
            if (count(OrderingSystem::fetchOrder($order_id)) == 1)
            {
                // Make sure this belongs to the logged user
                $order = OrderingSystem::fetchOrder($order_id);

                if ($order[0]->user_id == $_COOKIE['user_ip'] or $order[0]->user_id == auth()->user()->id)
                {
                    return view('order_confirmation', [
                        'order_id' => $order_id
                    ]);
                } else {
                    return redirect("/")->with('error', 'Must be logged in!');
                }
            } else {
                return redirect("/")->with('error', 'Must be logged in!');
            }
        }else{
            return redirect("/login")->with('error', 'Must be logged in!');
        }
    }
}
