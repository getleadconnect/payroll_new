<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class SubcontractorItem extends Model
{
    use HasFactory;
	
	protected $table='subcontractor_items';
	
	protected $fillable = ['id','item_name','material_unit_id','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'unit_id'=>'required',
	'item_name'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_unit_id'=>'required',
	'ed_item_name'=>'required',
	];
	
	public function addSubContractorItem($request)
	{
		return self::create([
		'material_unit_id'=>$request->unit_id,
		'item_name'=>Str::upper($request->item_name),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateSubContractorItem($request)
	{
		
		$id=$request->ed_subcon_item_id;

		$dat=[
		'material_unit_id'=>$request->ed_unit_id,
		'item_name'=>Str::upper($request->ed_item_name),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewSubcontractorItems($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('subcontractor_items.*','material_units.unit_name','admins.name')
		->leftJoin('material_units','subcontractor_items.material_unit_id','=','material_units.id')
		->leftJoin('admins','subcontractor_items.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("subcontractor_items.item_name", 'like', '%' .$search . '%')
						->orWhere("material_units.unit_name", 'like', '%' .$search . '%');
			  })->orderBy('subcontractor_items.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['item'] =$r->item_name;
					$uData['unit'] =$r->unit_name;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSubcontractorItems()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSubcontractorItemById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSubcontractorItem($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

		
}
