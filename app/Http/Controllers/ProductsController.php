<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Storage;
use App\Http\Controllers\Controller;


class ProductsController extends Controller
{
    // Website Name
    public $wn; 

    // Curent page name
    public $cpn;

    public $ss = "products.css";

    // Constructor
    public function __construct()
    {
        // Popular vars
        $this->wn = env('APP_NAME');
    }

    //
    public function all_products(){
        $this->cpn = "Products";
        return view('products.index', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss]);
    }

    public function view_brand($brand){
        $this->cpn = "Brands";
        return view('products.brands.view_brand', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss, 'brand' => $brand]);
    }

    public function all_brands(){
        $this->cpn = "Brands";
        return view('products.brands.all_brands', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss]);
    }

    public function view_category($category){
        $this->cpn = "Categories";
        return view('products.category.view_category', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss, 'category' => $category]);
    }

    public function all_category(){
        $this->cpn = "Categories";
        return view('products.brands.all_brands', ['wn' => $this->wn, 'cpn' => $this->cpn, 'ss' => $this->ss]);
    }
    
    public function delete_product()
    {
        // Make sure the product exist
        $product = DB::table('products')->where('id',''. $_POST['pid'] .'')->get()[0];
        if(count($product) != 0)
        {
             // Now just delete it
             DB::table('products')->where('id', ''.$_POST['pid'].'')->delete();
            
             // Return MSG
             echo json_encode(array('code' => 1, 'status' => 'Product has been deleted'));
        }
    }

    public function edit_product(Request $request)
    {
        // Make sure the product exist
        $product = DB::table('products')->where('id',''. $request->pid  .'')->get()[0];
        $image = $product->product_photo;

        if(!empty($product))
        {
            // Check values
            if(!isset($_FILES['product_image']) && $_FILES['product_image'] == "")
            {
                $request->validate([
                    'product_title' => 'required|max:255',
                    'product_desc' => 'required',
                    'product_tags' => 'required',
                    'product_price' => 'required|numeric',
                    'product_gender' => 'required',
                    'product_category' => 'required|numeric',
                    'product_sub_category' => 'required|numeric',
                    'product_sizing' => '',
                    'product_brand' => 'required',
                    'weight' => 'required|numeric',
                    'length' => 'required|numeric',
                    'width' => 'required|numeric',
                    'height' => 'required|numeric',
                    'product_key_features' => 'required',
                    'product_sku_root' => 'required',
                    'product_sku' => 'required'
                ]);
            }else{
                $request->validate([
                    //'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                    'product_title' => 'required|max:255',
                    'product_desc' => 'required',
                    'product_tags' => 'required',
                    'product_price' => 'required|numeric',
                    'product_gender' => 'required',
                    'product_category' => 'required|numeric',
                    'product_sub_category' => 'required|numeric',
                    'product_sizing' => '',
                    'product_brand' => 'required',
                    'weight' => 'required|numeric',
                    'length' => 'required|numeric',
                    'width' => 'required|numeric',
                    'height' => 'required|numeric',
                    'product_key_features' => 'required',
                    'product_sku_root' => 'required',
                    'product_sku' => 'required'
                ]);

                // Validate image
                if($request->product_image == "")
                {
                    $image = $product->product_photo;
                }else{
                    $image = time() . '.' . $request->product_image->getClientOriginalExtension();
                    $request->product_image->move(public_path('images'), $image);
                }
            }

            // For thumbnails
            if($request->hasfile('product_image_thumbnails'))
            {
                $files = $request->file('product_image_thumbnails');

                foreach ($files as $photo)
                {
                    // Save
                    $extension = $photo->getClientOriginalExtension();
                    $filename  = rand(1, 1000) . '_product_thumbnail_' . time() . '.' . $extension;
                    $photo->move(public_path('images/thumbnails'), $filename);

                    // Insert
                    DB::table('product_thumbnails')->insert(
                        [
                            'product_id' => $request->pid,
                            'product_thumbnail' => $filename,
                        ]
                    );
                }
            }

            // Update sizing
            if($request->size_name && $request->size_stock)
            {
                $number_sizing_name = count($request->size_name);
                $number_sizing_stock = count($request->size_stock);

                if($number_sizing_name > 0 && $number_sizing_stock > 0 && $number_sizing_name == $number_sizing_stock)
                {
                    //$sizes = DB::table('product_sizing')->where('product_sizing_id',''. $product->product_sizing  .'')->get()[0];
                    // Erase all sizes and reinsert them
                    DB::table('product_sizing')->where('product_sizing_id', '=', ''.$product->product_sizing.'')->delete();

                    for($i=0; $i<$number_sizing_name; $i++)
                    {
                        //echo $request->size_name[$i];
                        //echo $request->size_stock[$i];

                        // See if this size exist
                        /*$sizes = DB::table('product_sizing')->where('product_sizing_id',''. $product->product_sizing  .'')->get()[0];

                        if(count($sizes) > 0)
                        {

                        }else{
                            // Just insert

                        }*/


                        DB::table('product_sizing')->insert(
                            [
                                'product_sizing_id' => $product->product_sizing,
                                'product_id' => $request->pid,
                                'product_size' => $request->size_name[$i],
                                'product_size_stock' => $request->size_stock[$i]
                            ]
                        );
                    }
                }
            }

            // Product dimensions
            $product_dimensions = array(
                'weight' => $request->weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height
            );

            // Update everything
            DB::table('products')
                ->where('id', ''.$request->pid.'')
                ->update([
                    'product_photo' => $image,
                    'product_title' => $request->product_title,
                    'product_desc' => $request->product_desc,
                    'product_tags' => $request->product_tags,
                    'product_price' => $request->product_price,
                    'product_gender' => $request->product_gender,
                    'product_category' => $request->product_category,
                    'product_sub_category' => $request->product_sub_category,
                    'product_brands' => $request->product_brand,
                    'product_dimensions' => json_encode($product_dimensions),
                    'product_key_features' => $request->product_key_features,
                    'product_sku_root' => $request->product_sku_root,
                    'product_sku' => $request->product_sku
                ]);

            // Return MSG
            return redirect()->back();
        }
    }

    public function removeThumbnail(Request $request)
    {
        // Now just delete it
        DB::table('product_thumbnails')->where('id', ''.$request->thumbid.'')->delete();

        // Return MSG
        echo json_encode(array('code' => 1, 'status' => 'Product has been deleted'));
    }
}
