<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MiscCategory;
use App\Models\MiscSiteExpense;
use App\Models\MiscVendor;
use App\Models\Project;
use App\Models\PaymentType;

use Validator;
use DataTables;
use Session;

class MiscSiteExpenseController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $mcat=(new MiscCategory())->getMiscCategory();
	 $projs=(new Project())->getProjects();
	 $ptype=(new PaymentType())->getPaymentTypes();
     return view('admin.misc_items.misc_site_expense',compact('mcat','projs','ptype'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MiscSiteExpense::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscSiteExpense())->addMiscSiteExpense($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Expense successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('misc-site-expenses');
	}
	
	public function edit($id)
	{
		
		$mcat=(new MiscCategory())->getMiscCategory();
		$ptype=(new PaymentType())->getPaymentTypes();
		$projs=(new Project())->getProjects();
		$mex=(new MiscSiteExpense())->getMiscSiteExpenseById($id);
		return view('admin.misc_items.edit_misc_site_expense',compact('mcat','projs','mex','ptype'));
		
	}
	
	
	 public function update_misc_site_expense(Request $request)
	 {

		$validate=Validator::make($request->all(),MiscSiteExpense::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MiscSiteExpense())->updateMiscSiteExpense($request);

			if($result)
			{
				Session::flash('message', 'success#Expense successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('misc-site-expenses');
	}
	
	
   public function destroy($id)
	{

		$result=(new MiscSiteExpense())->deleteMiscSiteExpense($id);
		
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
            $data = (new MiscSiteExpense())->viewMiscSiteExpenses($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
		
	}
	
	public function activate_deactivate($id,$op)
	{
		if($op==1)
		{
		   $new=['status'=>1];
		}
		else
		{	
		   $new=['status'=>0];
		}

		$result=MiscSiteExpense::where('id',$id)->update($new);

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
	
	
}
