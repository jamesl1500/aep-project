<?php
namespace App\Libraries;

use App\Libraries\CategoriesHelper;

/*
    HeaderFunctions
    ----
    Desc: This will help display things on the header dynamically!
    Ver: 0.0.1
*/
class HeaderFunctions
{

    public function returnCategories()
    {
        return CategoriesHelper::gatherCategories();
    }

}