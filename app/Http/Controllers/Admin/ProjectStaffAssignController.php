<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\Project;
use App\Models\ProjectStaff;

use Validator;
use DataTables;
use Session;

class ProjectStaffAssignController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $projs=(new Project())->getProjects();
	 $stfs=(new Staff())->getAvailableStaffs();
	 return view('admin.staffs.assign_project_staff',compact('projs','stfs'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),ProjectStaff::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new ProjectStaff())->AssignProjectStaff($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Staff successfully assigned.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('project-staffs');
	}
	
	
	public function edit($id)
	{
		
	}

	
	public function release_staff($id)
	 {
		$ps=ProjectStaff::where('id',$id)->first();
		$result=0;
		try
		{
			$new=['status'=>0,'period_to'=>date('Y-m-d')];
			$new1=['available'=>0];
				
			$result=ProjectStaff::where('id',$id)->update($new);
			$res1=Staff::where('id',$ps->staff_id)->update($new1);
		}
		catch(\Exception $e)
		{
			$result=0;
		}
				
		return $result;
		
	}
	
	
   public function destroy($id)
	{

		$result=(new ProjectStaff())->deleteProjectStaff($id);
		
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
            $data = (new ProjectStaff())->viewProjectStaffs($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status'])
                    ->make(true);
        }
		
	}


	public function get_project_staff_names($id)
	{
		$data=(new ProjectStaff())->getProjectStaffByProjectId($id);
		return $data;
	}
	
	
	/*public function get_project_staffs($id)
	{
		$data=(new ProjectStaff())->getProjectStaffByProjectId($id);
		$opt='<option value="">--selct--</option>';
		foreach($data as $r)
		{
			$opt.='<option value="'.$r->id.'">'.$r->name.'</option>';
		}
		return $opt;
	} 
	*/

}
