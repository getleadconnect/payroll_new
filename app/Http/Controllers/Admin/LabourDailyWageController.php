<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\ProjectLabour;
use App\Models\MainCostCenter;
use App\Models\Labour;
use App\Models\LabourWage;
use App\Models\LabourDailyWage;
use App\Models\FloorNo;


use Validator;
use DataTables;
use Session;

class LabourDailyWageController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $projs=(new Project())->getProjects();
	 $flnos=(new FloorNo())->getFloors();
	 return view('admin.labours.labour_daily_wage',compact('projs','flnos'));
  }	
  
   
  public function store(Request $request)
	{
		$result=(new LabourDailyWage())->addLabourDailyWage($request);

		if($result)
			{
				Session::flash('message', 'success#Daily wage successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('labour-daily-wages');
	}

	
	public function edit($id)
	{
		
		$ldw=(new LabourDailyWage())->getLabourDailyWageEntryById($id);
		
		$projs=(new Project())->getProjectById($ldw->project_id);
		$flnos=(new FloorNo())->getFloorById($ldw->floor_no_id);
		$mcost=(new MainCostCenter())->getMainCostCenterByProjectIdFloorId($ldw->project_id,$ldw->floor_no_id);
		
		return view('admin.labours.edit_labour_daily_wage',compact('projs','flnos','ldw','mcost'));
	}
		
	 public function update_daily_wage(Request $request)
	 {

		$validate=Validator::make($request->all(),LabourDailyWage::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		if($request->ed_ot_hrs>8)
		{
			Session::flash('message', 'danger#Invalid over time, Max-8Hrs only.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new LabourDailyWage())->updateLabourDailyWage($request);

			if($result)
			{
				Session::flash('message', 'success#Daily wage successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('labour-daily-wages');
	}
	

	
   public function destroy($id)
	{

		$result=(new LabourDailyWage())->deleteLabourDailyWage($id);
		
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
            $data = (new LabourDailyWage())->viewLabourDailyWages($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','edate'])
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
		/*$lbr=LabourDailyWage::where('labour_daily_wages.entry_date',date('Y-m-d'))->pluck('labour_id');

		/*$lbrs=ProjectLabour::select('labours.id','labours.name')
		 ->leftJoin('labours','project_labours.labour_id','=','labours.id')
		 ->leftJoin('labour_daily_wages', 'labour_daily_wages.labour_id','=','project_labours.labour_id')
		 ->whereNotIn('labours.id',$lbr)
		 ->where('project_labours.project_id',$id)->where('project_labours.status',1)->orderBy('project_labours.id','ASC')->get();
		*/
		
		$lbrs = ProjectLabour::select('labours.id','labours.name')
				->leftJoin('labours', 'project_labours.labour_id', '=', 'labours.id')
				->leftJoin('labour_daily_wages', function ($join) {
					$join->on('labour_daily_wages.labour_id', '=', 'project_labours.labour_id');
				})
				->whereNotIn('labours.id', function ($query) use($id) {
					$query->select('labour_id')
						->from('labour_daily_wages')
						->where('project_id',$id)
						->whereDate('entry_date', date('Y-m-d'));
				})
				->where('project_labours.project_id',$id)->where('project_labours.status',1)
				->groupBy('labours.id','labours.name')
				->orderBy('labours.id','ASC')->get();

		$opt="<option value=''>--select--</option>";
		foreach($lbrs as $r)
		{
		   $opt.="<option value='".$r->id."'>".$r->name."</option>";	
		}
		
		return $opt;
	}
	
	public function get_main_cost_center_by_project_id($id,$fid)
	{
		$mitems=MainCostCenter::select('main_cost_center.*','main_cost_items.main_item')
		->Join('projects','main_cost_center.project_id','=','projects.id')
		->Join('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
		->where('main_cost_center.project_id',$id)->where('main_cost_center.floor_no_id',$fid)
		->orderBy('main_cost_center.id','ASC')->get();
		
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
		  $dat['normal']=$lwage->wage_normal;
		  $dat['concrete']=$lwage->wage_concrete;
		}
		
		return json_encode($dat);
	}
	
	
	//----------------------------------------------------------------------------------------------------
	
	public function all_labour_wages()
	{
		
	   $projs=(new Project())->getProjects();
	   return view('admin.labours.view_all_labour_daily_wage',compact('projs'));
	}
	
	 public function view_all_data(Request $request)  //3 months details
	{

		if ($request->ajax()) {
            $data = (new LabourDailyWage())->viewAllLabourDailyWages($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','edate'])
                    ->make(true);
        }
		
	}
		
	
// VIEW ALL LABOUR DAILY WAGE EDIT/UPDATE/DELETE-------------------------------------------------------

   public function all_edit($id)  //view all labour daily wage edit
	{
		
		$ldw=(new LabourDailyWage())->getLabourDailyWageEntryById($id);
		
		$projs=(new Project())->getProjectById($ldw->project_id);
		$flnos=(new FloorNo())->getFloorById($ldw->floor_no_id);
		$mcost=(new MainCostCenter())->getMainCostCenterByProjectId($ldw->project_id);
		
		return view('admin.labours.edit_all_labour_daily_wage',compact('projs','flnos','ldw','mcost'));
	}
		
	 public function update_all_daily_wage(Request $request)  //view all labour daily wage update
	 {

		$validate=Validator::make($request->all(),LabourDailyWage::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		if($request->ed_ot_hrs>8)
		{
			Session::flash('message', 'danger#Invalid over time, Max-8Hrs only.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new LabourDailyWage())->updateLabourDailyWage($request);

			if($result)
			{
				Session::flash('message', 'success#Daily wage successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('all-labour-wages');
	}
	

	
   public function all_destroy($id)
	{

		$result=(new LabourDailyWage())->deleteLabourDailyWage($id);   //view all labour daily wage delete
		
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
