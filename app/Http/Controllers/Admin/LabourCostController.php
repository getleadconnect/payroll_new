<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Company;
use App\Models\Client;
use App\Models\ProjectLabour;
use App\Models\ProjectType;
use App\Models\MainCostSchedule;
use App\Models\LabourWage;

use Validator;
use DataTables;
use Session;


class LabourCostController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $projs=(new Project())->getProjects();
	 return view('admin.labours.labour_cost',compact('projs'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Project::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Project())->addProject($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Project successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('projects');
	}
	
	public function edit($id)
	{
		$pr=(new Project())->getProjectById($id);
		$company=(new Company())->getCompany();
		$client=(new Client())->getClients();
		$ptype=(new ProjectType())->getProjectTypes();
		return view('admin.projects.edit_project',compact('pr','company','client','ptype'));
	}
	
	
	 public function update_Project(Request $request)
	 {

		$validate=Validator::make($request->all(),Project::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Project())->updateProject($request);

			if($result)
			{
				Session::flash('message', 'success#Project successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('projects');
	}
	
	
   public function destroy($id)
	{

		$result=(new Project())->deleteProject($id);
		
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
            $data = (new Project())->viewProjects($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','sdate','status'])
                    ->make(true);
        }
		
	}
		
	public function change_project_status($id,$op)
	{
		$new=['project_status'=>$op];
		$result=Project::where('id',$id)->update($new);
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

		$result=Project::where('id',$id)->update($new);

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
	
	
	public function get_labours_by_project_id($id)
	{
		$lbrs=ProjectLabour::select('labours.id','labours.name')
		->Join('labours','project_labours.labour_id','=','labours.id')
		->where('project_id',$id)->orderBy('project_labours.id','ASC')->get();
		
		$opt="<option value=''>--select--</option>";
		foreach($lbrs as $r)
		{
		   $opt.="<option value='".$r->id."'>".$r->name."</option>";	
		}
		
		return $opt;
	}
	
	public function get_main_cost_schedule_by_project_id($id)
	{
		$mitems=MainCostSchedule::select('main_cost_items.main_item')
		->Join('projects','main_cost_schedules.project_id','=','projects.id')
		->Join('main_cost_items','main_cost_schedules.main_cost_item_id','=','main_cost_items.id')
		->where('main_cost_schedules.project_id',$id)->orderBy('main_cost_schedules.id','ASC')->get();
		
		$opt="<option value=''>--select--</option>";
		foreach($mitems as $r)
		{
		   $opt.="<option value='".$r->id."'>".$r->main_item."</option>";	
		}
		
		return $opt;
	}
		
	public function get_labour_wage_by_labour_id($id)
	{
		$lwage=LabourWage::where('labour_id',$id)->first();
		$dat=[];
		if(!empty($lwage))
		{
		  $dat['normal']=number_format($lwage->wage_normal,2,'.','');
		  $dat['concrete']=number_format($lwage->wage_concrete,2,'.','');
		}
		
		return json_encode($dat);
	}
	
	
}
