<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\MainCategorys;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\Products;
use App\Model\WishProduct;
use App\User;
use Mail;
use DB;

class ProductModuleController extends Controller
{

    public function categoryProductList(Request $request)
    {
        try
        {
            $categoryId = $request->category_id;
            if($categoryId)
            {
                if(Products::where('pod_cat_id',$categoryId)->where('pod_status',0)->exists())
                {
                    $categoryRecord = Category::where('cat_id',$categoryId)->first();

                    $productsRecord = Products::join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_cat_id',$categoryId)->where('pod_status',0)->get();
                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        $productUrl = array();
                        foreach ($productsRecord as $key => $value)
                        { 
                           $producturl = url("public/assets/img/products/".$value->pod_picture);
                            $productDetails[] = array(
                                "product_id" => ''.$value->pod_id.'',
                                "name" => $value->pod_pro_name,
                                "brand" => ''.$value->pod_brand_name.'',
                                "category" => ''.$value->pro_category_name.'',
                                "sub_category" => ''.$value->psc_cat_name.'',
                                "price" => ''.$value->pod_price.'',
                                "offer_price" => ''.$value->pod_offer_price.'',
                                "quantity" => ''.$value->pod_quantity.'',
                                "description" => ''.$value->pod_pro_description.'',
                                "picture_url" => $producturl
                            );
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $picture = $productUrl;

                        $message = $categoryRecord->pro_category_name." category product list";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = "Category isn't available.";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Category id isn't valid!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
                
            }else{
                $msg = "Category id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function subCategoryProductList(Request $request)
    {
        try
        {
            $categoryId = $request->sub_category_id;
            $userToken = $request->token;
            if($categoryId)
            {
                // if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                // {
                    if(Products::where('pod_sub_cat_id',$categoryId)->where('pod_status',0)->exists())
                    {
                        $productsRecord = Products::where('pod_sub_cat_id',$categoryId)->where('pod_status',0)->get();

                        $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                        if(!$productsRecord->isEmpty())
                        { 
                            $productDetails = array();
                            $productUrl = array();
                            foreach ($productsRecord as $key => $value)
                            { 
                                if($userId)
                                {
                                    if(WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$value->pod_id)->exists())
                                    {
                                        $wishProduct = WishProduct::where('wis_user_id',$userId->id)->where('wis_product_id',$value->pod_id)->first();
                                        if($wishProduct){
                                            $wishlistId = $wishProduct->wis_id;
                                        }else{
                                            $wishlistId = '';
                                        }
                                        $wishlist = 1;
                                    }else{
                                        $wishlist = 0;
                                        $wishlistId = '';
                                    }
                                }else{
                                    $wishlist = 0;
                                    $wishlistId = '';
                                }

                                $producturl = url("public/assets/img/products/".$value->pod_picture);
                                $productDetails[] = array(
                                    "product_id" => ''.$value->pod_id.'',
                                    "product_name" => $value->pod_pro_name,
                                    "brand_name" => ''.$value->pod_brand_name.'',
                                    "price" => ''.$value->pod_price.'',
                                    "offer_price" => ''.$value->pod_offer_price.'',
                                    "quantity" => ''.$value->pod_quantity.'',
                                    "description" => ''.$value->pod_pro_description.'',
                                    "wishlist" => ''.$wishlist.'',
                                    "wish_id" => ''.$wishlistId.'',
                                    "picture_url" => $producturl
                                );
                            }

                            array_walk_recursive($productDetails, function (&$item, $key) {
                            $item = null === $item ? '' : $item;
                            });
                            $this->data[$key] = $productDetails;

                            $picture = $productUrl;

                            $message = "Product detail sub category id wise";
                            return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                        }else{
                          $msg = "Product detail isn't available.";
                          return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                        }
                    }else{
                        $msg = "No Products Available!";
                        return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }
                // }else{
                //     ResponseMessage::error("User isn't exists!");
                // }
                
            }else{
                $msg = "Sub category id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function categoryList(Request $request)
    {
        try
        {
            $categoryId = $request->main_category_id;
            if($categoryId)
            {
                if(MainCategorys::where('mac_id',$categoryId)->exists())
                {
                    $mainRecord = MainCategorys::where('mac_id',$categoryId)->first();

                    $categoryRecord = Category::where('cat_main_id',$categoryId)->where('cat_status',0)->get();
                   
                    if(!$categoryRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($categoryRecord as $key => $value)
                        { 
                           $producturl = url("public/assets/img/category/".$value->cat_picture);
                            $productDetails[] = array(
                                "category_id" => ''.$value->cat_id.'',
                                "category_name" => $value->cat_name,
                                "picture_url" => $producturl
                            );
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $message = $mainRecord->mac_title." category list";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'main_cat_name' => $mainRecord->mac_title, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = $mainRecord->mac_title." Category isn't available.";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg, 'main_cat_name' => $mainRecord->mac_title, 'data' => array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Main Category id isn't valid!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
                
            }else{
                $msg = "Main Category id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function subCategoryList(Request $request)
    {
        try
        {
            $categoryId = $request->category_id;
            if($categoryId)
            {
                if(Category::where('cat_id',$categoryId)->exists())
                {
                    $categoryDetails = Category::where('cat_id',$categoryId)->first();

                    $categoryRecord = SubCategory::where('sub_cat_id',$categoryId)->where('sub_status',0)->get();

                    if(!$categoryRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($categoryRecord as $key => $value)
                        { 
                           $producturl = url("public/assets/img/sub-category/".$value->sub_picture);
                            $productDetails[] = array(
                                "sub_category_id" => ''.$value->sub_id.'',
                                "category_name" => $value->sub_cat_name,
                                "picture_url" => $producturl
                            );
                        }

                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $message = $categoryDetails->cat_name." sub category list";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category_name' => $categoryDetails->cat_name, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $msg = "Category isn't available.";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $msg, 'category_name' => $categoryDetails->cat_name,'data' => array()],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Category id isn't valid!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
                
            }else{
                $msg = "Category id is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }
   
}
