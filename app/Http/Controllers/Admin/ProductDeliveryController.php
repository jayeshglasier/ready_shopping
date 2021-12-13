<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Villages;
use Auth;
use Session;
use Input;
use PDF;

class ProductDeliveryController extends Controller
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
                $data['sortBy'] = "vil_id";
                $pageAsc_Desc = "vil_id";
            }

            if($search)
            {   
                $data['datarecords'] = Villages::orderBy('vil_id',$pageOrder)->where('vil_name','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = Villages::where('vil_name','<>','')->orderBy('vil_id',$pageOrder)->paginate($pages);
            }
            return view('admin.village-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {
        return view('admin.village-mgmt.create');
    }

    // Update Form...
    public function edit($id)
    {
        $data['editData'] = Villages::where('vil_id',$id)->first();
        return view('admin.village-mgmt.edit',$data);
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
        try
        {  
            $this->validateStore($request);

            if(Villages::where('vil_name',$request->vil_name)->exists())
            {
                Session::flash('error', 'Village name already exists!');
                return redirect()->intended('/create-villages');
            }
            $uniqueId = str_random(15).date("Ymd");
            $insertData = new Villages;
            $insertData['vil_unique_id'] = $uniqueId;
            $insertData['vil_name'] = $request->vil_name;
            $insertData['vil_status'] = 0;
            $insertData['vil_createat'] = date('Y-m-d H:i:s');
            $insertData['vil_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Village name created!');
                return redirect()->intended('/villages');
            }else{
                Session::flash('error', "Village name isn't created!");
                return redirect()->intended('/villages');
            }
            
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'vil_name' => 'required|max:150',
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
        try
        {  
            $this->validateUpdate($request);
            $updateData['vil_name'] = $request->vil_name;
            $updateData['vil_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = Villages::where('vil_id',$request->vil_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Village name updated!');
                return redirect()->intended('/villages');
            }else{
                Session::flash('error', "Village name isn't updated!");
                return redirect()->intended('/villages');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'vil_name' => 'required|max:200',
        ]);   
    }

    // To delete record..
    public function destroy($id)
    { 
        if(Villages::where('vil_id',$id)->exists())
        {
            Villages::where('vil_id',$id)->delete();
            Session::flash('success', 'Village name deleted!');
            return redirect()->intended('/villages');
        }else{
          Session::flash('error', "Village name isn't deleted!");
          return redirect()->intended('/villages');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = Villages::where('vil_id',$request->vil_id)->update(array('vil_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = Villages::where('vil_id',$request->vil_id)->update(array('vil_status' => 1));
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
        $data['datarecords'] = Villages::where('vil_name','<>','')->orderBy('vil_id','ASC')->get();
        $pdf = PDF::loadView('admin.village-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('villages-'.$todayDate.'.pdf');
    }
}
