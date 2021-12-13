<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\Exceptions;
use App\Model\FeedBack;
use Auth;
use Session;
use Input;
use PDF;

class FeedbackController extends Controller
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
                $data['sortBy'] = "fed_id";
                $pageAsc_Desc = "fed_id";
            }

            if($search)
            {   
                $data['datarecords'] = FeedBack::join('users','tbl_feed_back.fed_user_id','=','users.id')->orderBy('fed_id',$pageOrder)->where('fed_content','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = FeedBack::join('users','tbl_feed_back.fed_user_id','=','users.id')->orderBy('fed_id',$pageOrder)->paginate($pages);
            }
            return view('feedback-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // To delete record..
    public function destroy($id)
    { 
        if(FeedBack::where('fed_id',$id)->exists())
        {
            FeedBack::where('fed_id',$id)->delete();
            Session::flash('success', 'Feedback deleted!');
            return redirect()->intended('/feedback');
        }else{
          Session::flash('error', "Feedback isn't deleted!");
          return redirect()->intended('/feedback');
        }
    }
}
