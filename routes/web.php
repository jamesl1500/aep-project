<?php

use Illuminate\Support\Facades\Route;

// Controller
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\gateKeeperController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::get('/gatekeeper', [GateKeeperController::class, 'index'])->name('gatekeeper.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Store (Must be logged)
Route::get('/store', [StoreController::class, 'index'])->name('home.index');

// Help
Route::get('/help', [HelpController::class, 'index'])->name('help.index');

// Journal
Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');

// Account
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::get('/account/order_history', [AccountController::class, 'order_history'])->name('account.order_history');
Route::get('/account/account_addresses', [AccountController::class, 'account_addresses'])->name('account.account_addresses');
Route::get('/account/add_address', [AccountController::class, 'add_new_address'])->name('account.add_new_address');

// Admin
Route::get('/account/admin/manage_categories', [AccountController::class, 'manage_categories'])->name('account.admin.manage_categories');
Route::get('/account/admin/add_category', [AccountController::class, 'add_category'])->name('account.admin.add_category');
Route::get('/account/admin/add_sub_category', [AccountController::class, 'add_sub_category'])->name('account.admin.add_sub_category');

Route::get('/account/admin/manage_brands', [AccountController::class, 'manage_brands'])->name('account.admin.manage_brands');
Route::get('/account/admin/add_brand', [AccountController::class, 'add_brand'])->name('account.admin.add_brand');

Route::get('/account/admin/manage_admins', [AccountController::class, 'manage_admins'])->name('account.admin.manage_adminst');

Route::get('/account/admin/manage_products', [AccountController::class, 'manage_products'])->name('account.admin.manage_products');
Route::get('/account/admin/add_product', [AccountController::class, 'add_product'])->name('account.admin.add_product');
Route::get('/account/admin/product/edit/{product_id}', function($product_id){
    return view('account.admin.products.edit_product',['stylesheet' => "account", 'product_id' => $product_id] );
});

Route::get('/account/admin/manage_orders', [AccountController::class, 'manage_orders'])->name('account.admin.manage_orders');
Route::get('/account/admin/manage_orders/{order_id}', [AccountController::class, 'edit_order'])->name('account.admin.edit_orders');

Route::get('/account/admin/manage_site_properties', [AccountController::class, 'manage_site_properties'])->name('account.admin.manage_site_properties');

// Account Requests
Route::post('/account/add_address/process', [AccountController::class, 'add_address_process']);

// Admin requests
Route::post('/account/manage_categories/update', [AccountController::class, 'manage_categories_update']);
Route::post('/account/manage_sub_categories/update', [AccountController::class, 'manage_sub_categories_update']);
Route::post('/account/manage_brands/update', [AccountController::class, 'manage_brands_update']);
Route::post('/account/admin/add_category/process', [AccountController::class, 'add_category_process']);
Route::post('/account/admin/add_sub_category/process', [AccountController::class, 'add_sub_category_process']);
Route::post('/account/admin/add_brand/process', [AccountController::class, 'add_brand_process']);
Route::post('/account/admin/add_product/process', [AccountController::class, 'add_product_process']);
Route::post('/account/admin/manage_site_properties/update', [AccountController::class, 'update_site_properties'])->name('account.admin.manage_site_properties.update');
Route::post('/account/admin/manage_admin/revoke', [AccountController::class, 'revoke_admin'])->name('account.admin.manage_site_properties.revoke_admin');
Route::post('/account/admin/manage_admin/make', [AccountController::class, 'make_admin'])->name('account.admin.manage_site_properties.make_admin');

// Products
Route::get('/products', [ProductsController::class, 'all_products'])->name("products.all_products");
Route::get('/products/brands', [ProductsController::class, 'all_brands'])->name('brands.all_brands');
Route::get('/products/brands/{brand}', function($brand){
    return view('products.brands.view_brand',['stylesheet' => "products", 'brand' => $brand] );
});
Route::get('/products/category/{category}', [ProductsController::class, 'view_category']);

Route::post('/products/delete', [ProductsController::class, 'delete_product']);
Route::post('/products/edit', [ProductsController::class, 'edit_product']);
Route::post('/products/edit/removeThumbnail', [ProductsController::class, 'removeThumbnail']);

Route::get('/products/single/{product_id}', function($product_id){
    return view('products.product_view',['stylesheet' => "products", 'product_id' => $product_id] );
});
Route::post('/products/addToCart', [CartController::class, 'addToCart']);

// About Us
Route::get('/about_us', [AboutUsController::class, 'index'])->name('about.index');

// Return policy
Route::post('/exitReturnPolicy', [AboutUsController::class, 'exitReturnPolicy']);

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/removeProduct', [CartController::class, 'removeProduct'])->name('cart.removeProduct');
Route::post('/cart/emptyCart', [CartController::class, 'emptyCart'])->name('cart.emptyCart');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout/token', [BraintreeController::class, 'token'])->name('braintree.token');

// Ordering
Route::post('/ordering/create', [OrderController::class, 'create'])->name('order.create');
Route::get('/order/{order_id}', [OrderController::class, 'summary']);

Route::post('/ordering/edit/markAsShipped', [OrderController::class, 'markAsShipped'])->name('order.edit.markAsShipped');
Route::post('/ordering/edit/changeStatus', [OrderController::class, 'changeStatus'])->name('order.edit.changeStatus');
Route::post('/ordering/edit/refundOrder', [OrderController::class, 'refundOrder'])->name('order.edit.refundOrder');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Calculate
Route::post('/shipping/calculate', [CheckoutController::class, 'shipping'])->name('shipping.calculate');

// Contact form
Route::post('/contact/send', [ContactController::class, 'send'] )->name('contact.send');