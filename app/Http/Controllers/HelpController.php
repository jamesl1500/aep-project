<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    // Website Name
    public $wn; 

    // Curent page name
    public $cpn = "Help";

    // Stylesheet
    public $ss = "help.css";

    // Constructor
    public function __construct()
    {

        // Popular vars
        $this->wn = env('APP_NAME');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('help', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss]);

    }
}
