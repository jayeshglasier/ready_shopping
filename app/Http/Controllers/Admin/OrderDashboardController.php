<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helper\Exceptions;
use App\Model\FeedBack;
use App\User;
use DB;

class OrderDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // pending: 0 delivery : 1 confirm: 2 cancle: 3    
        $data['pendingOrder'] = DB::table('tbl_orders')->where('ord_order_status',0)->whereDate('ord_order_date',date('Y-m-d'))->count();
        $data['deliveryOrder'] = DB::table('tbl_orders')->where('ord_order_status',1)->whereDate('ord_order_date',date('Y-m-d'))->count();
        $data['confirmOrder'] = DB::table('tbl_orders')->where('ord_order_status',2)->whereDate('ord_order_date',date('Y-m-d'))->count();
        $data['cancleOrder'] = DB::table('tbl_orders')->where('ord_order_status',3)->whereDate('ord_order_date',date('Y-m-d'))->count();

        $order =  DB::table('tbl_orders')->select('ord_order_id','ord_full_name','ord_phone_number','ord_pay_method')->whereDate('ord_order_date',date('Y-m-d'));
        $data['pendings'] = $order->where('ord_order_status',0)->get();
        $data['deliverys'] = $order->where('ord_order_status',1)->get();
        $data['confirms'] = $order->where('ord_order_status',2)->get();
        $data['cancles'] = $order->where('ord_order_status',3)->get();
        $data['feedbacks'] = FeedBack::join('users','tbl_feed_back.fed_user_id','=','users.id')->orderBy('fed_id','DESC')->limit(20)->get();
        return view('order-dashboard',$data);
    }
}