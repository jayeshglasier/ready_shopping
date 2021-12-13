<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\ProductOrder;
use App\Model\OrderSummary;
use App\Model\Cart;
use App\Model\Products;
use App\User;
use Mail;
use DB;

class ProductOrderController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function addOrder(Request $request) 
    {
        $rules = [
            'token' => 'required',
            'shipping_address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'pay_method' => 'required',
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/'
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
            $userDetails = User::where('use_token',$request->token)->where('use_status',0)->first();
            if($userDetails)
            {
                $userCartList = Cart::join('tbl_products','tbl_cart.crt_product_id','=','tbl_products.pod_id')->where('crt_user_id',$userDetails->id)->where('crt_status',0)->get();

                if(!$userCartList->isEmpty())
                { 
                     // *********************** Begin Default Store Dispaly Id ***********************
                
                        // Display_id Function
                        $lastId = ProductOrder::select('ord_id')->orderBy('ord_id','DESC')->limit(1)->first();
                        
                        if($lastId)
                        {
                            $id = $lastId->ord_id;
                        }else{
                            $id = "00000";
                        }

                        if ($id<=129999)
                        {
                            $num     = $id;
                            $letters = range('A', 'Z');
                            $letter  = (int) $num / 50000;
                            $num     = $num % 50000 + 1;
                            $num     = str_pad($num, 5, 0, STR_PAD_LEFT);
                            $uniId =  $letters[$letter] . $num;

                        }

                        $uId = substr($uniId,1);
                        $uniqueId = 'ORD'.$uniId;

                    // *********************** End Default Store Dispaly Id ******************

                        $unique_Id = date("dmyhis");

                        $insertData = new ProductOrder;
                        $insertData['ord_unique_id'] = $unique_Id;
                        $insertData['ord_order_id'] = $uniqueId;
                        $insertData['ord_customer_id'] = $userDetails->id;
                        $insertData['ord_full_name'] = $userDetails->use_full_name ? $userDetails->use_full_name:'';
                        $insertData['ord_email'] = $userDetails->email ? $userDetails->email:'';
                        $insertData['ord_phone_number'] = $request->mobile_number;
                        $insertData['ord_alternate_number'] = $request->alternate_number ? $request->alternate_number:'';
                        $insertData['ord_shipped_to'] = $request->shipping_address ? $request->shipping_address:'';
                        $insertData['ord_shipping_method'] = $request->pay_method ? $request->pay_method:'Cash';
                        $insertData['ord_order_date'] = date('Y-m-d H:i:s');
                        $insertData['ord_pay_method'] = $request->pay_method;
                        $insertData['ord_delivery_boy_name'] = '';
                        $insertData['ord_seller_name'] = '';
                        $insertData['ord_seller_id'] = 0;
                        $insertData['ord_delivery_boy_id'] = 0;
                        $insertData['ord_order_status'] = 0;
                        $insertData['ord_order_status_title'] = "Pending";
                        $insertData['ord_status'] = 0;
                        $insertData['ord_latitude'] = $request->latitude;
                        $insertData['ord_longitude'] = $request->longitude;
                        $insertData['ord_createat'] = date('Y-m-d H:i:s');
                        $insertData['ord_updateat'] = date('Y-m-d H:i:s');
                        $insertData->save();

                        foreach ($userCartList as $key => $order) {
                        // *********************** BEGIN PRODUCT ORDER ***************
                        $insertOrder = new OrderSummary;
                        $insertOrder['ors_order_id'] = $uniqueId;
                        $insertOrder['ors_product_id'] = $order->pod_id;
                        $insertOrder['ors_colour'] = $order->crt_colour;
                        $insertOrder['ors_size'] = $order->crt_size;
                        if($order->pod_deal_of_day == 1)
                        {
                            $insertOrder['ors_unit_per_price'] = $order->pod_offer_price ? $order->pod_offer_price:0.00;

                            $subTotal = $order->crt_quantity * $order->pod_offer_price;  // Sub total
                            $grandTotal = $order->crt_quantity * $order->pod_offer_price; // Grand Total

                        }else{
                            $insertOrder['ors_unit_per_price'] = $order->pod_price ? $order->pod_price:0.00;

                            $subTotal = $order->crt_quantity * $order->pod_price;  // Sub total
                            $grandTotal = $order->crt_quantity * $order->pod_price; // Grand Total
                        }
                        $insertOrder['ors_qty_ordered'] = $order->crt_quantity ? $order->crt_quantity:1;
                        $insertOrder['ors_sub_total'] = $subTotal ? $subTotal:0.00;
                        $insertOrder['ors_grand_total'] = $grandTotal ? $grandTotal:0.00;
                        $insertOrder['ors_status'] = 0;
                        $insertOrder['ors_createat'] = date('Y-m-d H:i:s');
                        $insertOrder['ors_updateat'] = date('Y-m-d H:i:s');
                        $insertOrder->save();

                        // *********************** END PRODUCT ORDER ***************
                        }
                    // Delete Cart List
                    Cart::where('crt_user_id',$userDetails->id)->where('crt_status',0)->delete();

                    //put the sender id;    
                    $mobileNumber= $request->mobile_number;
                    //put the email id;
                    $message="તમારા ઓર્ડરની પુષ્ટિ કરવામાં આવી છે. 2 દિવસની અંદર તમને તમારો ઓર્ડર મળશે."; // seller message
                    //put the sender id;    
                    $senderId="DEMOOS"; 
                    $serverUrl="msg.msgclub.net";
                    //put the auth key; 
                    $authKey="fcf1efc6a571581a708398eec7479aed"; 
                    $route="1";
                    $this->sendsmsGET($mobileNumber,$senderId,$route,$message,$serverUrl,$authKey);

                    if($insertData)
                    {
                       $msg = "Order added successfully.";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES); 
                    }else{
                        $msg = "Order isn't added";
                        return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Order isn't added";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }else{
                 $msg = "Token is'nt valid!";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function sendsmsGET($mobileNumber,$senderId,$routeId,$message,$serverUrl,$authKey)  
    {   
        $route = "default";
        $getData = 'mobileNos='.$mobileNumber.'&message='.urlencode($message).'&senderId='.$senderId.'&routeId='.$routeId;
        //API URL   
        $url="http://".$serverUrl."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey."&".$getData;    
        // init the resourc
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0
        ));
        //get response
        $output = curl_exec($ch);   
        //Print error if any
        curl_close($ch);    
    }

    public function ordersList(Request $request) 
    {
        try
        {  
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userId = User::where('use_token',$request->token)->where('use_status',0)->first();

                    $productsRecord = ProductOrder::with('productlist')->where('ord_customer_id',$userId->id)->get();

                    
                    if(!$productsRecord->isEmpty())
                    { 
                        $productDetails = array();
                        foreach ($productsRecord as $key => $value)
                        { 
                            if($value->ord_status == 0)
                            {
                                $orderStstus = "ઓર્ડર પેન્ડિંગ છે.";
                            }else if($value->ord_status == 1)
                            {
                                $orderStstus = "ઓર્ડર કન્ફોર્મ , ડીલેવરી માટે રેડી છે.";
                            }
                            else if($value->ord_status == 2)
                            {
                                $orderStstus = "ડિલેવરી થઇ ગયી છે.";
                            }
                            else if($value->ord_status == 3)
                            {
                                $orderStstus = "માફ કરજો ઓડર કેનસલ થયો છે.";
                            }else{
                                $orderStstus = "ઓર્ડર પેન્ડિંગ છે.";
                            }

                            $productLists = array();
                            
                            foreach ($value['productlist'] as $key => $pro_value) {

                            $productsDetails = Products::where('pod_id',$pro_value->ors_product_id)->first();

                            if($productsDetails['pod_picture'])
                            {
                                $productUrl = url("public/assets/img/products/".$productsDetails->pod_picture);
                            }else{
                                $productUrl = '';
                            }
                            

                            $productLists[] = array(
                                "product_name" => ''.$productsDetails['pod_pro_name'].'',
                                "description" => ''.$productsDetails['pod_pro_description'].'',
                                "colour" => ''.$pro_value->ors_colour.'',
                                "size" => ''.$pro_value->ors_size.'',
                                "qty_ordered" => ''.$pro_value->ors_qty_ordered.'',
                                "unit_per_price" => ''.$pro_value->ors_unit_per_price.'',
                                "total" => ''.$pro_value->ors_grand_total.'',
                                "picture_url" => $productUrl,
                                );
                            }

                            $totalSum = OrderSummary::select('ors_grand_total')->where('ors_order_id',$value->ord_order_id)->sum('ors_grand_total');

                            $productDetails[] = array(
                                "order_id" => ''.$value->ord_id.'',
                                "order_code" => ''.$value->ord_order_id.'',
                                "shipped_to" => $value->ord_shipped_to,
                                "billed_to_name" => "VAGHELA BHARATBHAI R",
                                "billed_to_address" => "ચાળવા,લાખણી",
                                "billed_to_mobile" => "9978291640, 9978291640",
                                "order_date" => ''.$value->ord_order_date.'',
                                "payment_method" => ''.$value->ord_shipping_method.'',
                                "is_confirm" => '1',
                                "order_status" =>  $orderStstus,
                                "total_sum" => $totalSum,
                                "products_list" => $productLists
                                );
                        }
                        array_walk_recursive($productDetails, function (&$item, $key) {
                        $item = null === $item ? '' : $item;
                        });
                        $this->data[$key] = $productDetails;

                        $msg = "Order products detail";
                        return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $this->data[$key]],JSON_UNESCAPED_SLASHES);

                    }else{
                      $isEmptyData = array();
                      ResponseMessage::success("Order detail isn't available.",$isEmptyData);
                    }
                }else{
                    ResponseMessage::error("User isn't exists!");
                }
               
            }else{
                ResponseMessage::error("Token is required!");
            }
            
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function orderHistory(Request $request) 
    {
        try
        {
            $productsRecord = Products::join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_status',0)->get();
            if(!$productsRecord->isEmpty())
            { 
                $productDetails = array();
                foreach ($productsRecord as $key => $value)
                { 
                    $productUrl = url("public/assets/img/products/".$value->pod_picture);
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
                        'picture_url' => $productUrl);
                }

                array_walk_recursive($productDetails, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $productDetails;

                $message = "Product detail id wise";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Product detail isn't available.";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function orderConfirmation(Request $request) 
    {
        try
        {
            $productsRecord = Products::join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_status',0)->get();
            if(!$productsRecord->isEmpty())
            { 
                $productDetails = array();
                foreach ($productsRecord as $key => $value)
                { 
                    $productUrl = url("public/assets/img/products/".$value->pod_picture);
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
                        'picture_url' => $productUrl);
                }

                array_walk_recursive($productDetails, function (&$item, $key) {
                $item = null === $item ? '' : $item;
                });
                $this->data[$key] = $productDetails;

                $message = "Product detail id wise";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

            }else{
              $msg = "Product detail isn't available.";
              return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }  
}