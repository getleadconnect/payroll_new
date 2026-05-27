<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MainCostCenter extends Model
{
    use HasFactory;
	
	protected $table='main_cost_center';
	
	protected $fillable = ['id','project_id','main_cost_item_id','floor_no_id','schedule_qty','schedule_amount','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'main_cost_item_id'=>'required',
	'floor_no_id'=>'required',
	'schedule_qty'=>'required',
	'schedule_amount'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_main_cost_item_id'=>'required',
	'ed_floor_no_id'=>'required',
	'ed_schedule_qty'=>'required',
	'ed_schedule_amount'=>'required',
	];
	
	public function addMainCostCenter($request)
	{
		return self::create([
		  'project_id'=>$request->project_id,
		  'main_cost_item_id'=>$request->main_cost_item_id,
		  'floor_no_id'=>$request->floor_no_id,
		  'schedule_qty'=>$request->schedule_qty,
		  'schedule_amount'=>$request->schedule_amount,
		  'added_by'=>Session::get('admin_id'),
		]);
	}
		
	public function updateMainCostCenter($request)
	{
		
		$id=$request->ed_schedule_id;

		$dat=[
		  'project_id'=>$request->ed_project_id,
		  'main_cost_item_id'=>$request->ed_main_cost_item_id,
		  'floor_no_id'=>$request->ed_floor_no_id,
		  'schedule_qty'=>$request->ed_schedule_qty,
		  'schedule_amount'=>$request->ed_schedule_amount,
		  'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMainCostCenters($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->project_id;
		$dts=self::query();
		
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
				
				$uData['id'] = ++$key;
				$uData['proj'] =$r->project_name;
				$uData['mitem'] =$r->main_item;
				$uData['floorno'] =$r->floor_no;
				$uData['sqty'] =$r->schedule_qty;
				//$uData['samt'] =number_format($r->schedule_amount,2,'.',',');
				$uData['samt'] =$r->schedule_amount;
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				$uData['action'] = $btn;
				$data[] = $uData;
				$tot+=$r->schedule_amount;
			}
			
			$data['total_amount']=number_format($tot,2,'.',',');
        }
		return $data;
	}		


	public function getMainCostCenter()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMainCostCenterById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function getMainCostCenterByProjectId($id)
	{
		$data=self::select('main_cost_center.*','main_cost_items.main_item')
		->leftJoin('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
		->where('project_id',$id)->orderBy('main_cost_center.id','ASC')->get();
		return $data;
	}
	
	
	public function getMainCostCenterByProjectIdFloorId($id,$flid)
	{
		$data=self::select('main_cost_center.*','main_cost_items.main_item')
		->leftJoin('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
		->where('project_id',$id)->where('floor_no_id',$flid)
		->orderBy('main_cost_center.id','ASC')->get();
		return $data;
	}

	public function deleteMainCostCenter($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
