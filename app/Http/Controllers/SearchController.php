<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    // Website Name
    public $wn; 

    // Curent page name
    public $cpn;

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
        // Lets input some page info
        $this->cpn = "Search";

        return view('search', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => 'search.css']);
    }
}
