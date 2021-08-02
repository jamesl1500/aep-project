<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GateKeeperController extends Controller
{
    //
    public function index()
    {
        if(Auth::check())
        {
            echo "Logged";
        }else{
            return view('auth.login');
        }
    }
}
