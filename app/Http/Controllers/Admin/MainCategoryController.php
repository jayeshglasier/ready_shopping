<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Category;
use App\Model\MainCategorys;
use Auth;
use Session;
use Input;
use PDF;

class MainCategoryController extends Controller
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
                $data['sortBy'] = "mac_id";
                $pageAsc_Desc = "mac_id";
            }

            $category = Input::get('category');
            if($category)
            {
                $data['categoryId'] = Input::get('category');
                $categoryId = Input::get('category');
            }else{
                $data['categoryId'] = 1;
                $categoryId = 1;
            }


            $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();

            if($search)
            {   
                $data['datarecords'] = MainCategorys::join('tbl_main_categorys','tbl_categorys.cat_main_id','=','tbl_main_categorys.mac_id')->where('cat_name','like','%'.$search.'%')->orderBy('mac_id',$pageOrder)->orderBy('mac_id',$pageOrder)->paginate($pages);
            }else{
                $data['datarecords'] = MainCategorys::orderBy('mac_id',$pageOrder)->paginate($pages);
            }
            return view('admin.product.main-category-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {
        $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();
        return view('admin.product.main-category-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['editData'] = MainCategorys::where('mac_id',$id)->first();
        return view('admin.product.main-category-mgmt.edit',$data);
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
            if(MainCategorys::where('mac_title',$request->mac_title)->exists())
            {
                return back()->withError("Main category already exists!")->withInput();
            }

            $insertData = new MainCategorys;
            $insertData['mac_title'] = $request->mac_title;
            $insertData['mac_description'] = $request->mac_description;
            $insertData['mac_type'] = null;
            $insertData['mac_prefix'] = null;
            $insertData['mac_status'] = 0;
            $insertData['mac_createat'] = date('Y-m-d H:i:s');
            $insertData['mac_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Main category created!');
                return redirect()->intended('main-category');
            }else{
                return back()->withError("Main category isn't created!")->withInput();
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
        'mac_title' => 'required',
        'mac_description' => 'required',
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
            $updateData['mac_title'] = $request->mac_title;
            $updateData['mac_description'] = $request->mac_description;
            $updateData['mac_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = MainCategorys::where('mac_id',$request->mac_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Main category updated!');
                return redirect()->intended('main-category');
            }else{
                return back()->withError("Main category isn't updated!")->withInput();
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
                $checkStatus = MainCategorys::where('mac_id',$request->mac_id)->update(array('mac_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = MainCategorys::where('mac_id',$request->mac_id)->update(array('mac_status' => 1));
                 $data['status'] = "false";
                return $data;
            }

        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }
}
