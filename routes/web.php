<?php

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


use App\Model\SystemSetting;
use App\Model\Products;

View::composer(['layouts.header','layouts.sidebar'], function ($data) {
            $data['systemInformation'] = SystemSetting::where('sys_id',1)->first();
            $data['clothes'] = Products::where('pod_main_cat_id',10)->where('pod_status',0)->count('pod_main_cat_id');
            $data['watches'] = Products::where('pod_main_cat_id',7)->where('pod_status',0)->count('pod_main_cat_id');
            $data['shoes'] = Products::where('pod_main_cat_id',9)->where('pod_status',0)->count('pod_main_cat_id');
            $data['beltes'] = Products::where('pod_main_cat_id',8)->where('pod_status',0)->count('pod_main_cat_id');
            $data['walletes'] = Products::where('pod_main_cat_id',11)->where('pod_status',0)->count('pod_main_cat_id');
            $data['mobilesCovers'] = Products::where('pod_main_cat_id',12)->where('pod_status',0)->count('pod_main_cat_id');
            $data['gadget'] = Products::where('pod_main_cat_id',15)->where('pod_status',0)->count('pod_main_cat_id');
            $data['childrenToys'] = Products::where('pod_main_cat_id',13)->where('pod_status',0)->count('pod_main_cat_id');
            $data['girlBeauty'] = Products::where('pod_main_cat_id',14)->where('pod_status',0)->count('pod_main_cat_id');
        });
Route::post('user-login','Auth\LoginController@login');
Auth::routes();

Route::get('/', 'Admin\DashboardController@index');
Route::get('/home', 'Admin\DashboardController@index');
Route::get('/dashboard-today-order', 'Admin\OrderDashboardController@index');
Route::get('privacy-policy', 'Admin\AndroidPageController@privacyPolicy');

Route::get('/users', 'Admin\UsersController@index');

// ******************* BEGIN USERS MODULE ***********************

Route::get('/users', 'Admin\UsersController@index');  // Grid List
Route::get('/create-users', 'Admin\UsersController@create'); // Create Form
Route::get('/edit-users/{id}', 'Admin\UsersController@edit'); // Edit Form 
Route::post('/store-users', 'Admin\UsersController@store'); // To store record
Route::post('/update-users', 'Admin\UsersController@update'); // To update record
Route::get('/delete-users/{id}', 'Admin\UsersController@destroy'); // To delete reecord
Route::post('/status-users','Admin\UsersController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-users/{type}','Admin\UsersController@exportExcel'); // For Excel file
Route::get('/export-pdf-users','Admin\UsersController@exportPdf'); // For Pdf file
Route::get('/user-profile', 'Admin\UsersController@userProfile'); // Create Form
Route::post('/update-users-profile', 'Admin\UsersController@updateProfile'); // To update record
Route::post('update-password','Admin\UsersController@updatepassword');

// ******************* END USERS MODULE ***********************

// ******************* BEGIN SELLER MODULE ***********************

Route::get('/sellers', 'Admin\SellersController@index');  // Grid List
Route::get('/create-sellers', 'Admin\SellersController@create'); // Create Form
Route::get('/edit-sellers/{id}', 'Admin\SellersController@edit'); // Edit Form
Route::post('/store-sellers', 'Admin\SellersController@store'); // To store record
Route::post('/update-sellers', 'Admin\SellersController@update'); // To update record
Route::get('/delete-sellers/{id}', 'Admin\SellersController@destroy'); // To delete reecord
Route::post('/status-sellers','Admin\SellersController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-sellers/{type}','Admin\SellersController@exportExcel'); // For Excel file
Route::get('/export-pdf-sellers','Admin\SellersController@exportPdf'); // For Pdf file

// ******************* END SELLER MODULE ***********************

// ******************* BEGIN SELLER MODULE ***********************

Route::get('/delivery-boys', 'Admin\DeliveryBoysController@index');  // Grid List
Route::get('/create-delivery-boys', 'Admin\DeliveryBoysController@create'); // Create Form
Route::get('/edit-delivery-boys/{id}', 'Admin\DeliveryBoysController@edit'); // Edit Form
Route::post('/store-delivery-boys', 'Admin\DeliveryBoysController@store'); // To store record
Route::post('/update-delivery-boys', 'Admin\DeliveryBoysController@update'); // To update record
Route::get('/delete-delivery-boys/{id}', 'Admin\DeliveryBoysController@destroy'); // To delete reecord
Route::post('/status-delivery-boys','Admin\DeliveryBoysController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-delivery-boys/{type}','Admin\DeliveryBoysController@exportExcel'); // For Excel file
Route::get('/export-pdf-delivery-boys','Admin\DeliveryBoysController@exportPdf'); // For Pdf file

// ******************* END SELLER MODULE ***********************

// ******************* BEGIN SELLER BANK ACCOUNT MODULE ***********************

Route::get('/sellers-bank-accounts', 'Admin\SelBankAccountController@index');  // Grid List
Route::get('/create-sellers-bank-accounts', 'Admin\SelBankAccountController@create'); // Create Form
Route::get('/edit-sellers-bank-accounts/{id}', 'Admin\SelBankAccountController@edit'); // Edit Form
Route::post('/store-sellers-bank-accounts', 'Admin\SelBankAccountController@store'); // To store record
Route::post('/update-sellers-bank-accounts', 'Admin\SelBankAccountController@update'); // To update record
Route::get('/delete-sellers-bank-accounts/{id}', 'Admin\SelBankAccountController@destroy'); // To delete reecord
Route::post('/status-sellers-bank-accounts','Admin\SelBankAccountController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-sellers-bank-accounts/{type}','Admin\SelBankAccountController@exportExcel'); // For Excel file
Route::get('/export-pdf-sellers-bank-accounts','Admin\SelBankAccountController@exportPdf'); // For Pdf file

// ******************* END SELLER BANK ACCOUNT MODULE ***********************


// ******************* BEGIN PRODUCTS MODULE ***********************

Route::get('/products', 'Admin\ProductsController@index');  // Grid List
Route::get('/create-products', 'Admin\ProductsController@create'); // Create Form
Route::get('/edit-products/{id}', 'Admin\ProductsController@edit'); // Edit Form
Route::get('/view-products/{id}', 'Admin\ProductsController@view'); // Edit Form
Route::post('/store-products', 'Admin\ProductsController@store'); // To store record
Route::post('/update-products', 'Admin\ProductsController@update'); // To update recordseller/update-products
Route::get('/delete-products/{id}', 'Admin\ProductsController@destroy'); // To delete reecord
Route::post('/status-products','Admin\ProductsController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-products','Admin\ProductsController@getSubcategory');
Route::post('/category-list','Admin\ProductsController@getCategory');

Route::get('/export-products/{type}','Admin\ProductsController@exportExcel'); // For Excel file
Route::get('/export-pdf-products','Admin\ProductsController@exportPdf'); // For Pdf file

// ******************* END BRANDS MODULE ***********************

// ******************* BEGIN SELLER PRODUCTS MODULE ***********************

Route::get('/seller-products', 'Admin\SellerProductsController@index');  // Grid List
Route::get('/seller/view-products/{id}', 'Admin\SellerProductsController@view'); // Edit Form
Route::get('/seller/edit-products/{id}', 'Admin\SellerProductsController@edit'); // Edit Form
Route::post('/seller/update-products', 'Admin\SellerProductsController@update'); // To update record
Route::get('/seller/delete-products/{id}', 'Admin\SellerProductsController@destroy'); // To delete reecord
// ******************* END SELLER PRODUCTS MODULE ***********************

// ******************* BEGIN MAIN CATEGORY MODULE ***********************

Route::get('/main-category', 'Admin\MainCategoryController@index');  // Grid List
Route::get('/create-main-category', 'Admin\MainCategoryController@create'); // Create Form
Route::get('/edit-main-category/{id}', 'Admin\MainCategoryController@edit'); // Edit Form
Route::post('/store-main-category', 'Admin\MainCategoryController@store'); // To store record
Route::post('/update-main-category', 'Admin\MainCategoryController@update'); // To update record
Route::get('/delete-main-category/{id}', 'Admin\MainCategoryController@destroy'); // To delete reecord
Route::post('/status-main-category','Admin\MainCategoryController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-main-category/{type}','Admin\MainCategoryController@exportExcel'); // For Excel file
Route::get('/export-pdf-main-category','Admin\MainCategoryController@exportPdf'); // For Pdf file

// ******************* END MAIN CATEGORY MODULE ***********************

// ******************* BEGIN CATEGORY MODULE ***********************

Route::get('/category', 'Admin\CategoryController@index');  // Grid List
Route::get('/create-category', 'Admin\CategoryController@create'); // Create Form
Route::get('/edit-category/{id}', 'Admin\CategoryController@edit'); // Edit Form
Route::post('/store-category', 'Admin\CategoryController@store'); // To store record
Route::post('/update-category', 'Admin\CategoryController@update'); // To update record
Route::get('/delete-category/{id}', 'Admin\CategoryController@destroy'); // To delete reecord
Route::post('/status-category','Admin\CategoryController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-category/{type}','Admin\CategoryController@exportExcel'); // For Excel file
Route::get('/export-pdf-category','Admin\CategoryController@exportPdf'); // For Pdf file

// ******************* END CATEGORY MODULE ***********************

// ******************* BEGIN COLOR MODULE ***********************

Route::get('/color', 'Admin\ColorController@index');  // Grid List
Route::get('/create-color', 'Admin\ColorController@create'); // Create Form
Route::get('/edit-color/{id}', 'Admin\ColorController@edit'); // Edit Form
Route::post('/store-color', 'Admin\ColorController@store'); // To store record
Route::post('/update-color', 'Admin\ColorController@update'); // To update record
Route::get('/delete-color/{id}', 'Admin\ColorController@destroy'); // To delete reecord
Route::post('/status-color','Admin\ColorController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-color/{type}','Admin\ColorController@exportExcel'); // For Excel file
Route::get('/export-pdf-color','Admin\ColorController@exportPdf'); // For Pdf file

// ******************* END COLOR MODULE ***********************



// ******************* BEGIN SUB CATEGORY MODULE ***********************

Route::get('/sub-category', 'Admin\SubCategoryController@index');  // Grid List
Route::get('/create-sub-category', 'Admin\SubCategoryController@create'); // Create Form
Route::get('/edit-sub-category/{id}', 'Admin\SubCategoryController@edit'); // Edit Form
Route::post('/store-sub-category', 'Admin\SubCategoryController@store'); // To store record
Route::post('/update-sub-category', 'Admin\SubCategoryController@update'); // To update record
Route::get('/delete-sub-category/{id}', 'Admin\SubCategoryController@destroy'); // To delete reecord
Route::post('/status-sub-category','Admin\SubCategoryController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-sub-category/{type}','Admin\SubCategoryController@exportExcel'); // For Excel file
Route::get('/export-pdf-sub-category','Admin\SubCategoryController@exportPdf'); // For Pdf file

// ******************* END SUB CATEGORY MODULE ***********************

// ******************* BEGIN ORDER TRACKING MODULE ***********************

Route::get('/order-tracking', 'Admin\OrderTrackingController@index');  // Grid List
Route::get('/create-order-tracking', 'Admin\OrderTrackingController@create'); // Create Form
Route::get('/edit-order-tracking/{id}', 'Admin\OrderTrackingController@edit'); // Edit Form
Route::post('/store-order-tracking', 'Admin\OrderTrackingController@store'); // To store record
Route::post('/update-order-tracking', 'Admin\OrderTrackingController@update'); // To update record
Route::get('/delete-order-tracking/{id}', 'Admin\OrderTrackingController@destroy'); // To delete reecord
Route::post('/status-order-tracking','Admin\OrderTrackingController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-order-tracking/{type}','Admin\OrderTrackingController@exportExcel'); // For Excel file
Route::get('/export-pdf-order-tracking','Admin\OrderTrackingController@exportPdf'); // For Pdf file

// ******************* END ORDER TRACKING MODULE ***********************

// ******************* BEGIN PRODUCT DELIVERY MODULE ***********************

Route::get('/product-delivery', 'Admin\ProductDeliveryController@index');  // Grid List
Route::get('/create-product-delivery', 'Admin\ProductDeliveryController@create'); // Create Form
Route::get('/edit-product-delivery/{id}', 'Admin\ProductDeliveryController@edit'); // Edit Form
Route::post('/store-product-delivery', 'Admin\ProductDeliveryController@store'); // To store record
Route::post('/update-product-delivery', 'Admin\ProductDeliveryController@update'); // To update record
Route::get('/delete-product-delivery/{id}', 'Admin\ProductDeliveryController@destroy'); // To delete reecord
Route::post('/status-product-delivery','Admin\ProductDeliveryController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-product-delivery/{type}','Admin\ProductDeliveryController@exportExcel'); // For Excel file
Route::get('/export-pdf-product-delivery','Admin\ProductDeliveryController@exportPdf'); // For Pdf file

// ******************* END PRODUCT DELIVERY MODULE ***********************

// ******************* BEGIN VILLAGES MODULE ***********************

Route::get('/villages', 'Admin\VillagesController@index');  // Grid List
Route::get('/create-villages', 'Admin\VillagesController@create'); // Create Form
Route::get('/edit-villages/{id}', 'Admin\VillagesController@edit'); // Edit Form
Route::post('/store-villages', 'Admin\VillagesController@store'); // To store record
Route::post('/update-villages', 'Admin\VillagesController@update'); // To update record
Route::get('/delete-villages/{id}', 'Admin\VillagesController@destroy'); // To delete reecord
Route::post('/status-villages','Admin\VillagesController@changeStatus'); // status 0 = Active 1 = Inctive

Route::get('/export-villages/{type}','Admin\VillagesController@exportExcel'); // For Excel file
Route::get('/export-pdf-villages','Admin\VillagesController@exportPdf'); // For Pdf file clothes

// ******************* END VILLAGES MODULE ***********************

// ******************* BEGIN BANNERS MODULE ***********************

Route::get('/banners', 'Admin\BannersController@index');  // Grid List
Route::get('/create-banners', 'Admin\BannersController@create'); // Create Form
Route::get('/edit-banners/{id}', 'Admin\BannersController@edit'); // Edit Form
Route::post('/store-banners', 'Admin\BannersController@store'); // To store record
Route::post('/update-banners', 'Admin\BannersController@update'); // To update record
Route::get('/delete-banners/{id}', 'Admin\BannersController@destroy'); // To delete reecord
Route::post('/status-banners','Admin\BannersController@changeStatus'); // status 0 = Active 1 = Inctive

// ******************* END VILLAGES MODULE ***********************

// ******************* BEGIN CLOTHES MODULE ***********************

Route::get('/clothes', 'Admin\ClothesController@index');  // Grid List
Route::get('/create-clothes', 'Admin\ClothesController@create'); // Create Form
Route::get('/edit-clothes/{id}', 'Admin\ClothesController@edit'); // Edit Form
Route::get('/view-clothes/{id}', 'Admin\ClothesController@view'); // Edit Form
Route::post('/store-clothes', 'Admin\ClothesController@store'); // To store record
Route::post('/update-clothes', 'Admin\ClothesController@update'); // To update record
Route::get('/delete-clothes/{id}', 'Admin\ClothesController@destroy'); // To delete reecord
Route::post('/status-clothes','Admin\ClothesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-clothes','Admin\ClothesController@getSubcategory');

Route::get('/export-clothes/{type}','Admin\ClothesController@exportExcel'); // For Excel file
Route::get('/export-pdf-clothes','Admin\ClothesController@exportPdf'); // For Pdf file clothes

// ******************* END CLOTHES MODULE ***********************

// -----------
// ******************* BEGIN BELT MODULE ***********************

Route::get('/beltes', 'Admin\BeltesController@index');  // Grid List
Route::get('/create-beltes', 'Admin\BeltesController@create'); // Create Form
Route::get('/edit-beltes/{id}', 'Admin\BeltesController@edit'); // Edit Form
Route::get('/view-beltes/{id}', 'Admin\BeltesController@view'); // Edit Form
Route::post('/store-beltes', 'Admin\BeltesController@store'); // To store record
Route::post('/update-beltes', 'Admin\BeltesController@update'); // To update record
Route::get('/delete-beltes/{id}', 'Admin\BeltesController@destroy'); // To delete reecord
Route::post('/status-beltes','Admin\BeltesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-beltes','Admin\BeltesController@getSubcategory');

Route::get('/export-beltes/{type}','Admin\BeltesController@exportExcel'); // For Excel file
Route::get('/export-pdf-beltes','Admin\BeltesController@exportPdf'); // For Pdf file clothes

 // For Pdf file clothes

// ******************* END CATEGORY BELTS MODULE ***********************

// ******************* END BELT MODULE ***********************

// ******************* BEGIN MOBLIE MODULE ***********************

Route::get('/mobiles', 'Admin\MobilesController@index');  // Grid List
Route::get('/create-mobiles', 'Admin\MobilesController@create'); // Create Form
Route::get('/edit-mobiles/{id}', 'Admin\MobilesController@edit'); // Edit Form
Route::get('/view-mobiles/{id}', 'Admin\MobilesController@view'); // View Page
Route::post('/store-mobiles', 'Admin\MobilesController@store'); // To store record
Route::post('/update-mobiles', 'Admin\MobilesController@update'); // To update record
Route::get('/delete-mobiles/{id}', 'Admin\MobilesController@destroy'); // To delete reecord
Route::post('/status-mobiles','Admin\MobilesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-mobiles','Admin\MobilesController@getSubcategory');

Route::get('/export-mobiles/{type}','Admin\MobilesController@exportExcel'); // For Excel file
Route::get('/export-pdf-mobiles','Admin\MobilesController@exportPdf'); // For Pdf file mobile

// ******************* END MOBLIE MODULE ***********************

// ******************* BEGIN WATCHES MODULE ***********************

Route::get('/watches', 'Admin\WatchesController@index');  // Grid List
Route::get('/view-watches/{id}', 'Admin\WatchesController@view'); // View Page
Route::get('/create-watches', 'Admin\WatchesController@create'); // Create Form
Route::get('/edit-watches/{id}', 'Admin\WatchesController@edit'); // Edit Form
Route::post('/store-watches', 'Admin\WatchesController@store'); // To store record
Route::post('/update-watches', 'Admin\WatchesController@update'); // To update record
Route::get('/delete-watches/{id}', 'Admin\WatchesController@destroy'); // To delete reecord
Route::post('/status-watches','Admin\WatchesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-watches','Admin\WatchesController@getSubcategory');

Route::get('/export-watches/{type}','Admin\WatchesController@exportExcel'); // For Excel file
Route::get('/export-pdf-watches','Admin\WatchesController@exportPdf'); // For Pdf file clothes

// ******************* END WATCHES MODULE ***********************

// ******************* BEGIN SHOES MODULE ***********************

Route::get('/shoes', 'Admin\ShoesController@index');  // Grid List
Route::get('/view-shoes/{id}', 'Admin\ShoesController@view'); // View Page
Route::get('/create-shoes', 'Admin\ShoesController@create'); // Create Form
Route::get('/edit-shoes/{id}', 'Admin\ShoesController@edit'); // Edit Form
Route::post('/store-shoes', 'Admin\ShoesController@store'); // To store record
Route::post('/update-shoes', 'Admin\ShoesController@update'); // To update record
Route::get('/delete-shoes/{id}', 'Admin\ShoesController@destroy'); // To delete reecord
Route::post('/status-shoes','Admin\ShoesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-shoes','Admin\ShoesController@getSubcategory');

Route::get('/export-shoes/{type}','Admin\ShoesController@exportExcel'); // For Excel file
Route::get('/export-pdf-shoes','Admin\ShoesController@exportPdf'); // For Pdf file clothes

// ******************* END SHOES MODULE ***********************

// ******************* BEGIN SHOES MODULE ***********************

Route::get('/walletes', 'Admin\WalletesController@index');  // Grid List
Route::get('/view-walletes/{id}', 'Admin\WalletesController@view'); // Edit Form
Route::get('/create-walletes', 'Admin\WalletesController@create'); // Create Form
Route::get('/edit-walletes/{id}', 'Admin\WalletesController@edit'); // Edit Form
Route::post('/store-walletes', 'Admin\WalletesController@store'); // To store record
Route::post('/update-walletes', 'Admin\WalletesController@update'); // To update record
Route::get('/delete-walletes/{id}', 'Admin\WalletesController@destroy'); // To delete reecord
Route::post('/status-walletes','Admin\WalletesController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-walletes','Admin\WalletesController@getSubcategory');

Route::get('/export-walletes/{type}','Admin\WalletesController@exportExcel'); // For Excel file
Route::get('/export-pdf-walletes','Admin\WalletesController@exportPdf'); // For Pdf file clothes


// ******************* BEGIN MOBILE COVERS MODULE ***********************

Route::get('/mobiles-covers', 'Admin\MobilesCoversController@index');  // Grid List
Route::get('/create-mobiles-covers', 'Admin\MobilesCoversController@create'); // Create Form
Route::get('/edit-mobiles-covers/{id}', 'Admin\MobilesCoversController@edit'); // Edit Form
Route::get('/view-mobiles-covers/{id}', 'Admin\MobilesCoversController@view'); // Edit Form
Route::post('/store-mobiles-covers', 'Admin\MobilesCoversController@store'); // To store record
Route::post('/update-mobiles-covers', 'Admin\MobilesCoversController@update'); // To update record
Route::get('/delete-mobiles-covers/{id}', 'Admin\MobilesCoversController@destroy'); // To delete reecord
Route::post('/status-mobiles-covers','Admin\MobilesCoversController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-mobiles-covers','Admin\MobilesCoversController@getSubcategory');

Route::get('/export-mobiles-covers/{type}','Admin\MobilesCoversController@exportExcel'); // For Excel file
Route::get('/export-pdf-mobiles-covers','Admin\MobilesCoversController@exportPdf'); // For Pdf file clothes

// ******************* END MOBILE COVERS MODULE ***********************

// ******************* BEGIN GADGET COVERS MODULE ***********************

Route::get('/gadget', 'Admin\GadgetController@index');  // Grid List
Route::get('/create-gadget', 'Admin\GadgetController@create'); // Create Form
Route::get('/edit-gadget/{id}', 'Admin\GadgetController@edit'); // Edit Form
Route::get('/view-gadget/{id}', 'Admin\GadgetController@view'); // Edit Form
Route::post('/store-gadget', 'Admin\GadgetController@store'); // To store record
Route::post('/update-gadget', 'Admin\GadgetController@update'); // To update record
Route::get('/delete-gadget/{id}', 'Admin\GadgetController@destroy'); // To delete reecord
Route::post('/status-gadget','Admin\GadgetController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-gadget','Admin\GadgetController@getSubcategory');

Route::get('/export-gadget/{type}','Admin\GadgetController@exportExcel'); // For Excel file
Route::get('/export-pdf-gadget','Admin\GadgetController@exportPdf'); // For Pdf file clothes

// ******************* END GADGET COVERS MODULE ***********************

// ******************* BEGIN CHILDREN TOYS MODULE ***********************

Route::get('/children-toys', 'Admin\ChildrenToysController@index');  // Grid List
Route::get('/create-children-toys', 'Admin\ChildrenToysController@create'); // Create Form
Route::get('/edit-children-toys/{id}', 'Admin\ChildrenToysController@edit'); // Edit Form
Route::get('/view-children-toys/{id}', 'Admin\ChildrenToysController@view'); // Edit Form
Route::post('/store-children-toys', 'Admin\ChildrenToysController@store'); // To store record
Route::post('/update-children-toys', 'Admin\ChildrenToysController@update'); // To update record
Route::get('/delete-children-toys/{id}', 'Admin\ChildrenToysController@destroy'); // To delete reecord
Route::post('/status-children-toys','Admin\ChildrenToysController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-children-toys','Admin\ChildrenToysController@getSubcategory');

Route::get('/export-children-toys/{type}','Admin\ChildrenToysController@exportExcel'); // For Excel file
Route::get('/export-pdf-children-toys','Admin\ChildrenToysController@exportPdf'); // For Pdf file clothes

// ******************* END CHILDREN TOYS MODULE ***********************

// ******************* BEGIN GIRL BEAUTY MODULE ***********************

Route::get('/girl-beauty', 'Admin\GirlBeautyController@index');  // Grid List
Route::get('/create-girl-beauty', 'Admin\GirlBeautyController@create'); // Create Form
Route::get('/edit-girl-beauty/{id}', 'Admin\GirlBeautyController@edit'); // Edit Form
Route::get('/view-girl-beauty/{id}', 'Admin\GirlBeautyController@view'); // Edit Form
Route::post('/store-girl-beauty', 'Admin\GirlBeautyController@store'); // To store record
Route::post('/update-girl-beauty', 'Admin\GirlBeautyController@update'); // To update record
Route::get('/delete-girl-beauty/{id}', 'Admin\GirlBeautyController@destroy'); // To delete reecord
Route::post('/status-girl-beauty','Admin\GirlBeautyController@changeStatus'); // status 0 = Active 1 = Inctive
Route::post('/sub-category-girl-beauty','Admin\GirlBeautyController@getSubcategory');

Route::get('/export-girl-beauty/{type}','Admin\GirlBeautyController@exportExcel'); // For Excel file
Route::get('/export-pdf-girl-beauty','Admin\GirlBeautyController@exportPdf'); // For Pdf file clothes

// ******************* END GIRL BEAUTY MODULE ***********************

Route::get('/orders-list/{id}', 'Admin\ProductOrderController@index');  // Grid List
Route::get('/customer-invoice/{id}', 'Admin\ProductOrderController@customerInvoice');  // Grid List
Route::get('/assign-seller-order/{id}', 'Admin\ProductOrderController@assignSellerOrder');  // Grid List
Route::post('/update-assign-order', 'Admin\ProductOrderController@updateAssignOrder');  // Grid List

// -------------- BEGIN FEEDBACK MODULE -------------------
Route::get('/feedback', 'Admin\FeedbackController@index');  // Grid List
Route::get('/delete-feedback/{id}', 'Admin\FeedbackController@destroy'); // To delete reecord