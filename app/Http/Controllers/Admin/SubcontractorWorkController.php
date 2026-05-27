<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\SubcontractorRate;
use App\Models\Subcontractor;
use App\Models\SubcontractorItem;
use App\Models\Company;
use App\Models\Project;
use App\Models\MaterialUnit;
use App\Models\SubcontractorWork;
use App\Models\FloorNo;
use App\Models\MainCostCenter;

use Validator;
use DataTables;
use Session;
use Carbon\Carbon;


class SubcontractorWorkController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$scon=(new Subcontractor())->getSubcontractors();
	$comp=(new Company())->getCompany();
	
	$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
	$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();
	
    return view('admin.subcontractor_works.subcontractor_works',compact('comp','scon','start_date','thu_date'));
  }
  
  public function add_subcontractor_works()
  {
	$projs=(new Project())->getProjects();	
	$floors=(new FloorNo())->getFloors();	
	$units=(new MaterialUnit())->getMaterialUnitsforSelect();	
    return view('admin.subcontractor_works.add_subcontractor_works',compact('floors','projs','units'));
  }
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SubcontractorWork::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing11, try again.');
			return back()->withErrors($validate)->withInput();
		}

		/*$where1=['entry_date'=>Date('Y-m-d'),'subcontractor_rate_id'=>$request->item_name];
		$cnt=SubcontractorWork::where($where1)->count();
		if($cnt>0){
			Session::flash('message', 'danger#Sub-contractor work already added.');
			return back()->withErrors($validate)->withInput();
		}
		else
		{*/
				$result=(new SubcontractorWork())->addSubcontractorWork($request);
			
			if($result)
			{
				Session::flash('message', 'success#Subcontractor work successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing22, try again.');
			}
			
		/*}*/
			return redirect('add-subcontractor-works');
	}
	
	
	public function edit($id)
	{
		$sc=(new SubcontractorWork())->getSubcontractorWorkById($id);
		$scon=(new Subcontractor())->getSubcontractors();
		$sitems=$this->get_subcontractor_rate_items($sc->subcontractor_id,$sc->project_id,2);
		$floors=(new FloorNo())->getFloors();
		$unit=MaterialUnit::where('id',$sc->material_unit_id)->first();
		
		return view('admin.subcontractor_works.edit_subcontractor_work',compact('floors','sc','scon','sitems','unit'));
	}
		
	 public function update_subcontractor_work(Request $request)
	 {

		$validate=Validator::make($request->all(),SubcontractorWork::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SubcontractorWork())->updateSubcontractorWork($request);

			if($result)
			{
				Session::flash('message', 'success#Sub-contractor work successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('sub-contractor-works');
	}
	
	
   public function destroy($id)
	{

		$result=(new SubcontractorWork())->deleteSubcontractorWork($id);
		
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
            $data = (new SubcontractorWork())->viewSubcontractorWorks($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
		
	
	public function get_subcontractor_rate_items($id,$pid,$op)
	{
		
		$items=SubcontractorRate::select('subcontractor_rates.*','subcontractor_items.item_name')
		  ->leftJoin('subcontractor_items','subcontractor_rates.subcontractor_item_id','=','subcontractor_items.id')
		  ->where('subcontractor_rates.subcontractor_id',$id)
		  ->where('subcontractor_rates.project_id',$pid)->get();
		
		if($op==1)
		{
			$opt="<option value=''>--select--</option>";
			foreach($items as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->item_name."</option>";
			}
			
			return $opt;
		}
		else  //for edit item
		{
			return $items;
		}
	}
	
	
	public function get_sub_contractor_itemunit_rate($rate_id)
	{
		$items=SubcontractorRate::select('subcontractor_rates.*','material_units.id as unit_id','material_units.unit_name','subcontractor_items.item_name')
		  ->leftJoin('subcontractor_items','subcontractor_rates.subcontractor_item_id','=','subcontractor_items.id')
		  ->leftJoin('material_units','subcontractor_items.material_unit_id','=','material_units.id')
		  ->where('subcontractor_rates.id',$rate_id)->first();

		$data=[];
		
		if(!empty($items))
		{
			$data['rate_id']=$items->id;
			$data['unit']=$items->unit_name;
			$data['unit_id']=$items->unit_id;
			$data['price']=$items->item_rate;
		}
		return json_encode($data);
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

		$result=SubcontractorWork::where('id',$id)->update($new);

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
	
public function get_company_project_names($id)  //sub contractor id 
{
	
	$res=SubcontractorRate::select('company.company_name','projects.project_name')
	->leftJoin('company','subcontractor_rates.company_id','=','subcontractor_rates.company_id')
	->leftJoin('projects','subcontractor_rates.project_id','=','subcontractor_rates.project_id')
	->where('subcontractor_rates.subcontractor_id',$id)->first();
	
	$company="";
	$project="";
	
	if(!empty($res))
	{
		$company=$res->company_name;
		$project=$res->project_name;
	}
	
	return $company."|".$project;
	
}


public function get_subcontractor_items($id)  //sub contractor id 
{
	$sitems=(new SubcontractorItem())->getSubcontractorItemByContractorId($id);
	$opt='<option value="">--select--</option>';

	foreach($sitems as $r)
	{
		$opt.='<option value="'.$r->id.'">'.$r->item_name.'</option>';
	}
	return $opt;
	
}


public function get_subcontractors_by_project($id)  //sub contractor id 
{
	$sitems=SubcontractorRate::select('subcontractors.id','subcontractors.name')
	->join('subcontractors','subcontractor_rates.subcontractor_id','=','subcontractors.id')
	->groupBy('subcontractors.id','subcontractors.name')
	->get();
	
	$opt='<option value="">--select--</option>';

	foreach($sitems as $r)
	{
		$opt.='<option value="'.$r->id.'">'.$r->name.'</option>';
	}
	return $opt;
	
}

public function get_main_cost_center_by_project_floor_id($id,$fid)
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

}
