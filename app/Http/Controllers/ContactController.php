<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    public function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        return array($first_name, $last_name);
    }
    
    //
    public function send(Request $request)
    {
        if(isset($_POST))
        {
            $name = $this->split_name(Auth::user()->name);

            $validation = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'subject' => 'required|max: 255',
                'message' => 'required|max: 1000'
            ]);

            // Now send
            Mail::to('hello@jameslatten.com')->send(new ContactForm(['firstname' => $name[0], 'lastname' => $name[1], 'email' => auth::user()->email, 'subject' => $request->subject, 'message' => $request->message]));

            // Were good
            return redirect('help')->with('success', 'Message Sent!');

        }
    }
}
