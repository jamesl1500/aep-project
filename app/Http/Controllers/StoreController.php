<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
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
     * Index Page
     * ---------
     * This function will craft the index page for us
     * and it will have middleware to allow only approved
     * users
     * 
     * wn = Website Name
     * cpn = Current Page Name
     * sh = Selected Header
     */
    public function index()
    {
        // Lets input some page info
        $this->cpn = "Store";

        // Show face
        return view('store.index', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => 'store.css']);
    }

    /**
     * Parent Category Page
     * ---------
     * This function will craft the parent category page 
     * and will display any sub category under it and featured products
     * 
     * $catid (var) = Category ID
     */
    public function parent_category($catid)
    {

    }

    /**
     * Sub Category Page
     * ---------
     * This function will craft the sub category page and 
     * allow the customer to view the sub category
     * 
     * $pcatid (var) = Parent Category ID
     * $subcatid (var) = Sub Category ID
     *  
     */ 
    public function sub_category_page($pcatid, $subcatid)
    {

    }
}
