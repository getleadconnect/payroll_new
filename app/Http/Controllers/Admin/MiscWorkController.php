<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MiscWork;
use App\Models\MiscVendor;
use App\Models\MiscCategory;
use App\Models\PaymentType;
use App\Models\Project;

use Validator;
use DataTables;
use Session;

class MiscWorkController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $mcat=(new MiscCategory())->getMiscCategory();
	 $mven=(new MiscVendor())->getMiscVendors();
	 $ptype=(new PaymentType())->getPaymentTypes();
	 $proj=(new Project())->getProjects();
	 return view('admin.misc_work.misc_works',compact('mcat','mven','ptype','proj'));
  }	
  
   public function add_misc_works()
  {
	 $mcat=(new MiscCategory())->getMiscCategory();
	 $mven=(new MiscVendor())->getMiscVendors();
	 return view('admin.misc_work.add_misc_works',compact('mcat','mven'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MiscWork::RULES);

		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscWork())->addMiscWork($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Misc-works details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('misc-works');
	}
	
	
	public function edit($id)
	{
		$mv=(new MiscWork())->getMiscWorkById($id);
		$mcat=(new MiscCategory())->getMiscCategory();
		$mven=(new MiscVendor())->getMiscVendors();
		$ptype=(new PaymentType())->getPaymentTypes();
		$proj=(new Project())->getProjects();
		return view('admin.misc_work.edit_misc_work',compact('mv','mcat','mven','ptype','proj'));
	}
	
	public function update_misc_work(Request $request)
	{

		$validate=Validator::make($request->all(),MiscWork::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscWork())->updateMiscWork($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Misc-works details successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('misc-works');
	}
		
	
   public function destroy($id)
	{

		$result=(new MiscWork())->deleteMiscWork($id);
		
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
            $data = (new MiscWork())->viewMiscWorks($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','tamt'])
                    ->make(true);
        }
		
	}
	
	
	
	

}
