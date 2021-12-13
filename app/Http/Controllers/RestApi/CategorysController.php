<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\ProductCategory;
use App\Model\ProductSubCategory;
use App\Model\MainCategorys;
use App\Model\Category;
use App\Model\SubCategory;
use Mail;
use DB;

class CategorysController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function mainCategoryList() 
    {
        try
        {
            $categoryRecord = MainCategorys::where('mac_id', '<', '7')->where('mac_status',0)->get();
            if(!$categoryRecord->isEmpty())
            { 
                $categoryDetails = array();
                foreach ($categoryRecord as $key => $value)
                { 
                    $categoryDetails[] = array("main_cat_id" => ''.$value->mac_id.'',"main_cat_name" => $value->mac_title);
                }

                array_walk_recursive($categoryDetails, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $categoryDetails;

                $message = "Main Category list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Category list isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function categoryList(Request $request) 
    {
        try
        {
            $categoryId = $request->main_cat_id;
            if($categoryId)
            {
                $maincategory = MainCategorys::where('mac_id',$categoryId)->where('mac_status',0)->first();
                $categoryRecord = Category::where('cat_main_id',$categoryId)->where('cat_status',0)->get();

                if(!$categoryRecord->isEmpty())
                { 
                    $categoryDetails = array();
                    foreach ($categoryRecord as $key => $value)
                    { 
                        $categoryDetails[] = array("cat_id" => ''.$value->cat_id.'',"cat_name" => $value->cat_name );
                    }

                    array_walk_recursive($categoryDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $categoryDetails;

                    $message = $maincategory->mac_title." Category list";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                }else{
                  $msg = "Category list isn't found";
                  return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                } 
            }else{
                 $msg = "Category id is required";
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
            $categoryId = $request->cat_id;
            if($categoryId)
            {
                $maincategory = Category::where('cat_id',$categoryId)->where('cat_status',0)->first();
                $subCategoryRecord = SubCategory::where('sub_cat_id',$categoryId)->where('sub_status',0)->get();

                if(!$subCategoryRecord->isEmpty())
                { 
                    $subCategoryDetails = array();
                    foreach ($subCategoryRecord as $key => $value)
                    { 
                        $subCategoryDetails[] = array("sub_cat_id" => ''.$value->sub_id.'',"sub_cat_name" => $value->sub_cat_name);
                    }

                    array_walk_recursive($subCategoryDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $subCategoryDetails;

                    $message = $maincategory->cat_name." Subcategory list";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                }else{
                  $msg = "Subcategory list isn't found";
                  return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                } 
            }else{
                 $msg = "Subcategory id is required";
                  return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
                
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }
   
}
