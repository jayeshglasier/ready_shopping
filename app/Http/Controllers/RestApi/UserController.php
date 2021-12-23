<?php

namespace App\Http\Controllers\RestApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
use App\Helper\ResponseMessage;
use App\Helper\Exceptions;
use App\Mail\UserRegistered;
use App\Post;
use App\User;
use App\MediaFile;
use Mail;
use DB;

class UserController extends Controller
{
    /**
     * Return all users except the existing one
     * 
     */
    public function index(Request $request) 
    {
        $userToken = $request->token;

        if($userToken)
        {
            if(User::where('use_token',$userToken)->exists())
            {   
                if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                {
                    $userdetails = User::where('use_token',$userToken)->first();

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
                    'user_type' => ''.$userdetails->use_role.'',
                    'profile_url' => $useProfile,);
                    $msg = "User personal details";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => [$userRecord]],JSON_UNESCAPED_SLASHES);
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

    public function editProfile(Request $request) 
    {
        try
        {
            $rules = [
                'token' => 'required',
                'full_name' => 'required',
                'mobile_number' => 'required|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
                'village' => 'required',
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
                $userToken = $request->token;

                if($userToken)
                {
                    if(User::where('use_token',$userToken)->exists())
                    {   
                        if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                        {
                            $userDetail = User::where('use_token',$userToken)->where('use_status',0)->first();

                            if($request->file('profile_image'))
                            {
                                $fileLink = str_random(40);
                                $images = $request->file('profile_image');
                                $imagesname = str_replace(' ', '-',$fileLink.'users.'. $images->getClientOriginalExtension());
                                $images->move(public_path('assets/img/users/'),$imagesname);

                            }else{
                               $imagesname = '';
                            }

                            $updateData['use_full_name'] = $request->full_name ? $request->full_name:$userDetail->use_full_name;
                            $updateData['use_phone_no'] = $request->mobile_number ? $request->mobile_number:$userDetail->use_phone_no;
                            $updateData['use_village_name'] = $request->village ? $request->village:$userDetail->use_village_name;
                            $updateData['use_image'] = $imagesname;
                            $updateData['updated_at'] = date('Y-m-d H:i:s');
                            $update = User::where('use_token',$userToken)->update($updateData);

                            if($update)
                            {   
                                $usertDetail = DB::table('users')->where('use_token',$userToken)->first();

                                if($usertDetail->use_image)
                                {
                                    $useProfile = url('public/assets/img/users/').'/'.$usertDetail->use_image;
                                }else{
                                    $useProfile = url('public/assets/img/default-profile-img.jpg');
                                }

                                $userRecord = array(
                                    "user_id" => ''.$usertDetail->id.'',
                                    'full_name' => ''.$usertDetail->use_full_name.'',
                                    'mobile_number' => ''.$usertDetail->use_phone_no.'',
                                    'village' => ''.$usertDetail->use_village_name.'',
                                    'token' => ''.$usertDetail->use_token.'',
                                    'profile_url' => $useProfile,
                                    'user_type' => ''.$usertDetail->use_role.''
                                );

                                $message = "Profile updated";
                                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> [$userRecord]],JSON_UNESCAPED_SLASHES);

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
                        $msg = "Token isn't valid!";
                        return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }

                }else{
                    $msg = "Token isn't found!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }

        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }


     public function uploadProfile(Request $request) 
    {
        try
        {
            $rules = [
                'token' => 'required',
                'profile_image' => 'required',
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
                $userToken = $request->token;

                if($userToken)
                {
                    if(User::where('use_token',$userToken)->exists())
                    {   
                        if(User::where('use_token',$userToken)->where('use_status',0)->exists())
                        {
                            $userDetail = User::where('use_token',$userToken)->where('use_status',0)->first();

                            if($request->file('profile_image'))
                            {
                                $fileLink = str_random(40);
                                $images = $request->file('profile_image');
                                $imagesname = str_replace(' ', '-',$fileLink.'users.'. $images->getClientOriginalExtension());
                                $images->move(public_path('assets/img/users/'),$imagesname);

                            }else{
                               $imagesname = '';
                            }

                            $updateData['use_image'] = $imagesname;
                            $updateData['updated_at'] = date('Y-m-d H:i:s');
                            $update = User::where('use_token',$userToken)->update($updateData);

                            if($update)
                            {   
                                $usertDetail = DB::table('users')->where('use_token',$userToken)->first();

                                if($usertDetail->use_image)
                                {
                                    $useProfile = url('public/assets/img/users/').'/'.$usertDetail->use_image;
                                }else{
                                    $useProfile = url('public/assets/img/default-profile-img.jpg');
                                }

                                $userRecord = array(
                                    "user_id" => ''.$usertDetail->id.'',
                                    'full_name' => ''.$usertDetail->use_full_name.'',
                                    'mobile_number' => ''.$usertDetail->use_phone_no.'',
                                    'village' => ''.$usertDetail->use_village_name.'',
                                    'token' => ''.$usertDetail->use_token.'',
                                    'profile_url' => $useProfile,
                                    'user_type' => ''.$usertDetail->use_role.''
                                );

                                $message = "Profile picture updated";
                                return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> [$userRecord]],JSON_UNESCAPED_SLASHES);

                            }else{
                                $msg = "Profile picture isn't updated";
                                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                            }
                        }else{
                            $msg = "Your account isn't active.";
                            return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                        }
                    }
                    else{
                        $msg = "Token isn't valid!";
                        return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }

                }else{
                    $msg = "Token isn't found!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }

        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function userList(Request $request)
    {
        try
        {
            $userToken = "123";
            if($userToken)
            {
                $userDetail = User::select('id','use_full_name','use_phone_no','use_alt_mobile_number','use_village_name','use_token','use_role')->where('use_role',3)->where('use_status',0)->get();
                if(!$userDetail->isEmpty())
                { 
                    $usersDetails = array();
                    foreach ($userDetail as $key => $value)
                    { 
                        $usersDetails[] = array(
                            "user_id" => ''.$value->id.'',
                            'full_name' => ''.$value->use_full_name.'',
                            'mobile_number' => ''.$value->use_phone_no.'',
                            'alt_mobile_number' => ''.$value->use_alt_mobile_number.'',
                            'village' => ''.$value->use_village_name.'',
                            'token' => ''.$value->use_token.'',
                            'user_type' => ''.$value->use_role.'');
                    }

                    array_walk_recursive($usersDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $usersDetails;

                    $message = "Users detail list";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                }else{
                  $msg = "User detail isn't available.";
                  return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $msg = "Token is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function deliveryBoyList(Request $request)
    {
        try
        {
            $userToken = "123";
            if($userToken)
            {
                $userDetail = User::select('id','use_full_name','use_phone_no','use_alt_mobile_number','use_village_name','use_token','use_role')->where('use_role',4)->where('use_status',0)->get();
                if(!$userDetail->isEmpty())
                { 
                    $usersDetails = array();
                    foreach ($userDetail as $key => $value)
                    { 
                        $usersDetails[] = array(
                            "user_id" => ''.$value->id.'',
                            'full_name' => ''.$value->use_full_name.'',
                            'mobile_number' => ''.$value->use_phone_no.'',
                            'alt_mobile_number' => ''.$value->use_alt_mobile_number.'',
                            'village' => ''.$value->use_village_name.'',
                            'token' => ''.$value->use_token.'',
                            'user_type' => ''.$value->use_role.'');
                    }

                    array_walk_recursive($usersDetails, function (&$item, $key) {
                    $item = null === $item ? '' : $item;
                    });
                    $this->data[$key] = $usersDetails;

                    $message = "Users detail list";
                    return json_encode(['status' => true, 'error' => '200', 'message' => $message, 'data'=> $this->data[$key]],JSON_UNESCAPED_SLASHES);

                }else{
                  $msg = "User detail isn't available.";
                  return json_encode(['status' => true, 'error' => '200', 'message' => $msg,'data' => array()],JSON_UNESCAPED_SLASHES);
                }
            }else{
                $msg = "Token is required";
                return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
            }
            
        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

    public function activeUser(Request $request) 
    {
        try
        {
            $rules = [
                'mobile_number' => 'required',
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
                $mobileNumber = $request->mobile_number;

                if($mobileNumber)
                {
                    if(User::where('use_phone_no',$mobileNumber)->where('use_status',0)->exists())
                    {
                        $message = "User is active";
                        return json_encode(['status' => true, 'error' => '200', 'account' => '0', 'message' => $message],JSON_UNESCAPED_SLASHES);
                    }else{
                        $msg = "Your account isn't active.";
                        return json_encode(['status' => false, 'error' => '401', 'account' => '1', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                    }
                }else{
                    $msg = "Token isn't found!";
                    return json_encode(['status' => false, 'error' => '401', 'message' => $msg],JSON_UNESCAPED_SLASHES);
                }
            }

        }catch (\Exception $e) {    
            Exceptions::exception($e);
        }
    }

   
}
