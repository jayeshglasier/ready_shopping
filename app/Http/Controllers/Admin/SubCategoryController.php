<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\SubCategory;
use App\Model\ProductCategory;
use App\Model\Category;
use App\Model\MainCategorys;
use Auth;
use Session;
use Input;
use PDF;

class SubCategoryController extends Controller
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
                $data['sortBy'] = "sub_id";
                $pageAsc_Desc = "sub_id";
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
                $data['datarecords'] = SubCategory::join('tbl_categorys','tbl_sub_categorys.sub_cat_id','=','tbl_categorys.cat_id')->where('sub_cat_name','like','%'.$search.'%')->orderBy('cat_name',$pageOrder)->orderBy('sub_cat_name',$pageOrder)->paginate($pages);
            }else{
                $data['datarecords'] = SubCategory::join('tbl_categorys','tbl_sub_categorys.sub_cat_id','=','tbl_categorys.cat_id')->where('sub_main_cat_id',$categoryId)->where('sub_cat_name','<>','')->orderBy('cat_name',$pageOrder)->orderBy('sub_cat_name',$pageOrder)->paginate($pages);
            }

            return view('admin.product.sub-category-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {   
        $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();
        return view('admin.product.sub-category-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['mainCategorys'] = MainCategorys::where('mac_status',0)->get();
        $data['editData'] = SubCategory::where('sub_unique_id',$id)->first();
        $categoryId = SubCategory::where('sub_unique_id',$id)->first();
        $data['categorysList'] = Category::select('cat_id','cat_name')->where('cat_main_id',$categoryId->sub_main_cat_id)->get();
        return view('admin.product.sub-category-mgmt.edit',$data);
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
            if(SubCategory::where('sub_cat_id',$request->sub_cat_id)->where('sub_cat_name',$request->sub_cat_name)->exists())
            {
                return back()->withError("Sub category already exists!")->withInput();
            }

            if($request->file('sub_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('sub_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'category'. $images->getClientOriginalName());
                $images->move(public_path('assets/img/sub-category/'),$imagesname);
            }else{
               $imagesname = 'default-category.jpg';   
            }


            $uniqueId = str_random(25).'-'.date("Y");
            $insertData = new SubCategory;
            $insertData['sub_unique_id'] = $uniqueId;
            $insertData['sub_main_cat_id'] = $request->sub_main_cat_id;
            $insertData['sub_cat_id'] = $request->sub_cat_id;
            $insertData['sub_cat_name'] = $request->sub_cat_name;
            $insertData['sub_picture'] = $imagesname;
            $insertData['sub_status'] = 0;
            $insertData['sub_createat'] = date('Y-m-d H:i:s');
            $insertData['sub_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Subcategory name created!');
                return redirect()->intended('/sub-category?search=&page=&category='.$request->sub_main_cat_id.'&asc_desc_filter=DESC&pagefilter=10');
            }else{
                return back()->withError("Subcategory isn't created!")->withInput();
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
        'sub_main_cat_id' => 'required',
        'sub_cat_id' => 'required',
        'sub_cat_name' => 'required|max:150',
        'sub_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
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
            if($request->file('sub_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('sub_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'category'. $images->getClientOriginalName());
                $images->move(public_path('assets/img/sub-category/'),$imagesname);
            }else{
                $selectImages = SubCategory::where('sub_id',$request->sub_id)->select(['sub_picture'])->first();
                $imagesname = $selectImages->sub_picture;
               
            }

            $updateData['sub_main_cat_id'] = $request->sub_main_cat_id;
            $updateData['sub_cat_id'] = $request->sub_cat_id;
            $updateData['sub_cat_name'] = $request->sub_cat_name;
            $updateData['sub_picture'] = $imagesname;
            $updateData['sub_status'] = 0;
            $updateData['sub_createat'] = date('Y-m-d H:i:s');
            $updateData['sub_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = SubCategory::where('sub_id',$request->sub_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Subcategory name updated!');
                return redirect()->intended('/sub-category?search=&page=&category='.$request->sub_main_cat_id.'&asc_desc_filter=DESC&pagefilter=10');
            }else{
                Exceptions::exception($e);
                return back()->withError(substr($e->getMessage(),1,200))->withInput();
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'sub_main_cat_id' => 'required',
        'sub_cat_id' => 'required',
        'sub_cat_name' => 'required|max:150',
        'sub_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);  
    }

    // To delete record..
    public function destroy($id)
    { 
        if(SubCategory::where('sub_unique_id',$id)->exists())
        {
            $subMainId = SubCategory::select('sub_main_cat_id')->where('sub_unique_id',$id)->first();
            SubCategory::where('sub_unique_id',$id)->delete();

            Session::flash('success', 'Subcategory name deleted!');
            return redirect()->intended('/sub-category?search=&page=&category='.$subMainId->sub_main_cat_id.'&asc_desc_filter=DESC&pagefilter=10');
        }else{
          Session::flash('error', "Subcategory name isn't deleted!");
          return redirect()->intended('/sub-category');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = SubCategory::where('sub_id',$request->sub_id)->update(array('sub_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = SubCategory::where('sub_id',$request->sub_id)->update(array('sub_status' => 1));
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
        return Excel::download(new PreChoreesExport, 'sub-category.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = SubCategory::where('sub_cat_name','<>','')->orderBy('sub_id','ASC')->get();
        $pdf = PDF::loadView('admin.product.sub-category-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('sub-category-'.$todayDate.'.pdf');
    }
}
