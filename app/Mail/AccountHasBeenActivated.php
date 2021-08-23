<?php

namespace App\Mail;

use Illuminate\Support\Facades\DB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Libraries\OrderingSystem;

class AccountHasBeenActivated extends Mailable
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
    public function __construct($user_id)
    {
        $this->user = DB::table('users')->where('id', $user_id)->get()[0];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('templates.emails.AcountHasBeenActivated')->with([
            'fullName' => $this->user->name,
        ]);
    }
}
