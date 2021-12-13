<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Model\CustomerPayment;
use App\User;
use Mail;
use DB;

class PaymentsController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function productsPayment(Request $request) 
    {
        try
        {
            $rules = [
                'payment_id' => 'required',
                'user_id' => 'required',
                'account' => 'required',
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
                $userToken = $request->user_id;

                if($userToken)
                {
                    if(User::where('id',$userToken)->exists())
                    {   
                        if(User::where('id',$userToken)->where('use_status',0)->exists())
                        {
                            $userDetail = User::where('id',$userToken)->where('use_status',0)->first();
                            $insertData = new CustomerPayment;
                            $insertData['pay_unique_id'] = date('YmdHis');
                            $insertData['pay_payment_id'] = $request->payment_id;
                            $insertData['pay_user_id'] = $request->user_id;
                            $insertData['pay_amount'] = $request->account ? $request->account:0;
                            $insertData['pay_status'] = 0;
                            $insertData['pay_createat'] = date('Y-m-d H:i:s');
                            $insertData['pay_updateat'] = date('Y-m-d H:i:s');
                            $insertData->save();

                            if($insertData)
                            {   
                                $message = "Payment add successfuly!";
                                return json_encode(['status' => true, 'error' => '200', 'message' => $message],JSON_UNESCAPED_SLASHES);

                            }else{
                                $msg = "Profile isn't updated";
                                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                            }
                        }else{
                            $msg = "Your account isn't active.";
                            return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                        }
                        
                    }
                    else{
                        $msg = "User id isn't valid!";
                        return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }

                }else{
                    $msg = "User id isn't found!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }

        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }
}
