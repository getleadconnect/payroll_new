<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\SalaryIncrement;

use Validator;
use DataTables;
use Session;
use DB;

class SalaryIncrementController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  
	$staffs=(new Staff())->getStaffs();
    return view('admin.staffs.salary_increment',compact('staffs'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SalaryIncrement::RULES);

		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing11, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new SalaryIncrement())->addSalaryIncrement($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Salary increment successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('salary-increments');
	}
		
	public function add_salary_increment()
	{
		$stfs=$this->get_staff_and_salary();
		return view('admin.staffs.add_salary_increment',compact('stfs'));
	}
	
	public function edit($id)
	{
		$si=(new SalaryIncrement())->get_Salary_Increment_By_Id($id);
		return view('admin.staffs.edit_salary_increment',compact('si'));
	}
	
	
	 public function update_salary_increment(Request $request)
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

			return redirect('salary-increments');
	}
	
	
   public function destroy($id,$st_id)
	{

		$result=(new SalaryIncrement())->deleteSalaryIncrement($id,$st_id);
		
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
                    ->rawColumns(['action',])
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
	
	/*public function get_staff_salary($id)
	{
		$dat=SalaryIncrement::where('staff_id',$id)->orderBy('id','DESC')->first();
		$data=[];
		if(!empty($dat))
		{
			$data['old_salary']=$dat->old_salary;
			$data['salary']=$dat->salary;
		}
		else
		{
			$data['old_salary']=0;
			$data['salary']=0;
		}
				
		return json_encode($data);
	}*/
			
	public function get_staff_and_salary()
	{
		$stfs=Staff::select('staffs.id','staffs.name','salary_increments.current_salary')
 			->Join('salary_increments', function($join)
			{
				$join->on('staffs.id', '=', 'salary_increments.staff_id')
				->where('salary_increments.id',DB::raw("(SELECT max(id) from salary_increments WHERE salary_increments.staff_id = staffs.id)"));
		})->get();

	return $stfs;

	}
	
	
}
