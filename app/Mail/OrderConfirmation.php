<?php

namespace App\Mail;

use Illuminate\Support\Facades\DB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\OrderingSystem;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $fullname)
    {
        //
        $this->order = OrderingSystem::fetchOrder($order_id)[0];
        
        // User info
        $this->user = $fullname;

        // Url
        $this->url = url('/') . "/order/" . $order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('templates.emails.order_confirmation')->with([
            'fullName' => $this->user,
            'url' => $this->url
        ]);
    }
}
