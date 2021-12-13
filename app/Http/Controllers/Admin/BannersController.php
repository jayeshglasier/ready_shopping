<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PreChoreesExport;
use App\Helper\Exceptions;
use App\Model\Banners;
use FarhanWazir\GoogleMaps\GMaps;
use Auth;
use Session;
use Input;
use PDF;

class BannersController extends Controller
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
                $data['sortBy'] = "ban_id";
                $pageAsc_Desc = "ban_id";
            }

            if($search)
            {   
                $data['datarecords'] = Banners::orderBy($pageAsc_Desc,$pageOrder)->where('ban_title','like','%'.$search.'%')->paginate($pages);
            }else{
                $data['datarecords'] = Banners::where('ban_title','<>','')->orderBy($pageAsc_Desc,$pageOrder)->paginate($pages);
            }
            return view('admin.banners-mgmt.index',$data);
        } catch (\Exception $e) {
            Exceptions::exception($e);
        }
    }

    // Create Form...
    public function create()
    {

        // $config['center'] = "Shop No. 9, Vraj Vihar-7, Opp. Hans Residency, Anand Nagar, road , Prahladnagar, nr. Auda Lake, Ahmedabad, Gujarat 380015";
        // $config['zoom'] = '16';
        // $config['map_height'] = '400px';

        // $marker = array();
        // $marker['position'] = "Ahmedabad";
        
        // $gmap = new GMaps();
        // $gmap->initialize($config);
        // $gmap->add_marker($marker);
     
        // $data['map'] = $gmap->create_map();
        
        return view('admin.banners-mgmt.create');
    }

    // Update Form...
    public function edit($id)
    {
        $data['editData'] = Banners::where('ban_unique_id',$id)->first();
        return view('admin.banners-mgmt.edit',$data);
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
            if(Banners::where('ban_title',$request->ban_title)->exists())
            {
                Session::flash('error', 'Banner already exists!');
                return redirect()->intended('/create-banners');
            }

            if($request->file('ban_picture'))
            {
                $images = $request->file('ban_picture');
                $imagesname = str_replace(' ', '-',$images->getClientOriginalName());
                $images->move(public_path('assets/img/banners/'),$imagesname);
            }else{
               $imagesname = '';   
            }
            $uniqueId = str_random(15).date("Ymd");
            $insertData = new Banners;
            $insertData['ban_unique_id'] = $uniqueId;
            $insertData['ban_title'] = $request->ban_title;
            $insertData['ban_picture'] = $imagesname;
            $insertData['ban_status'] = 0;
            $insertData['ban_createat'] = date('Y-m-d H:i:s');
            $insertData['ban_updateat'] = date('Y-m-d H:i:s');
            $insertData->save();

            if($insertData)
            {
                Session::flash('success', 'Banner created!');
                return redirect()->intended('/banners');
            }else{
                Session::flash('error', "Banner isn't created!");
                return redirect()->intended('/banners');
            }
            
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

    // Validation to check here..
    private function validateStore($request)
    {
        $this->validate($request, [
        'ban_title' => 'required|max:100',
        'ban_picture' => 'required|image|mimes:jpeg,png,gif,jpg|max:2040',
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
            if($request->file('ban_picture'))
            {
                $images = $request->file('ban_picture');
                $imagesname = str_replace(' ', '-',$images->getClientOriginalName());
                $images->move(public_path('assets/img/banners/'),$imagesname);
            }else{
                $selectImages = Banners::where('ban_unique_id',$request->ban_unique_id)->select(['ban_picture'])->first();
                $imagesname = $selectImages->ban_picture;  
            }
            $updateData['ban_title'] = $request->ban_title;
            $updateData['ban_picture'] = $imagesname;
            $updateData['ban_updateat'] = date('Y-m-d H:i:s');
            $infoUpdate = Banners::where('ban_unique_id',$request->ban_unique_id)->update($updateData);

            if($infoUpdate)
            {
                Session::flash('success', 'Banner updated!');
                return redirect()->intended('/banners');
            }else{
                Session::flash('error', "Banner isn't updated!");
                return redirect()->intended('/banners');
            }
        }catch (\Exception $e) {
             Exceptions::exception($e);
        }
    }

     // Validation to check here..
    private function validateUpdate($request)
    {
        $this->validate($request, [
        'ban_title' => 'required|max:200',
        'ban_picture' => 'image|mimes:jpeg,png,gif,jpg|max:2040',
        ]);   
    }

    // To delete record..
    public function destroy($id)
    { 
        if(Banners::where('ban_id',$id)->exists())
        {
            Banners::where('ban_id',$id)->delete();
            Session::flash('success', 'Banner deleted!');
            return redirect()->intended('/banners');
        }else{
          Session::flash('error', "Banner isn't deleted!");
          return redirect()->intended('/banners');
        }
    }

    // To check active / inactive status...
    public function changeStatus(Request $request)
    {
        try
        {  
            if($request->mode == "true")
            {
                $checkStatus = Banners::where('ban_id',$request->ban_id)->update(array('ban_status' => 0));
                $data['status'] = "true";
                return $data;
            }
            else
            {
                $checkStatus = Banners::where('ban_id',$request->ban_id)->update(array('ban_status' => 1));
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
        return Excel::download(new PreChoreesExport, 'Banners.xlsx');
    }

    // To export reecord in pdf file..
    public function exportPdf()
    {
        $data['datarecords'] = Banners::where('ban_title','<>','')->orderBy('ban_id','ASC')->get();
        $pdf = PDF::loadView('admin.banners-mgmt.pdf-file', $data);

        $todayDate = date('d-m-Y');
        return $pdf->download('Banners-'.$todayDate.'.pdf');
    }
}
