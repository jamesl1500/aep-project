<?php
namespace App\Libraries;
use Illuminate\Support\Facades\DB;

/*
    CategoriesHelper
    ----
    Desc: This will handle everything for categories
    Ver: 0.0.1
*/
class CategoriesHelper
{
    static public $returnedCats = array();

    /*
     * GatherCategories
     * ----
     * This will return the categories in the database
     */
    static public function gatherCategories(int $status = 1)
    {
        // See if theres any categories
        $categories = DB::table('category')->get();

        foreach ($categories as $category)
        {
            // Add conditions
            if($category->status == $status)
            {
                // add this to the array
                self::$returnedCats[$category->id] = array('id' => $category->id, 'name' => $category->name, 'status' => $category->status, 'special' => $category->special, 'display_nav' => $category->display_nav, 'created_date' => $category->created_date, 'updated_last' => $category->updated_last, 'deleted' => $category->deleted, 'sub_categories' => self::gatherSubCategories($category->id));
            }
        }
        
        return self::$returnedCats;
    }

    /*
     * GatherSubCategories
     * ----
     * This will return the sub categories for a category in the database
     */
    static public function gatherSubCategories(int $parentCat, int $status = 1)
    {
        // See if theres any categories
        $categories = DB::table('sub_category')->get();
        $returnedSubCats = array();

        foreach ($categories as $category)
        {
            // Add conditions
            if($category->status == $status && $category->parent_cat == $parentCat)
            {
                // add this to the array
                $returnedSubCats[$category->id] = array('id' => $category->id, 'parent_cat' => $category->parent_cat, 'name' => $category->name, 'status' => $category->status, 'special' => $category->special, 'display_nav' => $category->display_nav);
            }
        }

        return $returnedSubCats;
    }
}