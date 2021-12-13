<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\ProductOrder;
use App\User;
use Mail;
use DB;

class SellerOrderController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function index(Request $request) 
    {
        try
        {
            $token = $request->token;
            if($token)
            {    
                if(User::where('use_token',$token)->where('use_status',0)->exists())
                {        
                    $userDetails = User::select('id')->where('use_token',$token)->where('use_status',0)->first();

                    $orderDetails = ProductOrder::leftjoin('users','tbl_orders.ord_customer_id','=','users.id')->leftjoin('tbl_orders_summary','tbl_orders.ord_order_id','=','tbl_orders_summary.ors_order_id')->where('ord_seller_id',$userDetails->id)->get();

                    if(!$orderDetails->isEmpty())
                    { 
                        $orderRecords = array();
                        foreach ($orderDetails as $key => $value)
                        { 
                            $productsDetails = DB::table('tbl_products')->select('pod_picture','pod_pro_name','pod_brand_name')->where('pod_id',$value->ors_product_id)->first();
                            if($productsDetails){
                                $productUrl = url("public/assets/img/products/".$productsDetails->pod_picture);
                                $productName = $productsDetails->pod_pro_name;
                                $brandName = $productsDetails->pod_brand_name;
                            }else{
                                $productUrl = url("public/assets/img/products/plain-img.jpg");
                                $productName = "";
                                $brandName = "";
                            }
                            
                            $orderRecords[] = array(
                                "order_id" => ''.$value->ord_id.'',
                                "order_code" => $value->ord_order_id,
                                "product_id" => ''.$value->ors_product_id.'',
                                "product_name" =>  $productName,
                                "brand_name" => $brandName,
                                "price" => ''.$value->ors_unit_per_price.'',
                                "quantity" => ''.$value->ors_qty_ordered.'',
                                "total" => ''.$value->ors_grand_total.'',
                                "customer_name" => $value->ord_full_name,
                                "shipping_address" => $value->ord_shipped_to,
                                "contact_number" => ''.$value->ord_phone_number.'',
                                "order_status" => ''.$value->ord_order_status_title.'',
                                "order_status_id" => ''.$value->ord_order_status.'',
                                "delivery_boy" => ''.$value->ord_delivery_boy_name.'',
                                "order_date" => $value->ord_order_date,
                                "latitude" => $value->ord_latitude,
                                "longitude" => $value->ord_longitude,
                                "picture_url" => $productUrl,
                            );
                        }

                        array_walk_recursive($orderRecords, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $orderRecords;

                        $message = "Seller order list";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                     $message = "Seller order isn't list";
                      return json_encode(['status' => true, 'error' => '200', 'message' => $message,'data' => array()],JSON_UNESCAPED_SLASHES);
                    } 
                }else{
                    ResponseMessage::error("Seller isn't exists!");
                }
            }else{
                 $msg = "Token is required!";
                  return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
                
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function orderStatuschange(Request $request)
    {
        $rules = [
            'order_id' => 'required',
            'order_status' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {                
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }else
        {
            if(ProductOrder::where('ord_id',$request->order_id)->exists())
            {

                $updateData['ord_order_status'] = $request->order_status;
                if($request->order_status == 0)
                {
                    $statusTitle = "Pending";
                }
                else if($request->order_status == 1)
                {
                    $statusTitle = "Delivery";
                }
                else if($request->order_status == 2)
                {
                    $statusTitle = "Confirm";
                }
                else if($request->order_status == 3)
                {
                    $statusTitle = "Cancle";
                }else{
                    $statusTitle = "";
                }
               
                $updateData['ord_order_status_title'] = $statusTitle;
                $updateDetails = ProductOrder::where('ord_id',$request->order_id)->update($updateData);
                   
                if($updateDetails)
                {
                     ResponseMessage::successMessage("Order status changed successfully");
                   
                }else{
                    ResponseMessage::error("Order status isn't changed");
                }
            }else{
                $msg = "Order id isn't valid!";
                return json_encode(['status' => true, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }
    }
   
}
