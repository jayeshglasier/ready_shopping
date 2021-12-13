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

class DeliveryBoysController extends Controller
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
                $data['datarecords'] = User::orderBy('id',$pageOrder)->where('use_role',4)->where('use_full_name','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = User::where('use_role',4)->where('use_full_name','<>','')->orderBy('id',$pageOrder)->paginate($pages);
            }
            return view('delivery-boys-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {   
        $data['villages'] = Villages::where('vil_status',0)->orderBy('vil_name','ASC')->get();
        return view('delivery-boys-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['villages'] = Villages::where('vil_status',0)->orderBy('vil_name','ASC')->get();
        $data['editData'] = User::where('id',$id)->first();
        return view('delivery-boys-mgmt.edit',$data);
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
            if(User::where('use_full_name',$request->use_full_name)->exists())
            {
                Session::flash('error', 'Delivery boy already exists!');
                return redirect()->intended('/create-delivery-boys');
            }
            // *********************** Begin Default Store Dispaly Id ***********************
            // Display_id Function
            $lastId = User::select('id','use_seller_order')->where('use_role',4)->orderBy('id','DESC')->limit(1)->first();
            
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
            $uniqueId = 'RSDB'.$uId;

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
            $insertData['use_shop_name'] = $request->use_shop_name;
            $insertData['use_shop_address'] = $request->use_shop_address ? $request->use_shop_address:'';
            $insertData['use_village_id'] = $request->use_village_id;
            $insertData['use_village_name'] = $village->vil_name ? $village->vil_name:'';
            $insertData['use_taluka'] = $request->use_taluka;
            $insertData['use_pincode'] = $request->use_pincode ? $request->use_pincode:0;
            $insertData['use_phone_no'] = $request->use_phone_no;
            $insertData['use_alt_mobile_number'] = $request->use_alt_mobile_number ? $request->use_alt_mobile_number:'';
            $insertData['use_seller_order'] = $sellerOrder;
            $insertData['use_user_order'] = 0;
            $insertData['email_verified_at'] = date('Y-m-d H:i:s');
            $insertData['password'] = bcrypt('123456');
            $insertData['use_token'] = str_random(80).$id;
            $insertData['remember_token'] = str_random(80).$id;
            $insertData['use_fcm_token'] = str_random(80).$id;
            $insertData['use_role'] = 4; // Delivery Boy
            $insertData['use_image'] = $imagesname;
            $insertData['use_status'] = 0;
            $insertData['use_otp_code'] = 0;
            $insertData['created_at'] = date('Y-m-d H:i:s');
            $insertData['updated_at'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Delivery boy is created!');
                return redirect()->intended('/delivery-boys');
            }else{
                Session::flash('error', "Delivery boy isn't created!");
                return redirect()->intended('/delivery-boys');
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
        'use_shop_name' => 'required',
        'use_taluka' => 'required',
        'use_phone_no' => 'required|numeric',
        'use_pincode' => 'required|numeric',
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

            $village = Villages::where('vil_id',$request->use_village_id)->first();

            $updateData['use_full_name'] = $request->use_full_name;
            $updateData['use_shop_name'] = $request->use_shop_name;
            $updateData['use_shop_address'] = $request->use_shop_address ? $request->use_shop_address:'';
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
                Session::flash('success', 'Delivery boy updated!');
                return redirect()->intended('/delivery-boys');
            }else{
                Session::flash('error', "Delivery boy isn't updated!");
                return redirect()->intended('/delivery-boys');
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
        'use_shop_name' => 'required',
        'use_taluka' => 'required',
        'use_phone_no' => 'required|numeric',
        'use_pincode' => 'required|numeric',
        'use_image' => 'image|mimes:jpeg,png,jpg|max:3048',
        ]);    
    }

    // To delete record..
    public function destroy($id)
    { 
        if(User::where('id',$id)->exists())
        {
            User::where('id',$id)->delete();
            Session::flash('success', 'Delivery boy is deleted!');
            return redirect()->intended('/delivery-boys');
        }else{
          Session::flash('error', "Delivery boy isn't deleted!");
          return redirect()->intended('/delivery-boys');
        }
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
        return Excel::download(new PreChoreesExport, 'Delivery-boy.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = User::where('use_full_name','<>','')->orderBy('id','ASC')->get();
        $pdf = PDF::loadView('delivery-boys-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('Delivery-boy-'.$todayDate.'.pdf');
    }
}
