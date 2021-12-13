<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ShopProductsCollection;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\Belts;
use App\Model\BeltsCategory;
use App\Model\MainCategorys;
use App\Model\Products;
use App\Model\BeltsImages;
use App\Model\Clothes;
use Validator;
use Mail;
use DB;

class ShopModuleController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function shoesList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',9)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    /**
     * Return all users except the existing one
     * 
     */
    public function watchesList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',7)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    /**
     * Return all users except the existing one
     * 
     */
    public function walletesList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',11)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

     public function clothesList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',10)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    /**
     * Return all users except the existing one
     * 
     */
    public function beltesList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',8)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    // Api name mobiles covers list 
    public function mobilesCoversList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',12)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    // Api gadget list
    public function gadgetList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',15)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    // Api children toys List
    public function childrentoysList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',13)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

    // Api girl beauty list
    public function girlbeautyList(Request $request) 
    {
        try
        {
            $mainCategoryId = MainCategorys::where('mac_id',14)->where('mac_status',0)->first();

            $productRecord = Products::where('pod_main_cat_id',$mainCategoryId->mac_id)->where('pod_status',0)->limit('pod_id','DESC')->limit(10)->get();

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

}

