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

class CategoryController extends Controller
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
                $data['pageOrder'] = "ASC";
                $pageOrder = "ASC";
            }

            $pageOrderBySelect = Input::get('sort_by');
            if($pageOrderBySelect)
            {
                $data['sortBy'] = Input::get('sort_by');
                $pageAsc_Desc = Input::get('sort_by');
            }else{
                $data['sortBy'] = "cat_id";
                $pageAsc_Desc = "cat_id";
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
                $data['datarecords'] = Category::join('tbl_main_categorys','tbl_categorys.cat_main_id','=','tbl_main_categorys.mac_id')->where('cat_name','like','%'.$search.'%')->orderBy('cat_name',$pageOrder)->orderBy('cat_id',$pageOrder)->paginate($pages);
            }else{
                $data['datarecords'] = Category::join('tbl_main_categorys','tbl_categorys.cat_main_id','=','tbl_main_categorys.mac_id')->where('cat_main_id',$categoryId)->where('cat_name','<>','')->orderBy('cat_name',$pageOrder)->orderBy('cat_id',$pageOrder)->paginate($pages);
            }
            return view('admin.product.category-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {
        $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();
        return view('admin.product.category-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();
        $data['editData'] = Category::where('cat_unique_id',$id)->first();
        return view('admin.product.category-mgmt.edit',$data);
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
            if(Category::where('cat_main_id',$request->cat_main_id)->where('cat_name',$request->cat_name)->exists())
            {
                return back()->withError("Category already exists!!")->withInput();
            }

            if($request->file('cat_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('cat_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'category'. $images->getClientOriginalName());
                $images->move(public_path('assets/img/category/'),$imagesname);
            }else{
               $imagesname = 'default-category.jpg';   
            }

            $mainTypes = MainCategorys::where('mac_id',$request->cat_main_id)->first();

            $uniqueId = str_random(35).'-'.date("Y");
            $insertData = new Category;
            $insertData['cat_unique_id'] = $uniqueId;
            $insertData['cat_main_id'] = $request->cat_main_id;
            $insertData['cat_name'] = $request->cat_name;
            $insertData['cat_type'] = $mainTypes->mac_type;
            $insertData['cat_picture'] = $imagesname;
            $insertData['cat_status'] = 0;
            $insertData['cat_createat'] = date('Y-m-d H:i:s');
            $insertData['cat_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                $data['categoryId'] = 2;
                Session::flash('success', 'Category created!');
                return redirect()->intended('/category?search=&page=&category='.$request->cat_main_id.'&asc_desc_filter=DESC&pagefilter=10');
            }else{
                return back()->withError("Category isn't created!")->withInput();
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
        'cat_main_id' => 'required',
        'cat_name' => 'required|max:150',
        'cat_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
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
            if($request->file('cat_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('cat_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'category'. $images->getClientOriginalName());
                $images->move(public_path('assets/img/category/'),$imagesname);
            }else{
               $selectImages = Category::where('cat_id',$request->cat_id)->select(['cat_picture'])->first();
                $imagesname = $selectImages->cat_picture;   
            }

            $mainTypes = MainCategorys::where('mac_id',$request->cat_main_id)->first();

            $updateData['cat_main_id'] = $request->cat_main_id;
            $updateData['cat_name'] = $request->cat_name;
            $updateData['cat_type'] = $mainTypes->mac_type;
            $updateData['cat_picture'] = $imagesname;
            $updateData['cat_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = Category::where('cat_id',$request->cat_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Category updated!');
                return redirect()->intended('/category?search=&page=&category='.$request->cat_main_id.'&asc_desc_filter=DESC&pagefilter=10');
            }else{
                return back()->withError("Category isn't updated!")->withInput();
            }
            
        }catch (\Exception $e) {
            Exceptions::exception($e);
            return back()->withError(substr($e->getMessage(),1,200))->withInput();
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
       $this->validate($request, [
        'cat_main_id' => 'required',
        'cat_name' => 'required|max:150',
        'cat_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);   
    }

    // To delete record..
    public function destroy($id)
    { 
        if(Category::where('cat_unique_id',$id)->exists())
        {
            Category::where('cat_unique_id',$id)->delete();
            Session::flash('success', 'Record is deleted!');
            return redirect()->intended('/category');
        }else{
          Session::flash('error', "Record isn't deleted!");
          return redirect()->intended('/category');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = Category::where('cat_id',$request->cat_id)->update(array('cat_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = Category::where('cat_id',$request->cat_id)->update(array('cat_status' => 1));
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
        return Excel::download(new PreChoreesExport, 'category.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = Category::where('cat_name','<>','')->orderBy('cat_id','ASC')->get();
        $pdf = PDF::loadView('admin.product.category-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('category-'.$todayDate.'.pdf');
    }
}
