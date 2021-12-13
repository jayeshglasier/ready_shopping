<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Villages;
use App\Model\SellerBankDetail;
use App\User;
use Auth;
use Session;
use Input;
use PDF;

class SelBankAccountController extends Controller
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
                $data['sortBy'] = "sbd_id";
                $pageAsc_Desc = "sbd_id";
            }

            if($search)
            {   
                $data['datarecords'] = SellerBankDetail::orderBy('sbd_id',$pageOrder)->where('sbd_holder_name','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = SellerBankDetail::join('users','tbl_seller_bank_details.sbd_seller_id','=','users.id')->orderBy('sbd_id',$pageOrder)->paginate($pages);
            }
            return view('sellers-bank-account-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {   
        $data['sellers'] = User::where('use_role',2)->where('use_full_name','<>','')->where('use_status',0)->orderBy('use_full_name','ASC')->get();
        return view('sellers-bank-account-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
       $data['sellers'] = User::where('use_role',2)->where('use_full_name','<>','')->where('use_status',0)->orderBy('use_full_name','ASC')->get();
        $data['editData'] = SellerBankDetail::where('sbd_id',$id)->first();
        return view('sellers-bank-account-mgmt.edit',$data);
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
            if(SellerBankDetail::where('sbd_seller_id',$request->sbd_seller_id)->where('sbd_account_number',$request->sbd_account_number)->exists())
            {
                Session::flash('error', 'Seller bank detail already exists!');
                return redirect()->intended('/create-sellers-bank-accounts');
            }
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
            $insertData['sbd_seller_id'] = $request->sbd_seller_id;
            $insertData['sbd_holder_name'] = $request->sbd_holder_name;
            $insertData['sbd_account_number'] = $request->sbd_account_number;
            $insertData['sbd_bank_name'] = $request->sbd_bank_name;
            $insertData['sbd_iafc_code'] = $request->sbd_iafc_code;
            $insertData['sbd_branch'] = $request->sbd_branch;
            $insertData['sbd_adhar_number'] = $request->sbd_adhar_number ? $request->sbd_adhar_number:'';
            $insertData['sbd_pan_number'] = $request->sbd_pan_number ? $request->sbd_pan_number:'';
            $insertData['sbd_status'] = 0;
            $insertData['sbd_createat'] = date('Y-m-d H:i:s');
            $insertData['sbd_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Seller bank detail is created!');
                return redirect()->intended('/sellers-bank-accounts');
            }else{
                Session::flash('error', "Seller bank detail isn't created!");
                return redirect()->intended('/sellers-bank-accounts');
            }
            
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'sbd_seller_id' => 'required',
        'sbd_holder_name' => 'required',
        'sbd_account_number' => 'required',
        'sbd_bank_name' => 'required',
        'sbd_iafc_code' => 'required',
        'sbd_branch' => 'required',
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
            $updateData['sbd_seller_id'] = $request->sbd_seller_id;
            $updateData['sbd_holder_name'] = $request->sbd_holder_name;
            $updateData['sbd_account_number'] = $request->sbd_account_number;
            $updateData['sbd_bank_name'] = $request->sbd_bank_name;
            $updateData['sbd_iafc_code'] = $request->sbd_iafc_code;
            $updateData['sbd_branch'] = $request->sbd_branch;
            $updateData['sbd_adhar_number'] = $request->sbd_adhar_number ? $request->sbd_adhar_number:'';
            $updateData['sbd_pan_number'] = $request->sbd_pan_number ? $request->sbd_pan_number:'';
            $updateData['sbd_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = SellerBankDetail::where('sbd_unique_id',$request->sbd_unique_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Seller bank detail updated!');
                return redirect()->intended('/sellers-bank-accounts');
            }else{
                Session::flash('error', "Seller bank detail isn't updated!");
                return redirect()->intended('/sellers-bank-accounts');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'sbd_seller_id' => 'required',
        'sbd_holder_name' => 'required',
        'sbd_account_number' => 'required',
        'sbd_bank_name' => 'required',
        'sbd_iafc_code' => 'required',
        'sbd_branch' => 'required',
        ]);    
    }

    // To delete record..
    public function destroy($id)
    { 
        if(SellerBankDetail::where('sbd_unique_id',$id)->exists())
        {
            SellerBankDetail::where('sbd_unique_id',$id)->delete();
            Session::flash('success', 'Seller bank detail is deleted!');
            return redirect()->intended('/sellers-bank-accounts');
        }else{
          Session::flash('error', "Seller bank detail isn't deleted!");
          return redirect()->intended('/sellers-bank-accounts');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = SellerBankDetail::where('sbd_id',$request->sbd_id)->update(array('sbd_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = SellerBankDetail::where('sbd_id',$request->sbd_id)->update(array('sbd_status' => 1));
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
        $data['datarecords'] = User::where('use_full_name','<>','')->orderBy('id','ASC')->get();
        $pdf = PDF::loadView('sellers-bank-account-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('villages-'.$todayDate.'.pdf');
    }
}
