<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderedProductController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ShipmentController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json("What the fuck");
});
//Product
Route::get('product', 'ProductController@getProducts');
Route::get('product/{id}', 'ProductController@getProductById');
Route::post('product', 'ProductController@postProduct');
Route::put('product/{id}', 'ProductController@updateProduct');
Route::delete('product/{id}', 'ProductController@deleteProduct');
//Product

//UI Component
Route::get('component', 'ComponentController@getComponents');
Route::get('component/{id}', 'ComponentController@getComponentById');
Route::post('component', 'ComponentController@postComponent');
Route::put('component/{id}', 'ComponentController@updateComponent');
Route::delete('component/{id}', 'ComponentController@deleteComponent');
//UI Component

//User
Route::get('user', 'UserController@getUsers');
Route::get('user/{id}', 'UserController@getUserById');
Route::post('user/cookies', 'UserController@getUserByCookies');
Route::post('user', 'UserController@postUser');
Route::put('user/{id}', 'UserController@updateUser');
Route::delete('user/{id}', 'UserController@deleteUser');
Route::post('user/signin', 'UserController@signIn');
Route::post('user/changepassword/{id}', 'UserController@changePassword');

Route::post('user/forget/password', 'UserController@forgetPassword');
Route::post('user/reset/password/{token}', 'UserController@resetPassword')->name('token');
//User

//Customer
Route::get('customer', 'CustomerController@getCustomers');
Route::get('customer/{id}', 'CustomerController@getCustomerById');
Route::put('customer/{id}', 'CustomerController@updateCustomer');
Route::post('customer/signup', 'CustomerController@signUp');
Route::post('customer/signin', 'CustomerController@signIn');
Route::post('customer/changepassword/{id}', 'CustomerController@changePassword');

Route::post('customer/forget/password', 'CustomerController@forgetPassword');
Route::post('customer/reset/password/{token}', 'CustomerController@resetPassword')->name('token');
Route::post('customer/contactus', 'CustomerController@contactUs');
//Customer

//Order
Route::get('order', 'OrderController@getOrder');
Route::get('order/{id}', 'OrderController@getOrderById');
Route::post('order/customer', 'OrderController@getOrderByEmail');
Route::post('order/customer/{id}', 'OrderController@getOrderDetailByEmail');
Route::post('order', 'OrderController@postOrder');
Route::put('order/{id}', 'OrderController@updateOrder');
Route::put('order/notification/{id}', 'OrderController@updateOrderNotification');
Route::post('order/confirmOrder','OrderController@postConfirmOrder');
//Order

//Shipping Address
Route::get('shipping_address/{id}', 'ShippingAddressController@getShippingAddressById');
Route::post('shipping_address', 'ShippingAddressController@postShippingAddress');
//Shipping Address

//Billing Address
Route::get('billing_address/{id}', 'BillingAddressController@getBillingAddressById');
Route::post('billing_address', 'BillingAddressController@postBillingAddress');
//Billing Address

//Ordered Product
Route::get('ordered_product', 'OrderedProductController@getOrderedProducts');
Route::get('ordered_product/{id}', 'OrderedProductController@getOrderedProductById');
Route::post('ordered_product', 'OrderedProductController@postOrderedProduct');
//Ordered Product

//Brand
Route::get('brand', 'BrandController@getBrands');
Route::get('brand/{id}', 'BrandController@getBrandById');
Route::post('brand', 'BrandController@postBrand');
Route::put('brand/{id}', 'BrandController@updateBrand');
Route::delete('brand/{id}', 'BrandController@deleteBrand');
//Brand

//Shipment
Route::get('shipment', 'ShipmentController@getShipment');
Route::get('shipment/{id}', 'ShipmentController@getShipmentById');
Route::post('shipment', 'ShipmentController@postShipment');
Route::put('shipment/{id}', 'ShipmentController@updateShipment');
Route::delete('shipment/{id}', 'ShipmentController@deleteShipment');
//Shipment

//Dashboard
Route::get('dashboard/yearly', 'DashboardController@getYearly');
Route::post('dashboard/yearly', 'DashboardController@postYearly');
Route::put('dashboard/yearly/{id}', 'DashboardController@updateYearly');
//Dashboard