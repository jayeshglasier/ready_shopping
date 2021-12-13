<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Products;
use App\Model\ProductImages;
use App\Model\ChooseType;
use App\Model\MainCategorys;
use App\Model\Category;
use App\Model\Colors;
use App\Model\SubCategory;
use Auth;
use Session;
use Input;
use PDF;

class MobilesCoversController extends Controller
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
                $data['sortBy'] = "pod_id";
                $pageAsc_Desc = "pod_id";
            }

            if($search)
            {   
                $data['datarecords'] = Products::orderBy('pod_id',$pageOrder)->where('pod_main_cat_id',12)->where('pod_pro_name','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = Products::join('tbl_categorys','tbl_products.pod_cat_id','=','tbl_categorys.cat_id')->leftjoin('tbl_sub_categorys','tbl_products.pod_sub_cat_id','=','tbl_sub_categorys.sub_id')->where('pod_main_cat_id',12)->where('pod_seller_id',0)->orderBy('pod_id',$pageOrder)->paginate($pages);
            }
            return view('admin.shop.mobiles-covers-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {
        $data['categorys'] = Category::where('cat_main_id',12)->where('cat_name','<>','')->orderBy('cat_name','ASC')->get();

        $data['colors'] = Colors::where('col_status',0)->orderBy('col_name','ASC')->get();
        $data['choosetype'] = ChooseType::select('coo_id','coo_name')->where('coo_name','<>','')->orderBy('coo_id','ASC')->get();
        return view('admin.shop.mobiles-covers-mgmt.create',$data);
    }

    // Update Form...
    public function edit($id)
    {
        $data['categorys'] = Category::where('cat_name','<>','')->orderBy('cat_name','ASC')->get();
        $data['colors'] = Colors::where('col_status',0)->orderBy('col_name','ASC')->get();
        $data['choosetype'] = ChooseType::select('coo_id','coo_name')->where('coo_name','<>','')->orderBy('coo_id','ASC')->get();
        $productDetails = Products::where('pod_unique_id',$id)->first();
        $data['categorysList'] = Category::select('cat_id','cat_name')->where('cat_main_id',$productDetails->pod_main_cat_id)->get();
        $data['subCategorysList'] = SubCategory::select('sub_id','sub_cat_name')->where('sub_cat_id',$productDetails->pod_cat_id)->get();
        $data['editData'] = Products::where('pod_unique_id',$id)->first();
        return view('admin.shop.mobiles-covers-mgmt.edit',$data);
    }

     // View Page...
    public function view($id)
    {
        $data['viewdata'] = Products::where('pod_unique_id',$id)->first();
        return view('admin.shop.mobiles-covers-mgmt.view',$data);
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
            if(Products::where('pod_pro_name',$request->pod_pro_name)->exists())
            {
                Session::flash('error', 'Products already exists!');
                return redirect()->intended('/create-products');
            }

            if($request->file('pod_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('pod_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'products.'. $images->getClientOriginalExtension());
                $images->move(public_path('assets/img/products/'),$imagesname);

            }else{
               $imagesname = '';
            }

            $addImages = $request->file('pod_other_picture');
        
            if($addImages){
                foreach($addImages as $file){
                    $fileLink = str_random(40);
                    $filename = $fileLink.date('-YmdHis') . "." . $file->getClientOriginalExtension();
                    $picture[] = $filename;
                    $file->move(public_path('assets/img/products/'), str_replace(' ', '-',$filename));
                }
            }else{
                $picture = "";
            }

            $lastId = Products::select('pod_id')->orderBy('pod_id','DESC')->limit(1)->first();
            
            if($lastId)
            {
                $id = $lastId->pod_id;
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
            $products_Id = 'PROD'.$uId;

            $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
            $uniqueId = substr(str_shuffle($permitted_chars), 0, 25);

            $insertData = new Products;
            $insertData['pod_unique_id'] = $id.'-'.$uniqueId;
            $insertData['pod_pro_id'] = $products_Id;
            $insertData['pod_pro_name'] = $request->pod_pro_name;
            $insertData['pod_brand_name'] = $request->pod_brand_name;
            $insertData['pod_main_cat_id'] = 12 ;
            $insertData['pod_cat_id'] = $request->pod_cat_id;
            $insertData['pod_sub_cat_id'] = $request->pod_sub_cat_id;
            $insertData['pod_pro_description'] = $request->pod_pro_description;
            $insertData['pod_price'] = $request->pod_price;
            $insertData['pod_offer_price'] = $request->pod_offer_price ? $request->pod_offer_price:0.0;
            $insertData['pod_quantity'] = $request->pod_quantity ? $request->pod_quantity:1;
            $insertData['pod_stock'] = $request->pod_quantity ? $request->pod_quantity:1;
            $insertData['pod_return_policy'] = $request->pod_return_policy ? $request->pod_return_policy:'';
            $insertData['pod_made_in'] = $request->pod_made_in ? $request->pod_made_in:'India';
            $insertData['pod_colour'] = $request->pod_colour ? implode(",", $request->pod_colour):'';
            $insertData['pod_size'] = $request->pod_size ? $request->pod_size:'';
            $insertData['pod_ord_within'] = $request->pod_ord_within ? $request->pod_ord_within:'';
            $insertData['pod_picture'] = $imagesname;
            $insertData['pod_deal_of_day'] = $request->pod_deal_of_day ? $request->pod_deal_of_day:0; //    0 = No , 1 = Yes
            $insertData['pod_choose_type'] = $request->pod_choose_type ? $request->pod_choose_type:1; //    1 = New , 2 = Ads 3 = Old
            $insertData['pod_status'] = 0;
            $insertData['pod_seller_id'] = 0;
            $insertData['pod_village_id'] = 0;
            $insertData['pod_createat'] = date('Y-m-d H:i:s');
            $insertData['pod_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            $lastId = Products::orderBy('pod_id','DESC')->limit(1)->first();

            $subData = new ProductImages;
            $subData->pri_product_id = $lastId->pod_id;
            $subData->pri_image_name = $imagesname;
            $subData->pri_status = 0;
            $subData->pri_createat = date('Y-m-d H:i:s');
            $subData->pri_updateat = date('Y-m-d H:i:s');
            $subData->save();

            if($picture)
            {
                foreach ($picture as $key => $value){

                $subinsertData = new ProductImages;
                $subinsertData->pri_product_id = $lastId->pod_id;
                $subinsertData->pri_image_name = str_replace(' ', '',$value);
                $subinsertData->pri_status = 0;
                $subinsertData->pri_createat = date('Y-m-d H:i:s');
                $subinsertData->pri_updateat = date('Y-m-d H:i:s');
                $subinsertData->save();
                } 
            }

            if($insertData)
            {
                Session::flash('success', 'Mobile cover details created!');
                return redirect()->intended('/mobiles-covers');
            }else{
                Session::flash('error', "Mobile cover details isn't created!");
                return redirect()->intended('/mobiles-covers');
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
        'pod_pro_name' => 'required',
        'pod_brand_name' => 'required',
        'pod_cat_id' => 'required',
        'pod_pro_description' => 'required',
        'pod_price' => 'required',
        'pod_quantity' => 'required',
        'pod_picture' => 'required|image|mimes:jpeg,png,jpg|max:3048',
        'pri_image_name' => 'image|mimes:jpeg,png,jpg|max:3048',
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
            if($request->file('pod_picture'))
            {
                $fileLink = str_random(40);
                $images = $request->file('pod_picture');
                $imagesname = str_replace(' ', '-',$fileLink.'products.'. $images->getClientOriginalExtension());
                $images->move(public_path('assets/img/products/'),$imagesname);

            }else{
                $selectImages = Products::where('pod_id',$request->pod_id)->select(['pod_picture'])->first();
                $imagesname = $selectImages->pod_picture; 
            }

            $updateData['pod_pro_name'] = $request->pod_pro_name;
            $updateData['pod_brand_name'] = $request->pod_brand_name;
            $updateData['pod_main_cat_id'] = 12;
            $updateData['pod_cat_id'] = $request->pod_cat_id;
            $updateData['pod_sub_cat_id'] = $request->pod_sub_cat_id ? $request->pod_sub_cat_id:0;
            $updateData['pod_pro_description'] = $request->pod_pro_description;
            $updateData['pod_price'] = $request->pod_price;
            $updateData['pod_offer_price'] = $request->pod_offer_price ? $request->pod_offer_price:0.0;
            $updateData['pod_quantity'] = $request->pod_quantity ? $request->pod_quantity:1;
            $updateData['pod_return_policy'] = $request->pod_return_policy ? $request->pod_return_policy:'';
            $updateData['pod_made_in'] = $request->pod_made_in ? $request->pod_made_in:'India';
            $updateData['pod_colour'] = $request->pod_colour ? implode(",", $request->pod_colour):'';
            $updateData['pod_size'] = $request->pod_size ? $request->pod_size:'';
            $updateData['pod_ord_within'] = $request->pod_ord_within ? $request->pod_ord_within:'';
            $updateData['pod_picture'] = $imagesname;
            $updateData['pod_deal_of_day'] = $request->pod_deal_of_day ? $request->pod_deal_of_day:0; //    0 = No , 1 = Yes
            $updateData['pod_choose_type'] = $request->pod_choose_type ? $request->pod_choose_type:1; //    1 = New , 2 = Ads 3 = Old
            $updateData['pod_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = Products::where('pod_id',$request->pod_id)->update($updateData);

            $pictureImages = ProductImages::where('pri_product_id',$request->pod_id)->orderBy('pri_product_id','ASC')->first();

            if($pictureImages)
            {
                if($imagesname)
                {
                    $subData['pri_product_id'] = $request->pod_id;
                    $subData['pri_image_name'] = $imagesname;
                    $subData['pri_status'] = 0;
                    $subData['pri_createat'] = date('Y-m-d H:i:s');
                    $subData['pri_updateat'] = date('Y-m-d H:i:s');
                    $subUpdate = ProductImages::where('pri_id',$pictureImages->pri_id)->update($subData);
                }
            }else
            {
                $subData = new ProductImages;
                $subData->pri_product_id = $request->pod_id;
                $subData->pri_image_name = $imagesname;
                $subData->pri_status = 0;
                $subData->pri_createat = date('Y-m-d H:i:s');
                $subData->pri_updateat = date('Y-m-d H:i:s');
                $subData->save();
            }

            if($infoUpdate)
            {
                Session::flash('success', 'Mobile cover details updated!');
                return redirect()->intended('/mobiles-covers');
            }else{
                Session::flash('error', "Mobile cover details isn't updated!");
                return redirect()->intended('/edit-products/'.$request->pod_id);
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'pod_pro_name' => 'required',
        'pod_brand_name' => 'required',
        'pod_cat_id' => 'required',
        'pod_pro_description' => 'required',
        'pod_price' => 'required',
        'pod_quantity' => 'required',
        'pod_picture' => 'image|mimes:jpeg,png,jpg|max:3048',
        ]);
    }

    // To delete record..
    public function destroy($id)
    { 
        if(Products::where('pod_unique_id',$id)->exists())
        {
            Products::where('pod_unique_id',$id)->delete();
            ProductImages::where('pri_product_id',$id)->delete();
            Session::flash('success', 'Product deleted!');
            return redirect()->intended('/mobiles-covers');
        }else{
          Session::flash('error', "Product isn't deleted!");
          return redirect()->intended('/mobiles-covers');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = Products::where('pod_id',$request->pod_id)->update(array('pod_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = Products::where('pod_id',$request->pod_id)->update(array('pod_status' => 1));
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
        return Excel::download(new PreChoreesExport, 'products.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = Products::where('pod_pro_name','<>','')->orderBy('pod_id','ASC')->get();
        $pdf = PDF::loadView('admin.shop.mobiles-covers-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('products-'.$todayDate.'.pdf');
    }

    public function getSubcategory(Request $request)
    {
        $data = SubCategory::where('sub_cat_id',$request->category_id)->where('sub_status',0)->orderby('sub_id','ASC')->distinct()->get(['sub_id','sub_cat_name']);
        return $data;
    }

    public function getCategory(Request $request)
    {
        $data = Category::where('cat_main_id',$request->category_id)->orderby('cat_name','ASC')->distinct()->get(['cat_id','cat_name']);
        return $data;
    }
}