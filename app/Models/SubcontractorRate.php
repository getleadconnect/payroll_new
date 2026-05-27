<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class SubcontractorRate extends Model
{
    use HasFactory;
	
	protected $table='subcontractor_rates';
	
	protected $fillable = ['id','project_id','subcontractor_id','subcontractor_item_id','item_date','item_rate','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'subcontractor_id'=>'required',
	'item_id'=>'required',
	'item_date'=>'required',
	'item_rate'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_subcontractor_id'=>'required',
	'ed_item_id'=>'required',
	'ed_item_date'=>'required',
	'ed_item_rate'=>'required',
	];
	
	public function addSubcontractorRate($request)
	{
		return self::create([
		'project_id'=>$request->project_id,
		'subcontractor_id'=>$request->subcontractor_id,
		'subcontractor_item_id'=>$request->item_id,
		'item_date'=>$request->item_date,
		'item_rate'=>$request->item_rate,
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateSubcontractorRate($request)
	{
		
		$id=$request->ed_subcon_rate_id;

		$dat=[
		'project_id'=>$request->ed_project_id,
		'subcontractor_id'=>$request->ed_subcontractor_id,
		'subcontractor_item_id'=>$request->ed_item_id,
		'item_date'=>$request->ed_item_date,
		'item_rate'=>$request->ed_item_rate,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewSubcontractorRates($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->project_id;
		$subcon_id=$request->subcon_id;
	
		$dts=self::query();
		
		$dts->select('subcontractor_rates.*','subcontractors.name','projects.project_name','subcontractor_items.item_name','material_units.unit_name','admins.name as user_name')
		->leftJoin('projects','subcontractor_rates.project_id','=','projects.id')
		->leftJoin('subcontractors','subcontractor_rates.subcontractor_id','=','subcontractors.id')
		->leftJoin('subcontractor_items','subcontractor_rates.subcontractor_item_id','=','subcontractor_items.id')
		->leftJoin('material_units','subcontractor_items.material_unit_id','=','material_units.id')
		->leftJoin('admins','subcontractor_items.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("subcontractors.name", 'like', '%' .$search . '%')
						->orWhere("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("subcontractor_items.item_name", 'like', '%' .$search . '%')
						->orWhere("material_units.unit_name", 'like', '%' .$search . '%');
			  });
			  
		if($project_id!="" and $subcon_id!="")	  
		{
			$dts->where('subcontractor_rates.project_id',$project_id)->where('subcontractor_rates.subcontractor_id',$subcon_id);
		}
		else if($project_id!="" and $subcon_id=="")	  
		{
			$dts->where('subcontractor_rates.project_id',$project_id);
		}
		else if($project_id=="" and $subcon_id!="")	  
		{
			$dts->where('subcontractor_rates.subcontractor_id',$subcon_id);
		}  
			  
		$dats=$dts->orderBy('subcontractor_rates.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['pname'] =$r->project_name;
					$uData['scon'] =$r->name;
					$uData['item'] =$r->item_name;
					$uData['idate'] =date_create($r->item_date)->format('d-m-Y');
					$uData['unit'] =$r->unit_name;
					$uData['irate'] =$r->item_rate;
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSubcontractorRates()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSubcontractorRateById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSubcontractorRate($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
