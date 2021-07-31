<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\AddressesHelper;
use Illuminate\Support\Facades\Auth;
use App\Libraries\OrderingSystem;

class AccountController extends Controller
{
    public $stylesheet = "account";

    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('account.index', ['stylesheet' => $this->stylesheet]);
    }

    public function order_history()
    {
        return view('account.order_history', ['stylesheet' => $this->stylesheet]);
    }

    public function account_addresses()
    {
        return view('account.account_addresses', ['stylesheet' => $this->stylesheet]);
    }

    public function add_new_address()
    {
        return view('account.addresses.add_address', ['stylesheet' => $this->stylesheet]);
    }

    /* Admin routes */
    public function manage_admins()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_admins', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function add_category()
    {
        if(Auth::user()->admin == 1) {
            return view('account.admin.categories.add_category', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function add_sub_category()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.categories.add_sub_category', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_categories()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_categories', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function add_brand()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.brands.add_brand', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_brands()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_brands', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_products()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_products', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_orders()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_orders', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_site_properties()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.manage_site_properties', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function edit_order($order_id)
    {
        if(Auth::user()->admin == 1)
        {
            if (count(OrderingSystem::fetchOrder($order_id)) == 1)
            {
                return view('account.admin.orders.edit_order', ['stylesheet' => $this->stylesheet, 'order_id' => $order_id]);
            } else {
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function add_product()
    {
        if(Auth::user()->admin == 1)
        {
            return view('account.admin.products.add_product', ['stylesheet' => $this->stylesheet]);
        }else{
            return redirect('/');
        }
    }

    public function manage_categories_update(Request $request)
    {
        if (isset($_POST)) {
            if ($request->value != "" && $request->pk != "" && $request->name != "") {
                DB::table('category')->where('id', $request->pk)->update(['' . $request->name . '' => $request->value]);
            } else {
                echo 'no2';
            }
        } else {
            echo 'no1';
        }
    }

    public function manage_sub_categories_update(Request $request)
    {
        if (isset($_POST)) {
            if ($request->value != "" && $request->pk != "" && $request->name != "") {
                DB::table('sub_category')->where('id', $request->pk)->update(['' . $request->name . '' => $request->value]);
            } else {
                echo 'no2';
            }
        } else {
            echo 'no1';
        }
    }

    public function manage_brands_update(Request $request)
    {
        if (isset($_POST)) {
            if ($request->value != "" && $request->pk != "" && $request->name != "") {
                DB::table('brands')->where('id', $request->pk)->update(['' . $request->name . '' => $request->value]);
            } else {
                echo 'no2';
            }
        } else {
            echo 'no1';
        }
    }

    /*
     * Admin process
     */
    public function add_category_process(Request $request)
    {
        if (isset($_POST))
        {
            if (Auth::check())
            {
                // Make sure its an admin
                if (auth()->user()->admin == 1)
                {
                    if ($request->category_name != "" && $request->status != "" && $request->special != "" && $request->display_nav != "")
                    {
                        // Now insert
                        DB::table('category')->insert(
                            [
                                'name' => $request->category_name,
                                'subline_text' => $request->subline_text,
                                'status' => $request->status,
                                'special' => $request->special,
                                'display_nav' => $request->display_nav,
                                'created_date' => date('y-m-d H:i:s'),
                                'updated_last' => date('y-m-d H:i:s'),
                                'deleted' => '0'
                            ]
                        );

                        return redirect("account/admin/manage_categories")->with('success', 'Category added successfully!');
                    } else {
                        return redirect("account/admin/add_category")->with('error', 'Please fill in all fields!');
                    }
                } else {
                    return redirect("login")->with('error', 'Must be an admin');
                }
            } else {
                return redirect("login")->with('error', 'Must be logged in!');
            }
        } else {
            return redirect("account/admin/add_category")->with('error', 'Invalid Request, Please try again!');
        }
    }

    public function add_sub_category_process(Request $request)
    {
        if (isset($_POST))
        {
            if (Auth::check())
            {
                // Make sure its an admin
                if (auth()->user()->admin == 1)
                {
                    if ($request->category_name != "" && $request->status != "" && $request->special != "" && $request->display_nav != "")
                    {
                        // Now insert
                        DB::table('sub_category')->insert(
                            [
                                'name' => $request->category_name,
                                'subline_text' => $request->subline_text,
                                'parent_cat' => $request->parent_cat,
                                'status' => $request->status,
                                'special' => $request->special,
                                'display_nav' => $request->display_nav,
                            ]
                        );

                        return redirect("account/admin/manage_categories")->with('success', 'Sub-Category added successfully!');
                    } else {
                        return redirect("account/admin/add_sub_category")->with('error', 'Please fill in all fields!');
                    }
                } else {
                    return redirect("login")->with('error', 'Must be an admin');
                }
            } else {
                return redirect("login")->with('error', 'Must be logged in!');
            }
        } else {
            return redirect("account/admin/add_category")->with('error', 'Invalid Request, Please try again!');
        }
    }

    /*
     * Add brand process
     */
    public function add_brand_process(Request $request)
    {
        if (isset($_POST))
        {
            if (Auth::check())
            {
                // Make sure its an admin
                if (auth()->user()->admin == 1)
                {
                    if ($request->brand_image != "" &&$request->name != "" && $request->status != "" && $request->desc != "")
                    {
                        // Check image and values
                        $request->validate([
                            'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                            'name' => 'required|unique:brands|max:255',
                            'desc' => 'required',
                            'status' => 'required'
                        ]);

                        // Insert the image
                        $image_name = time() . '.' . $request->brand_image->getClientOriginalExtension();
                        $request->brand_image->move(public_path('images'), $image_name);

                        // Now insert
                        DB::table('brands')->insert(
                            [
                                'name' => $request->name,
                                'hidden' => $request->status,
                                'desc' => $request->desc,
                                'image' => $image_name
                            ]
                        );

                        return redirect("account/admin/manage_brands")->with('success', 'Brand added successfully!');
                    } else {
                        return redirect("account/admin/add_brand")->with('error', 'Please fill in all fields!');
                    }
                } else {
                    return redirect("login")->with('error', 'Must be an admin');
                }
            } else {
                return redirect("login")->with('error', 'Must be logged in!');
            }
        } else {
            return redirect("account/admin/add_category")->with('error', 'Invalid Request, Please try again!');
        }
    }

    /*
     * Adding addresses process
     */
    public function add_address_process(Request $request)
    {
        // Errors
        $errors = array();

        if (isset($_POST)) {
            if (Auth::check()) {
                // Validation
                if (empty($_POST['address_one'])) {
                    return redirect("account/add_address")->with('error', 'Please fill in your address');
                }

                if (empty($_POST['city'])) {
                    return redirect("account/add_address")->with('error', 'Please fill in your city');
                }

                if (empty($_POST['state'])) {
                    return redirect("account/add_address")->with('error', 'Please fill in your state');
                }

                if (empty($_POST['zip_code'])) {
                    return redirect("account/add_address")->with('error', 'Please fill in your zip code');
                }

                // Now insert everything
                DB::table('account_addresses')->insert(
                    ['user_id' => auth()->user()->id, 'address_one' => $_POST['address_one'], 'address_two' => $_POST['address_two'], 'city' => $_POST['city'], 'state' => $_POST['state'], 'zip_code' => $_POST['zip_code']]
                );

                // Redirect
                return redirect("account/account_addresses")->with('success', 'Address added successfully!');
            } else {
                return redirect("login")->with('error', 'Must be logged in!');
            }
        } else {
            return redirect("account/add_address")->with('error', 'Invalid Request, Please try again!');
        }
    }

    /*
     * Adding products
     */
    public function add_product_process(Request $request)
    {
        if (isset($_POST))
        {
            if (Auth::check())
            {
                if (auth()->user()->admin == 1)
                {
                    // Check values
                    $request->validate([
                        'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        'product_title' => 'required|unique:products|max:255',
                        'product_desc' => 'required',
                        'product_tags' => 'required',
                        'product_price' => 'required|numeric',
                        'product_gender' => 'required',
                        'product_category' => 'required|numeric',
                        'product_sub_category' => 'required|numeric',
                        'product_brand' => 'required',
                        'weight' => 'required|numeric',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric'
                    ]);

                    // Insert the image
                    $image_name = time() . '.' . $request->product_image->getClientOriginalExtension();
                    $request->product_image->move(public_path('images'), $image_name);

                    // Create sizing id
                    $product_sizing_id = md5($request->product_title);

                    // Product dimensions
                    $product_dimensions = array(
                        'weight' => $request->weight,
                        'length' => $request->length,
                        'width' => $request->width,
                        'height' => $request->height
                    );

                    // Now insert
                    DB::table('products')->insert(
                        [
                            'product_title' => $request->product_title,
                            'product_desc' => $request->product_desc,
                            'product_category' => $request->product_category,
                            'product_sub_category' => $request->product_sub_category,
                            'product_brands' => $request->product_brand,
                            'product_price' => $request->product_price,
                            'product_photo' => $image_name,
                            'product_tags' => $request->product_tags,
                            'product_gender' => $request->product_gender,
                            'product_sizing' => $product_sizing_id,
                            'product_dimensions' => json_encode($product_dimensions)
                        ]
                    );

                    // Get last insert id
                    $insertId = DB::getPdo()->lastInsertId();

                    // Add sizing
                    if($request->size_name && $request->size_stock)
                    {
                        $number_sizing_name = count($request->size_name);
                        $number_sizing_stock = count($request->size_stock);

                        if($number_sizing_name > 0 && $number_sizing_stock > 0 && $number_sizing_name == $number_sizing_stock)
                        {
                            for($i=0; $i<$number_sizing_name; $i++)
                            {
                                DB::table('product_sizing')->insert(
                                    [
                                        'product_sizing_id' => $product_sizing_id,
                                        'product_id' => $insertId,
                                        'product_size' => $request->size_name[$i],
                                        'product_size_stock' => $request->size_stock[$i]
                                    ]
                                );
                            }
                        }
                    }

                    return redirect("account/admin/manage_products")->with('success', 'Product added successfully!');
                }else {
                    return redirect("login")->with('error', 'Must be an admin');
                }
            }else {
                return redirect("login")->with('error', 'Must be logged in!');
            }
        }else {
            return redirect("account/add_product")->with('error', 'Invalid Request, Please try again!');
        }
    }

    /* Update site props */
    public function update_site_properties(Request $request)
    {
        if (isset($_POST))
        {
            if (Auth::check())
            {
                if (auth()->user()->admin == 1)
                {
                    DB::table('site_props')->where('id', 1)->update(['about_us_text' => ''. $request->site_desc . '', 'return_policy' => '' . $request->site_return_policy . '', 'faq_text' => '' . $request->faq_text . '', 'instagram_link' => '' . $request->instagram_link . '', 'twitter_link' => '' . $request->twitter_link . '']);
                    return redirect("account/admin/manage_site_properties")->with('success', 'Site updated!');
                }
            }
        }
    }

    /* Revoke access */
    public function revoke_admin(Request $request)
    {
        // Update user
        DB::table('users')->where('id', '' . $request->id . '')->update(['admin' => '0']);

        echo json_encode(array('code' => '1'));

    }

    /* Revoke access */
    public function make_admin(Request $request)
    {
        // Update user
        DB::table('users')->where('id', '' . $request->id . '')->update(['admin' => '1']);

        echo json_encode(array('code' => '1'));

    }
}