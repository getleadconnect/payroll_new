<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\MainCostItem;
use App\Models\FloorNo;
use App\Models\MainCostCenter;  //main cost center 

use Validator;
use DataTables;
use Session;


class MainCostCenterController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index(Request $request)
  {
	 $proj=(new Project())->getProjects(); 
	 $flrnos=(new FloorNo())->getFloors();
	 $mitems=(new MainCostItem())->getMainCostItems();
	 $mcosts=$this->view_Main_Cost_Centers($request) ;
     return view('admin.main_cost_center.main_cost_center',compact('mcosts','proj','flrnos','mitems'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MainCostCenter::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$where1=['project_id'=>$request->project_id,'main_cost_item_id'=>$request->main_cost_item_id,'floor_no_id'=>$request->floor_no_id];
		$res=MainCostCenter::where($where1)->count();
		if($res>0)
		{
			Session::flash('message', 'danger#Duplicate data not allowed.');
			return redirect()->back();
			
		}
		else
		{
		   $result=(new MainCostCenter())->addMainCostCenter($request);
		   
			if($result)
			{
				Session::flash('message', 'success#MainCostCenter successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				
		}
		
		return redirect('main-cost-centers');
	}
	
	public function edit($id)
	{
		$proj=(new Project())->getProjects(); 
		$flrnos=(new FloorNo())->getFloors();
		$mitems=(new MainCostItem())->getMainCostItems();
		$mcs=(new MainCostCenter())->getMainCostCenterById($id);
		return view('admin.main_cost_center.edit_main_cost_center',compact('proj','flrnos','mitems','mcs'));
	}
	
	
	public function update_main_cost_center(Request $request)
	{

		$validate=Validator::make($request->all(),MainCostCenter::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MainCostCenter())->updateMainCostCenter($request);

			if($result)
			{
				Session::flash('message', 'success#MainCostCenter successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('main-cost-centers');
	}
	
	
	
	
	
   public function destroy($id)
	{

		$result=(new MainCostCenter())->deleteMainCostCenter($id);
		
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



public function view_Main_Cost_Centers($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->flt_project_id;
		$dts=MainCostCenter::query();
		
		$dts->select('main_cost_center.*','projects.project_name','main_cost_items.main_item','floor_nos.floor_no','admins.name as user_name')
		->leftJoin('projects','main_cost_center.project_id','=','projects.id')
		->leftJoin('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
		->leftJoin('floor_nos','main_cost_center.floor_no_id','=','floor_nos.id')
		->leftJoin('admins','main_cost_center.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("main_cost_items.main_item", 'like', '%' .$search . '%')
						->orWhere("floor_nos.floor_no", 'like', '%' .$search . '%');
				});
		
		if($project_id!="")
		{
			$dts->where('main_cost_center.project_id',$project_id);
		}	
		
		
		$dats=$dts->orderBy('main_cost_center.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!$dats->isEmpty())
        {
			$tot=0;
			foreach ($dats as $key=>$r)
            {
				
				$uData['slno'] = ++$key;
				$uData['proj'] =$r->project_name;
				$uData['mitem'] =$r->main_item;
				$uData['floorno'] =$r->floor_no;
				$uData['sqty'] =$r->schedule_qty;
				$uData['samt'] =number_format($r->schedule_amount,2,'.',',');
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				$uData['action'] = $btn;
				$data[] = $uData;
				$tot+=$r->schedule_amount;
			}
			
			$data[0]['total_amount']=number_format($tot,2,'.',',');
        }

		return $data;
	}		


   /* public function view_data(Request $request)
	{
		if ($request->ajax()) {
            $data = (new MainCostCenter())->viewMainCostCenters($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
	*/
	
	
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

		$result=MainCostCenter::where('id',$id)->update($new);

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
