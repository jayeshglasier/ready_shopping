<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopProductsCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\Products;
use App\Model\ProductCategory;
use App\Model\ProductSubCategory;
use App\Model\MainCategorys;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\Banners;
use App\User;
use Validator;
use Mail;
use DB;

class HomeController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function smartPhonelist(Request $request) 
    {
        try
        {
            $categoryRecord = MainCategorys::where('mac_id',1)->where('mac_status',0)->first();

            $subCategoryRecord = Category::where('cat_main_id',$categoryRecord->mac_id)->where('cat_status',0)->limit(10)->get();

            if(!$subCategoryRecord->isEmpty())
            { 
                $subCategory = array();
                foreach ($subCategoryRecord as $key => $value)
                { 
                    $categoryurl = url("public/assets/img/category/".$value->cat_picture);
                    $subCategory[] = array("id" => ''.$value->cat_id.'',"name" => $value->cat_name,"picture_url" => $categoryurl);
                }

                array_walk_recursive($subCategory, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $subCategory;

                $message = $categoryRecord->mac_title." list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => $categoryRecord->mac_title,'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = $categoryRecord->mac_title." isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function todayofferList(Request $request) 
    {
        try
        {

            $userDetails = User::select('use_village_id')->where('use_token',$request->token)->first();

            if($userDetails)
            {
                $villageId = $userDetails->use_village_id;
            }else{
                 $villageId = 0;
            }

            $productRecord = Products::where('pod_deal_of_day',1)->where('pod_status',0)->whereIn('pod_village_id',[0,$villageId])->limit(10)->get();

            if(!$productRecord->isEmpty())
            { 
                $subCategory = array();
                foreach ($productRecord as $key => $value)
                { 
                    $producturl = url("public/assets/img/products/".$value->pod_picture);
                    $subCategory[] = array(
                        "product_id" => ''.$value->pod_id.'',
                        "product_name" => $value->pod_pro_name,
                        "brand_name" => $value->pod_brand_name,
                        "price" => $value->pod_price,
                        "offer_price" => $value->pod_offer_price,
                        "picture_url" => $producturl);
                }

                array_walk_recursive($subCategory, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $subCategory;

                $message = "Today Offer List";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => "Today Offer List",'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Today Offer List";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function electronicItemsList(Request $request) 
    {
        try
        {
            $userDetails = User::select('use_village_id')->where('use_token',$request->token)->first();

            if($userDetails)
            {
                $villageId = $userDetails->use_village_id;
            }else{
                 $villageId = 0;
            }

            $mainCategoryId = MainCategorys::where('mac_id',2)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->whereIn('pod_village_id',[0,$villageId])->limit('pod_id','DESC')->limit(10)->get();

            if(!$productRecord->isEmpty())
            { 
                $resultData = new ShopProductsCollection($productRecord);
                $message = $mainCategoryId->mac_title." list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => $mainCategoryId->mac_title,'data'=> $resultData],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = $mainCategoryId->mac_title." isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function secondHandItemsList(Request $request) 
    {
        try
        {
            
            $userDetails = User::select('use_village_id')->where('use_token',$request->token)->first();

            if($userDetails)
            {
                $villageId = $userDetails->use_village_id;
            }else{
                 $villageId = 0;
            }

            $productRecord = Products::where('pod_choose_type',3)->where('pod_status',0)->whereIn('pod_village_id',[0,$villageId])->limit(20)->get();

            if(!$productRecord->isEmpty())
            { 
                $subCategory = array();
                foreach ($productRecord as $key => $value)
                { 
                    $producturl = url("public/assets/img/products/".$value->pod_picture);
                    $subCategory[] = array("product_id" => ''.$value->pod_id.'',"product_name" => $value->pod_pro_name,"price" => $value->pod_price,"offer_price" => $value->pod_offer_price,"picture_url" => $producturl);
                }

                array_walk_recursive($subCategory, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $subCategory;

                $message = "જૂના મા વેચવાની વાચતુઓ";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => "જૂના મા વેચવાની વાચતુઓ",'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "જૂના મા વેચવાની વાચતુઓ isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function groceryItemsList(Request $request) 
    {
        try
        {
            $userDetails = User::select('use_village_id')->where('use_token',$request->token)->first();

            if($userDetails)
            {
                $villageId = $userDetails->use_village_id;
            }else{
                 $villageId = 0;
            }

            $categoryRecord = MainCategorys::where('mac_id',3)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$categoryRecord->mac_id)->where('pod_status',0)->whereIn('pod_village_id',[0,$villageId])->limit(20)->get();

            if(!$productRecord->isEmpty())
            { 
                $subCategory = array();
                foreach ($productRecord as $key => $value)
                { 
                    $producturl = url("public/assets/img/products/".$value->pod_picture);
                    $subCategory[] = array(
                        "product_id" => ''.$value->pod_id.'',
                        "product_name" => $value->pod_pro_name,
                        "brand_name" => $value->pod_brand_name,
                        "price" => $value->pod_price,
                        "weight" => ''.$value->pod_weight.'',
                        "offer_price" => $value->pod_offer_price,
                        "picture_url" => $producturl);
                }

                array_walk_recursive($subCategory, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $subCategory;

                $message = $categoryRecord->mac_title." list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => $categoryRecord->mac_title,'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = $categoryRecord->mac_title." isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

     public function personalCareList(Request $request) 
    {
        try
        {
            $userDetails = User::select('use_village_id')->where('use_token',$request->token)->first();

            if($userDetails)
            {
                $villageId = $userDetails->use_village_id;
            }else{
                 $villageId = 0;
            }

            $categoryRecord = MainCategorys::where('mac_id',6)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$categoryRecord->mac_id)->where('pod_status',0)->whereIn('pod_village_id',[0,$villageId])->limit(20)->get();

            if(!$productRecord->isEmpty())
            { 
                $subCategory = array();
                foreach ($productRecord as $key => $value)
                { 
                    $producturl = url("public/assets/img/products/".$value->pod_picture);
                    $subCategory[] = array(
                        "product_id" => ''.$value->pod_id.'',
                        "product_name" => $value->pod_pro_name,
                        "brand_name" => $value->pod_brand_name,
                        "price" => $value->pod_price,
                        "offer_price" => $value->pod_offer_price,
                        "picture_url" => $producturl);
                }

                array_walk_recursive($subCategory, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $subCategory;

                $message = $categoryRecord->mac_title." list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'category' => $categoryRecord->mac_title,'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = $categoryRecord->mac_title." isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function bannersList(Request $request) 
    {
        try
        {
            $bannersRecord = Banners::where('ban_status',0)->limit(10)->get();


            if(!$bannersRecord->isEmpty())
            { 
                $banners = array();
                foreach ($bannersRecord as $key => $value)
                { 
                    $producturl = url("public/assets/img/banners/".$value->ban_picture);
                    $banners[] = array("id" => ''.$value->ban_id.'',"title" => $value->ban_title,"picture_url" => $producturl);
                }

                array_walk_recursive($banners, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $banners;

                $message = "Banners list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message,'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Banners isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }
   
}
