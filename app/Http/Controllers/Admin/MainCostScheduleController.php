<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\MainCostItem;
use App\Models\FloorNo;
use App\Models\MainCostSchedule;

use Validator;
use DataTables;
use Session;


class MainCostScheduleController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $proj=(new Project())->getProjects(); 
	 $flrnos=(new FloorNo())->getFloors();
	 $mitems=(new MainCostItem())->getMainCostItems();
     return view('admin.labours.labour_cost_schedule',compact('proj','flrnos','mitems'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MainCostSchedule::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MainCostSchedule())->addMainCostSchedule($request);
		   
			if($result)
			{
				Session::flash('message', 'success#MainCostSchedule successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('main-cost-schedules');
	}
	
	public function edit($id)
	{
		$proj=(new Project())->getProjects(); 
		$flrnos=(new FloorNo())->getFloors();
		$mitems=(new MainCostItem())->getMainCostItems();
		$mcs=(new MainCostSchedule())->getMainCostScheduleById($id);
		return view('admin.labours.edit_labour_cost_schedule',compact('proj','flrnos','mitems','mcs'));
	}
	
	
	 public function update_main_cost_schedule(Request $request)
	 {

		$validate=Validator::make($request->all(),MainCostSchedule::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MainCostSchedule())->updateMainCostSchedule($request);

			if($result)
			{
				Session::flash('message', 'success#MainCostSchedule successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('main-cost-schedules');
	}
	
	
   public function destroy($id)
	{

		$result=(new MainCostSchedule())->deleteMainCostSchedule($id);
		
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
            $data = (new MainCostSchedule())->viewMainCostSchedules($request);

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

		$result=MainCostSchedule::where('id',$id)->update($new);

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
