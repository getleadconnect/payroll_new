<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\SalaryIncrement;

use Validator;
use DataTables;
use Session;


class StaffSalaryIncrementController_old extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
 
  
  public function index()
  {
     return view('admin.staffs.salary_increment');
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SalaryIncrement::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new SalaryIncrement())->addSalaryIncrement($request);
		   
			if($result)
			{
				Session::flash('message', 'success#SalaryIncrement successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('SalaryIncrements');
	}
	
	public function edit($id)
	{
		$cl=(new SalaryIncrement())->getSalaryIncrementById($id);
		return view('admin.SalaryIncrement.edit_SalaryIncrement',compact('cl'));
	}
	
	
	 public function update_SalaryIncrement(Request $request)
	 {

		$validate=Validator::make($request->all(),SalaryIncrement::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SalaryIncrement())->updateSalaryIncrement($request);

			if($result)
			{
				Session::flash('message', 'success#SalaryIncrement successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('SalaryIncrements');
	}
	
	
   public function destroy($id)
	{

		$result=(new SalaryIncrement())->deleteSalaryIncrement($id);
		
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
            $data = (new SalaryIncrement())->viewSalaryIncrements($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','cperson','status'])
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

		$result=SalaryIncrement::where('id',$id)->update($new);

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
