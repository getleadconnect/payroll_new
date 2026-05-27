<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\SalaryIncrement;
use App\Models\Project;
use App\Models\ProjectStaff;
use App\Models\StaffOverTime;

use Validator;
use DataTables;
use Session;
use DB;
use Carbon\Carbon;

class StaffOverTimeController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$staffs=(new Staff())->getStaffs();
	$projs=(new Project())->getProjects();
    return view('admin.staffs.staff_over_time_entry',compact('staffs','projs'));
  }	
  
  public function store(Request $request)
	{
		
		$sov=StaffOverTime::where('ot_date',$request->ot_date)->where('staff_id',$request->staff_id)->count();
		
		if($sov>0)
		{
			$res=2;
		}
		else
		{
			$result=(new StaffOverTime())->addStaffOverTime($request);
		   
			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				
		}
		return $res;
	}


	public function edit($id)
	{
		$sot=(new StaffOverTime())->getStaffOverTimeById($id);
		$projs=(new Project())->getProjects();
		$staffs=(new ProjectStaff())->getProjectStaffByProjectId($sot->project_id);
		return view('admin.staffs.edit_staff_over_time',compact('staffs','projs','sot'));
	}
	
	public function update_staff_over_time(Request $request)
	 {

		$result=(new StaffOverTime())->UpdateStaffOverTime($request);

			if($result)
			{
				Session::flash('message', 'success#Staff over time successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staff-over-times');
	}
	
	
   public function destroy($id)
	{

		$result=(new StaffOverTime())->deleteStaffOverTime($id);
		
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
            $data = (new StaffOverTime())->viewStaffOverTimes($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
		
	}
	
	
	
}
