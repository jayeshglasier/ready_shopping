<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\Villages;
use App\Model\Brands;
use Mail;
use DB;

class VillagesController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function index(Request $request) 
    {
        try
        {
            $villagesRecord = Villages::where('vil_status',0)->get();
            if(!$villagesRecord->isEmpty())
            { 
                $villageDetails = array();
                foreach ($villagesRecord as $key => $value)
                { 
                    $villageDetails[] = array("id" => ''.$value->vil_id.'',"village_name" => $value->vil_name);
                }

                array_walk_recursive($villageDetails, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $villageDetails;

                $message = "Village name list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Village name isn't found";
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
    public function brandList(Request $request) 
    {
        try
        {
            $brandsRecord = Brands::where('brd_status',0)->get();
            if(!$brandsRecord->isEmpty())
            { 
                $brandDetails = array();
                foreach ($brandsRecord as $key => $value)
                { 
                    $brandDetails[] = array("brand_id" => ''.$value->brd_id.'',"brand_name" => $value->brd_brand_name);
                }

                array_walk_recursive($brandDetails, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $brandDetails;

                $message = "Brands name list";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Brands name isn't found";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }
   
}
