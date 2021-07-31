<?php
namespace App\Libraries;
use Illuminate\Support\Facades\DB;

/*
    CategoriesHelper
    ----
    Desc: This will handle everything for categories
    Ver: 0.0.1
*/
class AddressesHelper
{
    static public $returnedCats = array();

    /*
     * GatherCategories
     * ----
     * This will return the categories in the database
     */
    static public function insert(int $status = 1)
    {
        // See if theres any categories
        $categories = DB::table('category')->get();
    }

}
