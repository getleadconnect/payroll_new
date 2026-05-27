<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MiscVendor;

use Validator;
use DataTables;
use Session;

class MiscVendorController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 return view('admin.misc_vendor.misc_vendor');
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MiscVendor::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#invalid datas/GST duplicate not allowed, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscVendor())->addMiscVendor($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Vendor details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('misc-vendors');
	}
	
	
	public function edit($id)
	{
		$mv=(new MiscVendor())->getMiscVendorById($id);
		return view('admin.misc_vendor.edit_misc_vendor',compact('mv'));
	}

	
	public function update_misc_vendor(Request $request)
	{

		$validate=Validator::make($request->all(),MiscVendor::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscVendor())->updateMiscVendor($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Vendor details successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('misc-vendors');
	}
	
	
	
   public function destroy($id)
	{

		$result=(new MiscVendor())->deleteMiscVendor($id);
		
			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				
			return $res;
	}
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new MiscVendor())->viewMiscVendors($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
		
	}

}
