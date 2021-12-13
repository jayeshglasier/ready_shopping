<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helper\Exceptions;
use App\Model\FeedBack;
use App\User;
use DB;

class DashboardController extends Controller
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
        $data['totalSeller'] = User::where('use_role',2)->count();
        $data['totalCustomer'] = User::where('use_role',3)->count();
        $data['pendingOrder'] = DB::table('tbl_orders')->where('ord_order_status',0)->count();
        $data['feedbacks'] = FeedBack::join('users','tbl_feed_back.fed_user_id','=','users.id')->orderBy('fed_id','DESC')->limit(20)->get();
        return view('home',$data);
    }
}