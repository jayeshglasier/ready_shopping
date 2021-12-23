<?php

use Illuminate\Http\Request;

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

Route::post('login','RestApi\AuthController@signIn');
Route::post('customer-signup','RestApi\AuthController@customerSignUp');
Route::post('customer-register','RestApi\AuthController@register');
Route::post('verfiy-otp-code','RestApi\AuthController@verfiyOtpcode');
Route::post('seller-update-profile','RestApi\AuthController@sellersUpdateProfile');
Route::post('users-detail', 'RestApi\UserController@index');
Route::post('edit-profile', 'RestApi\UserController@editProfile');
Route::post('update-profile-image', 'RestApi\UserController@uploadProfile');
Route::post('user-is-active','RestApi\UserController@activeUser');


// --------------- HOME PAGE MODULE START HERE -----------------------
Route::get('home/banners-list', 'RestApi\HomeController@bannersList');

Route::get('home/smart-phone-list', 'RestApi\HomeController@smartPhonelist');
Route::post('home/today-offer-list', 'RestApi\HomeController@todayofferList');
Route::post('home/electronic-items-list', 'RestApi\HomeController@electronicItemsList');
Route::post('home/grocery-items-list', 'RestApi\HomeController@groceryItemsList');
Route::post('home/personal-care-list', 'RestApi\HomeController@personalCareList');
Route::post('home/second-hand-items-list', 'RestApi\HomeController@secondHandItemsList');
Route::get('home/animal-food-and-biyaran-category', 'RestApi\HomeController@animalFoodList');

// --------------- HOME PAGE MODULE END HERE -----------------------

// Customer App Module
Route::post('category-list','RestApi\ProductModuleController@categoryList'); // Category List
Route::post('sub-category-list','RestApi\ProductModuleController@subCategoryList'); // Sub Category List
Route::post('category-wise-product-list','RestApi\ProductModuleController@CategoryProductList');
Route::post('sub-category-wise-product-list','RestApi\ProductModuleController@subCategoryProductList');

// Village name list api module
Route::get('villages','RestApi\VillagesController@index');
Route::get('brands-list','RestApi\VillagesController@brandList');

// Carzone module
Route::get('cars-list','RestApi\CarsController@index');
Route::post('cars-detail','RestApi\CarsController@carDetail');

// Product Detail
Route::post('product-detail','RestApi\ProductsController@productDetail'); // product id wise product detail api
Route::post('seller/product-detail','RestApi\ProductsController@sellerProductDetail'); // product id wise product detail api

// SELLER OR ADMIN API LIST 

Route::get('seller/main-category-list','RestApi\CategorysController@mainCategoryList');
Route::post('seller/category-list','RestApi\CategorysController@categoryList');
Route::post('seller/sub-category-list','RestApi\CategorysController@subCategoryList');
Route::post('add-product','RestApi\ProductsController@addProduct');
Route::post('update-product','RestApi\ProductsController@updateProduct');
Route::post('edit-product','RestApi\ProductsController@addProduct');
Route::post('delete-product','RestApi\ProductsController@deleteProduct');
Route::post('seller/product-list','RestApi\ProductsController@sellerProductList'); // product id wise product detail api
Route::post('search-product-list','RestApi\ProductsController@searchProductList'); // product id wise product detail api
Route::post('seller/category-product-list','RestApi\ProductsController@categoryProductList'); // product id wise product detail api
Route::post('seller-id-wise-product-list','RestApi\ProductsController@productSellerIdwiseList'); // product id wise product detail api

// Cart and Wish product list
Route::post('cart-product-list','RestApi\ProductsController@productCartList');
Route::post('add-cart-product','RestApi\ProductsController@addCartProduct');
Route::post('delete-cart-product','RestApi\ProductsController@deleteCartProduct');

Route::post('wish-product-list','RestApi\ProductsController@productWishList');
Route::post('add-wish-product','RestApi\ProductsController@addWishProduct');
Route::post('delete-wish-product','RestApi\ProductsController@deleteWishProduct');

Route::post('add-feedback','RestApi\ProductsController@addFeedback');
/// ------- Shipping Address
Route::post('shipping-address-list','RestApi\ProductsController@shippingAddressList');
Route::post('add-shipping-address','RestApi\ProductsController@addShippingAddress');
Route::post('delete-shipping-address','RestApi\ProductsController@deleteShippingAddress');

Route::post('seller-signup','RestApi\AuthController@sellersignUp');
Route::post('add-seller-bank-detail','RestApi\AuthController@addBankdetail');
Route::post('seller/bank-detail-status','RestApi\AuthController@bankDetailStatus');
Route::post('seller-profile-detail','RestApi\AuthController@profileDetail');

// Users list api module
Route::get('users-list','RestApi\UserController@userList');
Route::post('delivery-boys-list','RestApi\UserController@deliveryBoyList');

// Customer Order module
Route::post('customer/add-order','RestApi\ProductOrderController@addOrder');
Route::post('customer/list-of-orders','RestApi\ProductOrderController@ordersList');
Route::post('customer/order-history','RestApi\ProductOrderController@orderHistory'); 
Route::post('customer/order-confirmation','RestApi\ProductOrderController@orderConfirmation');

// Payment
Route::post('customer/product-payment','RestApi\PaymentsController@productsPayment');

// ----------------------- START SHOP MODULE ----------------------
// Shoes Module
Route::get('shoes-list','RestApi\ShopModuleController@shoeslist');
Route::get('watches-list','RestApi\ShopModuleController@watchesList');
Route::get('walletes-list','RestApi\ShopModuleController@walletesList');
Route::get('clothes-list','RestApi\ShopModuleController@clothesList');
Route::get('beltes-list','RestApi\ShopModuleController@belteslist');

Route::get('mobiles-covers-list','RestApi\ShopModuleController@mobilesCoversList');
Route::get('gadget-list','RestApi\ShopModuleController@gadgetList');
Route::get('children-toys-list','RestApi\ShopModuleController@childrentoysList');
Route::get('girl-beauty-list','RestApi\ShopModuleController@girlbeautyList');

// ----------------------- END SHOP MODULE ----------------------

// Seller order list
Route::post('seller/order-list','RestApi\SellerOrderController@index');
Route::post('seller/order-status-change','RestApi\SellerOrderController@orderStatuschange');

