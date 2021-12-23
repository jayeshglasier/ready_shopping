<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\Exceptions;
use App\Model\SystemSetting;
use Auth;
use Session;
use Input;
use PDF;

class SettingController extends Controller
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
            $data['editRecord'] = SystemSetting::select('sys_razorpay_key_id')->where('sys_unique_id',"sys05hLCXss19JB2")->first();
            return view('setting-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    public function update(Request $request)
    {   
        $this->validateStore($request);
        $updatedata['sys_razorpay_key_id'] = $request->sys_razorpay_key_id;
        $update = SystemSetting::where('sys_unique_id',"sys05hLCXss19JB2")->update($updatedata);
        Session::flash('success', 'Update success!');
        return redirect('setting');
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'sys_razorpay_key_id' => 'required',
        ]);   
    }
}
