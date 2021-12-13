<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Villages;
use App\User;
use Auth;
use Session;
use Input;
use PDF;

class UsersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Grid List...
    public function index()
    {
        try
        {
            $data['i'] = 1;
            $data['search'] = Input::get('search');
            $search = Input::get('search');
            $data['pageGoto'] = Input::get('page');
            $pageFilter = Input::get('pagefilter');
            if($pageFilter)
            {
                $data['pages'] = Input::get('pagefilter');
                $pages = Input::get('pagefilter');
            }else{
                $data['pages'] = 10;
                $pages = 10;
            }

            $pageOrderBy = Input::get('asc_desc_filter');
            if($pageOrderBy)
            {
                $data['pageOrder'] = Input::get('asc_desc_filter');
                $pageOrder = Input::get('asc_desc_filter');
            }else{
                $data['pageOrder'] = "DESC";
                $pageOrder = "DESC";
            }

            $pageOrderBySelect = Input::get('sort_by');
            if($pageOrderBySelect)
            {
                $data['sortBy'] = Input::get('sort_by');
                $pageAsc_Desc = Input::get('sort_by');
            }else{
                $data['sortBy'] = "id";
                $pageAsc_Desc = "id";
            }

            if($search)
            {   
                $data['datarecords'] = User::orderBy($pageAsc_Desc,$pageOrder)->where('use_full_name','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = User::where('use_role',3)->orderBy($pageAsc_Desc,$pageOrder)->paginate($pages);
            }
            return view('users-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {   
        $data['villages'] = Villages::where('vil_status',0)->orderBy('vil_name','ASC')->get();
        return view('users-mgmt.create',$data);
    }

    // Create Form...
    public function userProfile()
    {   
        $data['villages'] = Villages::where('vil_status',0)->orderBy('vil_name','ASC')->get();
        return view('users-mgmt.user-profile',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['villages'] = Villages::where('vil_status',0)->orderBy('vil_name','ASC')->get();
        $data['editData'] = User::where('remember_token',$id)->first();
        return view('users-mgmt.edit',$data);
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  
     * @return \Success or Rrror message
     */

    public function store(Request $request)
    {   
        $this->validateStore($request);
        try
        {  
            if(User::where('use_phone_no',$request->use_phone_no)->exists())
            {
                Session::flash('error', 'User already exists!');
                return redirect()->intended('/create-users');
            }
            // *********************** Begin Default Store Dispaly Id ***********************
            // Display_id Function
            $lastId = User::select('id')->where('use_role',3)->orderBy('id','DESC')->limit(1)->first();
            
            if($lastId)
            {
                $id = $lastId->id;
                $sellerOrder = $lastId->id + 1;
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
            $uniqueId = 'RSUSE'.$uId;

        // *********************** End Default Store Dispaly Id ******************

            $village = Villages::where('vil_id',$request->use_village_id)->first();

            if($request->file('use_image'))
            {
                $fileLink = str_random(40);
                $images = $request->file('use_image');
                $imagesname = str_replace(' ', '-',$fileLink.'users.'. $images->getClientOriginalExtension());
                $images->move(public_path('assets/img/users/'),$imagesname);

            }else{
               $imagesname = '';
            }

            $insertData = new User;
            $insertData['use_unique_id'] = $uniqueId;
            $insertData['email'] = '';
            $insertData['use_full_name'] = $request->use_full_name;
            $insertData['use_shop_name'] = '';
            $insertData['use_shop_address'] = '';
            $insertData['use_village_id'] = $request->use_village_id;
            $insertData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
            $insertData['use_taluka'] = $request->use_taluka;
            $insertData['use_pincode'] = $request->use_pincode ? $request->use_pincode:0;
            $insertData['use_phone_no'] = $request->use_phone_no;
            $insertData['use_alt_mobile_number'] = $request->use_alt_mobile_number ? $request->use_alt_mobile_number:'';
            $insertData['use_seller_order'] = 0;
            $insertData['use_user_order'] = 0;
            $insertData['email_verified_at'] = date('Y-m-d H:i:s');
            $insertData['password'] = bcrypt('123456');
            $insertData['use_token'] = $id.str_random(80);
            $insertData['remember_token'] = $id.str_random(80);
            $insertData['use_fcm_token'] = $id.str_random(80);
            $insertData['use_role'] = 3; // User
            $insertData['use_image'] = $imagesname;
            $insertData['use_status'] = 0;
            $insertData['use_otp_code'] = 0;
            $insertData['created_at'] = date('Y-m-d H:i:s');
            $insertData['updated_at'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'User is created!');
                return redirect()->intended('/users');
            }else{
                Session::flash('error', "User isn't created!");
                return redirect()->intended('/users');
            }
            
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'use_village_id' => 'required',
        'use_full_name' => 'required',
        'use_taluka' => 'required',
        'use_phone_no' => 'required|numeric',
        'use_pincode' => 'required|numeric',
        'use_alt_mobile_number' => 'numeric',
        'use_image' => 'image|mimes:jpeg,png,jpg|max:3048',
        ]);     
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $this->validateUpdate($request);
        try
        {  
            $village = Villages::where('vil_id',$request->use_village_id)->first();

            if($request->file('use_image'))
            {
                $fileLink = str_random(40);
                $images = $request->file('use_image');
                $imagesname = str_replace(' ', '-',$fileLink.'users.'. $images->getClientOriginalExtension());
                $images->move(public_path('assets/img/users/'),$imagesname);

            }else{
                $selectImages = User::where('use_unique_id',$request->use_unique_id)->select(['use_image'])->first();
                $imagesname = $selectImages->use_image; 
            }

            $updateData['use_full_name'] = $request->use_full_name;
            $updateData['use_village_id'] = $request->use_village_id;
            $updateData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
            $updateData['use_taluka'] = $request->use_taluka;
            $updateData['use_pincode'] = $request->use_pincode ? $request->use_pincode:0;
            $updateData['use_phone_no'] = $request->use_phone_no;
            $updateData['use_alt_mobile_number'] = $request->use_alt_mobile_number ? $request->use_alt_mobile_number:'';
            $updateData['use_image'] = $imagesname;
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            $infoUpdate = User::where('use_unique_id',$request->use_unique_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'User detail updated!');
                return redirect()->intended('/users');
            }else{
                Session::flash('error', "User detail isn't updated!");
                return redirect()->intended('/users');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

    public function updateProfile(Request $request)
    {
        $this->validateUpdate($request);
        try
        {  
           
            $village = Villages::where('vil_id',$request->use_village_id)->first();

            if($request->file('use_image'))
            {
                $fileLink = str_random(40);
                $images = $request->file('use_image');
                $imagesname = str_replace(' ', '-',$fileLink.'users.'. $images->getClientOriginalExtension());
                $images->move(public_path('assets/img/users/'),$imagesname);

            }else{
                $selectImages = User::where('use_unique_id',$request->use_unique_id)->select(['use_image'])->first();
                $imagesname = $selectImages->use_image; 
            }

            $updateData['use_full_name'] = $request->use_full_name;
            $updateData['use_village_id'] = $request->use_village_id;
            $updateData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
            $updateData['use_taluka'] = $request->use_taluka;
            $updateData['use_pincode'] = $request->use_pincode ? $request->use_pincode:0;
            $updateData['use_phone_no'] = $request->use_phone_no;
            $updateData['use_alt_mobile_number'] = $request->use_alt_mobile_number ? $request->use_alt_mobile_number:'';
            $updateData['use_image'] = $imagesname;
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            $infoUpdate = User::where('use_unique_id',$request->use_unique_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'User detail updated!');
                return redirect()->intended('/user-profile');
            }else{
                Session::flash('error', "User detail isn't updated!");
                return redirect()->intended('/user-profile');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'use_village_id' => 'required',
        'use_full_name' => 'required',
        'use_taluka' => 'required',
        'use_phone_no' => 'required|numeric',
        'use_pincode' => 'required|numeric',
        'use_image' => 'image|mimes:jpeg,png,jpg|max:3048',
        ]);     
    }

    // To delete record..
    public function destroy($id)
    { 
        if(User::where('use_unique_id',$id)->exists())
        {
            User::where('use_unique_id',$id)->delete();
            Session::flash('success', 'User is deleted!');
            return redirect()->intended('/users');
        }else{
          Session::flash('error', "User isn't deleted!");
          return redirect()->intended('/users');
        }
    }

    public function updatepassword(Request $request)
    {
        $this->validatePassword($request);

        $oldPassword = $request->old_password;

        if(User::where('use_unique_id',$request->use_unique_id))
        {
            $usersData['password'] = bcrypt($request['password']);
            $usersData['updated_at'] = date('Y-m-d H:i:s');
            $update = User::where('use_unique_id',$request->use_unique_id)->update($usersData);
            if($update)
            {
                Session::flash('success', 'Password reset SuccessFully!');
                return redirect('user-profile');
            }else{
                return redirect('user-profile')->with('User Password Updation Fail');
            }
        }
    }

    private function validatePassword($request)
    {
        $this->validate($request, [
        'password' => 'required|min:5|confirmed',
        ]);    
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = User::where('id',$request->id)->update(array('use_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = User::where('id',$request->id)->update(array('use_status' => 1));
                 $data['status'] = "false";
                return $data;
            }

        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }
    
    // To export record in excel file..
    public function exportExcel()
    {
        return Excel::download(new PreChoreesExport, 'villages.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = User::where('vil_name','<>','')->orderBy('id','ASC')->get();
        $pdf = PDF::loadView('users-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('villages-'.$todayDate.'.pdf');
    }
}
