<?php
namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Mail\ForgetPassword;
use App\Mail\UserRegistered;
use Carbon\Carbon;
use App\Model\Villages;
use App\Model\SellerBankDetail;
use App\User;
use Validator;
use Hash;
use Mail;
use Input;
use DB;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        $rules = [
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
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
            if(is_numeric($request->mobile_number))
            {
                if(User::where('use_phone_no',$request->mobile_number)->exists())
                {
                    $updateData['use_fcm_token'] = $request->device_token;
                    $updateData['use_role'] = $request->user_type;
                    $userdetailsUpdate = User::where('use_phone_no',$request->mobile_number)->update($updateData);

                    $userdetails = User::where('use_phone_no',$request->mobile_number)->first();

                    if($userdetails->use_image)
                    {
                        $useProfile = url('public/assets/img/users/').'/'.$userdetails->use_image;
                    }else{
                        $useProfile = url('public/assets/img/default-profile-img.jpg');
                    }
                    $userRecord = array(
                    "user_id" => ''.$userdetails->id.'',
                    'full_name' => ''.$userdetails->use_full_name.'',
                    'mobile_number' => ''.$userdetails->use_phone_no.'',
                    'village' => ''.$userdetails->use_village_name.'',
                    'token' => ''.$userdetails->use_token.'',
                    'profile_url' => $useProfile,
                    'user_type' => ''.$userdetails->use_role.'');
                    $msg = "User details";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userRecord],JSON_UNESCAPED_SLASHES);
                }else{

                    $otpCode = rand(100000, 999999);
                    $lastId = User::select('id','use_user_order')->where('use_role',3)->orderBy('use_user_order','DESC')->limit(1)->first();
            
                    if($lastId)
                    {
                        $id = $lastId->use_user_order;
                        $userOrder = $lastId->use_user_order + 1;
                    }else{
                        $id = "00000";
                        $userOrder = 1;
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
                    $uniqueId = 'RSUSE'.$uId;

                    $insertData = new User;
                    $insertData->use_unique_id = $uniqueId;
                    $insertData->use_full_name = '';
                    $insertData->email = '';
                    $insertData->use_phone_no = $request->mobile_number;
                    $insertData->email_verified_at = date('Y-m-d H:i:s');
                    $insertData->password = bcrypt('123456');
                    $insertData->use_token = str_random(90);
                    $insertData->remember_token = str_random(90);
                    $insertData->use_fcm_token = $request->device_token ? $request->device_token:'';
                    $insertData->use_role = $request->user_type; // Users
                    $insertData->use_image = '';
                    $insertData->use_status = 0;
                    $insertData->use_shop_name = '';
                    $insertData->use_shop_address = '';
                    $insertData->use_village_id = 0;
                    $insertData->use_village_name = '';
                    $insertData->use_taluka = '';
                    $insertData->use_pincode = 0;
                    $insertData->use_alt_mobile_number = '';
                    $insertData->use_seller_order = 0;
                    $insertData->use_user_order = $userOrder;
                    $insertData->use_otp_code = $otpCode;
                    $insertData->created_at = date('Y-m-d H:i:s');
                    $insertData->updated_at = date('Y-m-d H:i:s');
                    $insertData->save();
                   
                    $userdetails = User::limit(1)->orderBy('id','DESC')->first();
                    $userRecord = array(
                    "user_id" => ''.$userdetails->id.'',
                    'full_name' => ''.$userdetails->use_full_name.'',
                    'mobile_number' => ''.$userdetails->use_phone_no.'',
                    'village' => ''.$userdetails->use_village_name.'',
                    'token' => ''.$userdetails->use_token.'',
                    'profile_url' => url('public/assets/img/default-profile-img.jpg'),
                    'user_type' => ''.$userdetails->use_role.'');
                    $msg = "User details";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userRecord],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $message = "only numberic value enter";
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function verfiyOtpcode(Request $request)
    {
        $rules = [
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'otp_code' => 'required|numeric'
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
            if(is_numeric($request->mobile_number))
            {
                if(User::where('use_phone_no',$request->mobile_number)->where('use_otp_code',$request->otp_code)->exists())
                {
                    $userdetails = User::where('use_phone_no',$request->mobile_number)->first();
                    $userRecord = array(
                    "user_id" => ''.$userdetails->id.'',
                    'full_name' => ''.$userdetails->use_full_name.'',
                    'mobile_number' => ''.$userdetails->use_phone_no.'',
                    'village' => ''.$userdetails->use_village_name.'',
                    'token' => ''.$userdetails->use_token.'',
                    'user_type' => ''.$userdetails->use_role.'');
                    $msg = "User details";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array($userRecord)],JSON_UNESCAPED_SLASHES);
                }else{
                    $msg = "Opt isn't valid!";
                    return json_encode(['status' => true, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $message = "Only numberic value valid!";
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function sellersignUp(Request $request)
    {
        $rules = [
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'full_name' => 'required',
            'shop_name' => 'required',
            'village_id' => 'required',
            'taluka' => 'required',

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
            if(is_numeric($request->mobile_number))
            {
                if(User::where('use_phone_no',$request->mobile_number)->exists())
                {
                    $msg = "Mobile number already exists!";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }else{

                    // *********************** Begin Default Store Dispaly Id ***********************
                    // Display_id Function
                    $lastId = User::select('id','use_seller_order')->where('use_role',2)->orderBy('use_seller_order','DESC')->limit(1)->first();
                    
                    if($lastId)
                    {
                        $id = $lastId->use_seller_order;
                        $sellerOrder = $lastId->use_seller_order + 1;
                    }else{
                        $id = "00000";
                        $sellerOrder = 1;
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
                    $uniqueId = 'RSSEL'.$uId;

                    // *********************** End Default Store Dispaly Id ******************

                     $village = Villages::where('vil_id',$request->village_id)->first();

                    $insertData = new User;
                    $insertData['use_unique_id'] = $uniqueId;
                    $insertData['email'] = '';
                    $insertData['use_full_name'] = $request->full_name;
                    $insertData['use_shop_name'] = $request->shop_name;
                    $insertData['use_shop_address'] = $request->shop_address ? $request->shop_address:'';
                    $insertData['use_village_id'] = $request->village_id;
                    $insertData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
                    $insertData['use_taluka'] = $request->taluka;
                    $insertData['use_pincode'] = 0;
                    $insertData['use_phone_no'] = $request->mobile_number;
                    $insertData['use_alt_mobile_number'] = '';
                    $insertData['use_seller_order'] = $sellerOrder;
                    $insertData['use_user_order'] = 0;
                    $insertData['email_verified_at'] = date('Y-m-d H:i:s');
                    $insertData['password'] = bcrypt('123456');
                    $insertData['use_token'] = str_random(90);
                    $insertData['remember_token'] = str_random(90);
                    $insertData['use_fcm_token'] = str_random(90);
                    $insertData['use_role'] = 2; // Seller User
                    $insertData['use_image'] = '';
                    $insertData['use_status'] = 0;
                    $insertData['use_otp_code'] = 0;
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $insertData['updated_at'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->orderBy('id','DESC')->first();

                    $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);

               
                    $msg = "Registration successfully.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $message = "only numberic value enter";
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function addBankdetail(Request $request)
    {
        $rules = [
            'seller_id' => 'required',
            'account_holder_name' => 'required',
            'bank_name' => 'required',
            'iafc_code' => 'required',
            'branch' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',

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
            
            if(SellerBankDetail::where('sbd_unique_id',$request->seller_id)->where('sbd_account_number',$request->account_number)->exists())
            {
                $msg = "Seller bank detail already exists!";
                return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES);

            }else{

                 // *********************** Begin Default Store Dispaly Id ***********************
                // Display_id Function
                $lastId = SellerBankDetail::select('sbd_id')->orderBy('sbd_id','DESC')->limit(1)->first();
                
                if($lastId)
                {
                    $id = $lastId->sbd_id;
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
                $uniqueId = 'SELBK'.$uId;

            // *********************** End Default Store Dispaly Id ******************

                $insertData = new SellerBankDetail;
                $insertData['sbd_unique_id'] = $uniqueId;
                $insertData['sbd_seller_id'] = $request->seller_id;
                $insertData['sbd_holder_name'] = $request->account_holder_name;
                $insertData['sbd_account_number'] = $request->account_number;
                $insertData['sbd_bank_name'] = $request->bank_name;
                $insertData['sbd_iafc_code'] = $request->iafc_code;
                $insertData['sbd_branch'] = $request->branch;
                $insertData['sbd_adhar_number'] = $request->adhar_card_number ? $request->adhar_card_number:'';
                $insertData['sbd_pan_number'] = $request->pan_card_number ? $request->pan_card_number:'';
                $insertData['sbd_status'] = 0;
                $insertData['sbd_createat'] = date('Y-m-d H:i:s');
                $insertData['sbd_updateat'] = date('Y-m-d H:i:s');
                $insertData->save();
            
                if($insertData)
                {
                   $msg = "Bank detail added successfully.";
                return json_encode(['status' => true, 'error' => '200', 'message' => $msg],JSON_UNESCAPED_SLASHES); 
                }else{
                    $message = "Bank detail isn't added";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
                }
            }
        }
    }

    public function profileDetail(Request $request)
    {
        $userToken = $request->token;

        if($userToken)
        {
            if(User::where('use_token',$userToken)->exists())
            {   
                if(User::where('use_token',$userToken)->where('use_role',2)->where('use_status',0)->exists())
                {
                    $userdetails = User::leftjoin('tbl_seller_bank_details','users.id','=','tbl_seller_bank_details.sbd_seller_id')->where('use_token',$userToken)->first();
                    $userRecord = array(
                    "user_id" => ''.$userdetails->id.'',
                    'token' => ''.$userdetails->use_token.'',
                    'full_name' => ''.$userdetails->use_full_name.'',
                    'mobile_number' => ''.$userdetails->use_phone_no.'',
                    'alt_mobile_number' => ''.$userdetails->use_alt_mobile_number.'',
                    'village_id' => ''.$userdetails->use_village_id.'',
                    'village' => ''.$userdetails->use_village_name.'',
                    'shop_name' => ''.$userdetails->use_shop_name.'',
                    'shop_address' => ''.$userdetails->use_shop_address.'',
                    'taluka' => ''.$userdetails->use_taluka.'',
                    'pincode' => ''.$userdetails->use_use_pincode.'',
                    'user_type' => ''.$userdetails->use_role.'',
                    'account_holder_name' => ''.$userdetails->sbd_holder_name.'',
                    'account_number' => ''.$userdetails->sbd_account_number.'',
                    'bank_name' => ''.$userdetails->sbd_bank_name.'',
                    'iafc_code' => ''.$userdetails->sbd_iafc_code.'',
                    'branch' => ''.$userdetails->sbd_branch.'',
                    'adhar_number' => ''.$userdetails->sbd_adhar_number.'',
                    'pan_card_number' => ''.$userdetails->sbd_pan_number.'');
                    $msg = "Seller personal details";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userRecord],JSON_UNESCAPED_SLASHES);
                }
                else
                {
                    $msg = "Your account isn't active.";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $msg = "Token isn't valid!";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
        }else{
            $msg = "Token is required!";
            return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
        }
    }

    public function customerSignUp(Request $request)
    {
        $rules = [
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'device_token' => 'required',
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
            if(is_numeric($request->mobile_number))
            {
                if(User::where('use_phone_no',$request->mobile_number)->exists())
                {
                    $updateData['use_fcm_token'] = $request->device_token;
                    $updateetails = User::where('use_phone_no',$request->mobile_number)->update($updateData);

                    $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->where('use_phone_no',$request->mobile_number)->first();

                    $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);
               
                    $msg = "Registration successfully.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);

                }else{

                    // *********************** Begin Default Store Dispaly Id ***********************
                    // Display_id Function
                    $lastId = User::select('id','use_seller_order')->where('use_role',2)->orderBy('use_seller_order','DESC')->limit(1)->first();
                    
                    if($lastId)
                    {
                        $id = $lastId->use_seller_order;
                        $sellerOrder = $lastId->use_seller_order + 1;
                    }else{
                        $id = "00000";
                        $sellerOrder = 1;
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
                    $uniqueId = 'RSSEL'.$uId;

                    // *********************** End Default Store Dispaly Id ******************

                     $village = Villages::where('vil_id',$request->village_id)->first();

                    $insertData = new User;
                    $insertData['use_unique_id'] = $uniqueId;
                    $insertData['email'] = '';
                    $insertData['use_full_name'] = '';
                    $insertData['use_shop_name'] = '';
                    $insertData['use_shop_address'] = '';
                    $insertData['use_village_id'] = 1;
                    $insertData['use_village_name'] = '';
                    $insertData['use_taluka'] = '';
                    $insertData['use_pincode'] = 0;
                    $insertData['use_phone_no'] = $request->mobile_number;
                    $insertData['use_alt_mobile_number'] = '';
                    $insertData['use_seller_order'] = 0;
                    $insertData['use_user_order'] = 0;
                    $insertData['email_verified_at'] = date('Y-m-d H:i:s');
                    $insertData['password'] = bcrypt('123456');
                    $insertData['use_token'] = str_random(90);
                    $insertData['remember_token'] = str_random(90);
                    $insertData['use_fcm_token'] = $request->device_token;
                    $insertData['use_role'] = 3; // Seller User
                    $insertData['use_image'] = '';
                    $insertData['use_status'] = 0;
                    $insertData['use_otp_code'] = 0;
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $insertData['updated_at'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->orderBy('id','DESC')->first();

                    $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);

               
                    $msg = "Registration successfully.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $message = "only numberic value enter";
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'fullname' => 'required',
            'village_id' => 'required'
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
            if(is_numeric($request->mobile_number))
            {
                if(User::where('use_phone_no',$request->mobile_number)->exists())
                {
                    $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->where('use_phone_no',$request->mobile_number)->first();

                    $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);
               
                    $msg = "Registration successfully.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);

                }else{

                    // *********************** Begin Default Store Dispaly Id ***********************
                    // Display_id Function
                    $lastId = User::select('id','use_seller_order')->where('use_role',2)->orderBy('use_seller_order','DESC')->limit(1)->first();
                    
                    if($lastId)
                    {
                        $id = $lastId->use_seller_order;
                        $sellerOrder = $lastId->use_seller_order + 1;
                    }else{
                        $id = "00000";
                        $sellerOrder = 1;
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
                    $uniqueId = 'RSSEL'.$uId;

                    // *********************** End Default Store Dispaly Id ******************

                    $village = Villages::where('vil_id',$request->village_id)->first();

                    $insertData = new User;
                    $insertData['use_unique_id'] = $uniqueId;
                    $insertData['email'] = '';
                    $insertData['use_full_name'] = $request->fullname;
                    $insertData['use_shop_name'] = '';
                    $insertData['use_shop_address'] = '';
                    $insertData['use_village_id'] = $request->village_id;
                    $insertData['use_village_name'] = $village->vil_name;
                    $insertData['use_taluka'] = '';
                    $insertData['use_pincode'] = 0;
                    $insertData['use_phone_no'] = $request->mobile_number;
                    $insertData['use_alt_mobile_number'] = '';
                    $insertData['use_seller_order'] = 0;
                    $insertData['use_user_order'] = 0;
                    $insertData['email_verified_at'] = date('Y-m-d H:i:s');
                    $insertData['password'] = bcrypt('123456');
                    $insertData['use_token'] = str_random(90);
                    $insertData['remember_token'] = str_random(90);
                    $insertData['use_fcm_token'] = str_random(90);
                    $insertData['use_role'] = 3; // Seller User
                    $insertData['use_image'] = '';
                    $insertData['use_status'] = 0;
                    $insertData['use_otp_code'] = 0;
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $insertData['updated_at'] = date('Y-m-d H:i:s');
                    $insertData->save();

                    $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->orderBy('id','DESC')->first();

                    $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);

               
                    $msg = "Registration successfully.";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $message = "only numberic value enter";
                return json_encode(['status' => false, 'error' => '401', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function bankDetailStatus(Request $request)
    {
         try
        {
            $userToken = $request->token;
            if($userToken)
            {
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    
                    $userDetails = User::select('id')->where('use_token',$userToken)->where('use_status',0)->first();

                    $userBankDetails = DB::table('tbl_seller_bank_details')->where('sbd_seller_id',$userDetails->id)->first();
                    
                    if($userBankDetails)
                    {
                        $status = array('status'=>'true');
                    }else{
                         $status = array('status'=>'false');
                    }
                    $message = "Bank Detail Status";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> [$status]],JSON_UNESCAPED_SLASHES);
                   
                }else{
                    ResponseMessage::error("Seller isn't exists!");
                }
               
            }else{
                ResponseMessage::error("Token is required!");
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function sellersUpdateProfile(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'full_name' => 'required',
            'shop_name' => 'required',
            'village_id' => 'required',
            'taluka' => 'required',

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
            if(is_numeric($request->mobile_number))
            {
                // *********************** Begin Default Store Dispaly Id ***********************
                // Display_id Function
                $lastId = User::select('id','use_seller_order')->where('use_role',2)->orderBy('use_seller_order','DESC')->limit(1)->first();
                
                if($lastId)
                {
                    $id = $lastId->use_seller_order;
                    $sellerOrder = $lastId->use_seller_order + 1;
                }else{
                    $id = "00000";
                    $sellerOrder = 1;
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
                $uniqueId = 'RSSEL'.$uId;

                // *********************** End Default Store Dispaly Id ******************

                 $village = Villages::where('vil_id',$request->village_id)->first();

                $updateData['use_full_name'] = $request->full_name;
                $updateData['use_shop_name'] = $request->shop_name;
                $updateData['use_village_id'] = $request->village_id;
                $updateData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
                $updateData['use_taluka'] = $request->taluka;
                $updateData['use_phone_no'] = $request->mobile_number;
                $updateData['use_role'] = 2; // Seller User
                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $updateDeetails = User::where('id',$request->user_id)->update($updateData);

                $userDetail = DB::table('users')->select('id as user_id','email','use_token as token','use_full_name as full_name','use_role','use_phone_no','created_at','use_village_name','use_village_id','use_taluka')->where('id',$request->user_id)->first();

                $userDetails = array("user_id" => $userDetail->user_id,"full_name" => $userDetail->full_name,"use_phone_no" => $userDetail->use_phone_no,"role" => $userDetail->use_role,'village_id' => $userDetail->use_village_id,'village_name' => $userDetail->use_village_name,'taluka' => $userDetail->use_taluka,"token" => $userDetail->token);

                $msg = "Registration successfully.";
                return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => $userDetails],JSON_UNESCAPED_SLASHES);
            }else{
                $message = "Mobile number is'nt valid!";
                return json_encode(['status' => true, 'error' => '200', 'message' => $message],JSON_UNESCAPED_SLASHES);
            }
            
        }
    }
}