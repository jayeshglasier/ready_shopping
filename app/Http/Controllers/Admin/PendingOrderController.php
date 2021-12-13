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
use App\Model\SubCategory;
use App\Model\Brands;
use App\Model\ProductOrder;
use App\User;
use Auth;
use Session;
use Input;
use PDF;

class PendingOrderController extends Controller
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
                $data['sortBy'] = "ord_id";
                $pageAsc_Desc = "ord_id";
            }

            if($search)
            {   
                $data['datarecords'] = ProductOrder::where('ord_order_status',0)->orderBy('ord_id',$pageOrder)->paginate($pages);
            }else{
                $data['datarecords'] = ProductOrder::leftjoin('users','tbl_orders.ord_customer_id','=','users.id')->leftjoin('tbl_products','tbl_orders.ord_product_id','=','tbl_products.pod_id')->where('ord_order_status',0)->orderBy('ord_id',$pageOrder)->paginate($pages);
            }
            return view('orders.pending.order-list',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    public function assignSellerOrder($id)
    {
        $data['sellers'] = User::where('use_role',2)->where('use_status',0)->get();
        $data['devlveryboys'] = User::where('use_role',4)->where('use_status',0)->get();
        $data['editData'] = ProductOrder::where('ord_unique_id',$id)->first();
        return view('orders.pending.assign-seller-order',$data);
    }

    public function updateAssignOrder(Request $request)
    {
        $this->validateUpdate($request);
        try
        {  
            $sellers = User::where('id',$request->ord_seller_id)->where('use_role',2)->where('use_status',0)->first();
            $devlveryboys = User::where('id',$request->ord_delivery_boy_id)->where('use_role',4)->where('use_status',0)->first();

            $updateData['ord_seller_name'] = $sellers->use_full_name;
            $updateData['ord_delivery_boy_name'] = $devlveryboys->use_full_name;
            $updateData['ord_seller_id'] = $request->ord_seller_id;
            $updateData['ord_delivery_boy_id'] = $request->ord_delivery_boy_id;
            $updateData['ord_order_status'] = $request->ord_order_status;
            if($request->ord_order_status == 0)
            {
                $statusTitle = "Pending";
            }
            else if($request->ord_order_status == 1)
            {
                $statusTitle = "Delivery";
            }
            else if($request->ord_order_status == 2)
            {
                $statusTitle = "Confirm";
            }
            else if($request->ord_order_status == 3)
            {
                $statusTitle = "Cancle";
            }else{
                $statusTitle = "";
            }
           
            $updateData['ord_order_status_title'] = $statusTitle;
            $infoUpdate = ProductOrder::where('ord_unique_id',$request->ord_unique_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Assign to seller successfully!');
                return redirect()->intended('/orders-list');
            }else{
                Session::flash('error', "Something is wrong!");
                return redirect()->intended('/orders-list');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'ord_seller_id' => 'required',
        'ord_delivery_boy_id' => 'required',
        'ord_order_status' => 'required',
        ]);   
    }


}
