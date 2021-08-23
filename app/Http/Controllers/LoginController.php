<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function logout(){
        session_start();
        unset($_SESSION['aep_session']);

        Auth::logout();

        
        return redirect('/gatekeeper');
    }
}
