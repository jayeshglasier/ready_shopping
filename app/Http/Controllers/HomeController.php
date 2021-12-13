<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FeedBack;

class HomeController extends Controller
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
        $data['feedbacks'] = FeedBack::join('users','tbl_feed_back.fed_user_id','=','users.id')->orderBy('fed_id','DESC')->get();
        return view('home',$data);
    }
}
