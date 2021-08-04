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
            redirect('/store');
        }else{
            return view('auth.login');
        }
    }
}
