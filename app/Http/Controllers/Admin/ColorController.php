<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Category;
use App\Model\Colors;
use Auth;
use Session;
use Input;
use PDF;

class ColorController extends Controller
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
                $data['pages'] = 50;
                $pages = 50;
            }

            $pageOrderBy = Input::get('asc_desc_filter');
            if($pageOrderBy)
            {
                $data['pageOrder'] = Input::get('asc_desc_filter');
                $pageOrder = Input::get('asc_desc_filter');
            }else{
                $data['pageOrder'] = "ASC";
                $pageOrder = "ASC";
            }

            $pageOrderBySelect = Input::get('sort_by');
            if($pageOrderBySelect)
            {
                $data['sortBy'] = Input::get('sort_by');
                $pageAsc_Desc = Input::get('sort_by');
            }else{
                $data['sortBy'] = "col_id";
                $pageAsc_Desc = "col_id";
            }

            

            $data['color'] = Colors::where('col_status',0)->get();

            if($search)
            {   
                $data['datarecords'] = Colors::where('col_name','like','%'.$search.'%')->orderBy('col_id',$pageOrder)->orderBy('col_id',$pageOrder)->paginate($pages);
            }else{
                $data['datarecords'] = Colors::orderBy('col_id',$pageOrder)->paginate($pages);
            }
            return view('admin.product.color-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {
        
        return view('admin.product.color-mgmt.create');
    }

    // Update Form...
    public function edit($id)
    {
        $data['editData'] = Colors::where('col_id',$id)->first();
        return view('admin.product.color-mgmt.edit',$data);
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
            if(Colors::where('col_name',$request->col_name)->exists())
            {
                return back()->withError("Color already exists!")->withInput();
            }

            $insertData = new Colors;
            $insertData['col_name'] = $request->col_name;            
            $insertData['col_status'] = 0;
            $insertData['col_createat'] = date('Y-m-d H:i:s');
            $insertData['col_updateat'] = date('Y-m-d H:i:s');            
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Color created!');
                return redirect()->intended('color');
            }else{
                return back()->withError("Color isn't created!")->withInput();
            }
            
        }catch (\Exception $e) {
            Exceptions::exception($e);
            return back()->withError(substr($e->getMessage(),1,200))->withInput();
        }
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'col_name' => 'required'        
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
        $this->validateStore($request);
        try
        {   
            $updateData['col_name'] = $request->col_name;            
            $updateData['col_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = Colors::where('col_id',$request->col_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Color updated!');
                return redirect()->intended('color');
            }else{
                return back()->withError("Color isn't updated!")->withInput();
            }
            
        }catch (\Exception $e) {
            Exceptions::exception($e);
            return back()->withError(substr($e->getMessage(),1,200))->withInput();
        }
    }


    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = Colors::where('col_id',$request->col_id)->update(array('col_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = Colors::where('col_id',$request->col_id)->update(array('col_status' => 1));
                 $data['status'] = "false";
                return $data;
            }

        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }
}
