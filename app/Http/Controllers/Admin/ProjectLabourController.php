<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Labour;
use App\Models\LabourType;
use App\Models\SkillType;
use App\Models\LabourWage;
use App\Models\ProjectLabour;
use App\Models\Project;

use Validator;
use DataTables;
use Session;
use DB;

//use MessageBag;

class ProjectLabourController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $proj=(new Project())->getProjects();
	 $skill=(new SkillType())->getSkillTypes();
	 return view('admin.labours.project_labours',compact('skill','proj'));
  }	
  
  
   public function assign_labours()
  {
	 $skill=(new SkillType())->getSkillTypes();
	 return view('admin.labours.assign_project_labours',compact('skill'));
  }
  
  
   public function store(Request $request)
	{
		
		$result=(new ProjectLabour())->addProjectLabour($request);
		
		if($result)
		{
			Session::flash('message', 'success#Labours successfully assigned.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}	
		
	return redirect('assign-labours');
		
	}
	
	public function edit($id) 
	{
		$lw=(new LabourWage())->getLabourWageById($id);
		return view('admin.labours.edit_labour_wage',compact('lw'));
	}
	
	public function set_labour_to_project(Request $request) 
	{
		$lbrids=$request->labour_id;
		$lbrcnt=$request->labour_count;
		
		$pros=(new Project())->getProjects();
		return view('admin.labours.assign_labours_to_project',compact('pros','lbrids','lbrcnt'));
	}
	
		
	
   public function destroy($id)
	{

		$result=(new ProjectLabour())->deleteProjectLabour($id);
		
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
	
	
   public function view_labour_details(Request $request)
	{

		if ($request->ajax()) {
            $data = (new ProjectLabour())->viewLabourDetails($request);

            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						return '<input type="checkbox" class="sub_chk"  data-id="'.$data['id'].'" >';
					})

                    ->rawColumns(['action','selbtn','wstat'])
                    ->make(true);
        }
		
	}
	
	public function view_project_labours(Request $request)
	{

		if ($request->ajax()) {
            $data = (new ProjectLabour())->viewAssignedLabours($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status',])
                    ->make(true);
        }
		
	}
	
	public function release_project_labour($id)
	{
		$pl=(new ProjectLabour())->getProjectLabourById($id);
		return view('admin.labours.release_project_labour',compact('pl'));
	}


	public function release_assigned_labour(Request $request)
	{
		
		DB::beginTransaction();
		$result=false;
		
		try
		{
		
			$id=$request->rel_labour_id;
			$edate=$request->rel_end_date;		
			
			$new=['assigned_status'=>0];
			$new1=['status'=>0,'end_date'=>$edate];
			
			$dt=ProjectLabour::where('id',$id)->first();
			if(!empty($dt))
			{
			  $result=Labour::where('id',$dt->labour_id)->update($new);
			  $result=ProjectLabour::where('id',$id)->update($new1);
			}
			DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollback();
			$result=false;
			//Session::flash('message', 'danger#'.$e->getMessage());
		}

		if($result)
		{
			Session::flash('message', 'success#Labours successfully released.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}
		
	return redirect('project-labours');
	}

	
	/*public function clear_assigned_labour_status($id)
	{
		$new=['assigned_status'=>0];
		$new1=['status'=>0];
		
		$dt=ProjectLabour::where('id',$id)->first();
		if(!empty($dt))
		{
		  $result=Labour::where('id',$dt->labour_id)->update($new);
		  $result=ProjectLabour::where('id',$id)->update($new1);
		}
		
		return $result;
	}*/
	
	
		
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
		
		$result=ProjectLabour::whereId($id)->update($new);

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
