<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Staff;
use App\Models\StaffSalary;
use App\Models\Project;
use App\Models\ProjectStaff;
use App\Models\SalaryIncrement;
use App\Models\StaffBonus;
use App\Models\StaffTa;
use App\Models\StaffOverTime;

use Validator;
use DataTables;
use Session;

use DB;


class StaffSalaryController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $projs=(new Project())->getProjects();
	 $staffs=(new Staff())->getStaffs();
	 return view('admin.staffs.staff_salary',compact('projs','staffs'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),StaffSalary::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		$where1=['month'=>$request->month,'year'=>$request->year,'staff_id'=>$request->staff_id];
		$cnt=StaffSalary::where($where1)->count();
		
			if($cnt>0)
			{
				Session::flash('message', 'danger#Salary details already added.');
				return back()->withErrors($validate)->withInput();
			}

		   $result=(new StaffSalary())->addStaffSalary($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Staff salary successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('staff-salary');
	}
	
	public function edit($id)
	{
		$ss=(new StaffSalary())->getStaffSalaryById($id);
		$projs=(new Project())->getProjects();
		$pst=$this->get_project_staff_names($ss->project_id);
		
		if(!empty($ss)){$sinc_id=$ss->salary_increment_id;}else{$sinc_id=0;}
		$sinc=(new SalaryIncrement())->get_Salary_Increment_By_Id($sinc_id);
		
		return view('admin.staffs.edit_staff_salary',compact('ss','projs','pst','sinc'));
	}
	
	
	 public function update_staff_salary(Request $request)
	 {

		$validate=Validator::make($request->all(),StaffSalary::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new StaffSalary())->updateStaffSalary($request);

			if($result)
			{
				Session::flash('message', 'success#StaffSalary detail successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staff-salary');
	}
	
	
   public function destroy($id)
	{

		$result=(new StaffSalary())->deleteStaffSalary($id);
		
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
            $data = (new StaffSalary())->viewStaffSalary($request);

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

		$result=StaffSalary::where('id',$id)->update($new);

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
	
	public function get_project_staff_names($id)
	{
		$data=(new ProjectStaff())->getProjectStaffByProjectId($id);
		return $data;
	}
		
	public function get_project_staffs($id)
	{
		$data=(new ProjectStaff())->getProjectStaffByProjectId($id);
		$opt='<option value="">--selct--</option>';
		foreach($data as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->name.'</option>';
		}
		return $opt;
	} 
	
	
	/*public function get_staff_salary_allowance($staff_id,$mon,$yr)
	{
		
		$res=SalaryIncrement::select('salary_increments.*','staffs.esic','staffs.pf')
		->leftJoin('staffs','salary_increments.staff_id','=','staffs.id')
		->where('staff_id',$staff_id)->orderBy('salary_increments.id','DESC')->first();
		
		$sal=[];
		if(!empty($res))
		{
			$sal['salary']=$res->current_salary;
			$sal['net_salary']=$res->current_salary;
		}
		
		return json_encode($sal);
	}
*/

public function get_staff_salary($sta_id,$month,$year)
	{

		$res=SalaryIncrement::select('salary_increments.*')
		->where('staff_id',$sta_id)->orderBy('salary_increments.id','DESC')->first();
		
		$sal=0;
		if(!empty($res))
		{
			$sal=$res->current_salary;
		}

		$sot=StaffOverTime::select(DB::raw("SUM(sunday_ot) as tot_s_hrs"),
				DB::raw("SUM(normal_amt) as tot_n_amt"),DB::raw("SUM(sunday_amt) as tot_s_amt"))
				->where('staff_id',$sta_id)->whereMonth('ot_date',$month)->whereYear('ot_date',$year)->first();

		$sal_dt=['salary'=>0,'normal_hrs'=>'0:0','sunday_ot'=>0,'normal_amt'=>0,'sunday_amt'=>0];
		
		// total overtime calculation ----------------------------------
			$totalOvertimeMinutes = 0;
			$totalHours=0;
			$totalMinutes=0;
			
			$normalOvertimeValues = StaffOverTime::where('staff_id',$sta_id)->whereMonth('ot_date',$month)->whereYear('ot_date',$year)->pluck('normal_ot');
						
			if(!empty($normalOvertimeValues))
			{
				foreach ($normalOvertimeValues as $overtime) {
					list($hours, $minutes) = explode('.', $overtime);
					$totalOvertimeMinutes += ($hours * 60) + $minutes;
				}
				$totalHours = floor($totalOvertimeMinutes / 60);
				$totalMinutes = $totalOvertimeMinutes % 60;
			}
		//--------------------------------------------------------------
		if(!empty($sot))
		{
			
			$sal_dt=['salary'=>$sal,
					'normal_hrs'=>$totalHours.".".$totalMinutes,
					//'normal_hrs'=>$totalHours,
					'sunday_ot'=>$sot->tot_s_hrs??0,
					'normal_amt'=>$sot->tot_n_amt??0,
					'sunday_amt'=>$sot->tot_s_amt??0
					];
		}
		
		return json_encode($sal_dt);
	}


	public function salary_slip($id)
	{
		$cm=(new Company())->getCompany();
		
		$stf=StaffSalary::select('staff_salary.*','staffs.name')
		->leftJoin('staffs','staff_salary.staff_id','=','staffs.id')
		->where('staff_salary.id',$id)->first();
		
		$nsal="0.00";
		$tsal="0.00";
		if(!empty($stf))
		{
			$tsal=$stf->salary+$stf->normal_amt+$stf->sunday_amt;
			$nsal=$tsal-$stf->leave_amt;
		}
		return view('admin.staffs.salary_slip',compact('stf','cm','tsal','nsal'));
	}

}
