<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    public function send(Request $request)
    {
        if(isset($_POST))
        {
            $validation = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'subject' => 'required|max: 255',
                'message' => 'required|max: 1000'
            ]);

            // Now send
            Mail::to('skylineboss@gmail.com')->send(new ContactForm(['firstname' => $request->firstname, 'lastname' => $request->lastname, 'email' => $request->email, 'subject' => $request->subject, 'message' => $request->message]));

            // Were good
            return redirect('help')->with('success', 'Message Sent!');

        }
    }
}
