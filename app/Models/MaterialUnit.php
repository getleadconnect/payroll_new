<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MaterialUnit extends Model
{
    use HasFactory;
	
	protected $table='material_units';
	
	protected $fillable = ['id','unit_name','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'unit_name'=>'required|unique:material_units',
	];
	
	public const EDIT_RULES=[
	'ed_unit_name'=>'required',
	];
	
	public function addMaterialUnit($request)
	{
		return self::create([
		'unit_name'=>Str::upper($request->unit_name),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateMaterialUnit($request)
	{
		
		$id=$request->ed_mat_unit_id;

		$dat=[
		'unit_name'=>Str::upper($request->ed_unit_name),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialUnits($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('material_units.*','admins.name')
		->leftJoin('admins','material_units.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("material_units.unit_name", 'like', '%' .$search . '%')
					->orWhere("admins.name", 'like', '%' .$search . '%');
			  })->orderBy('material_units.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['uname'] =$r->unit_name;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->unit_name.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialUnits()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialUnitById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialUnit($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	public function getMaterialUnitsforSelect()
	{
		$data=self::orderBy('id','ASC')->get();
		$opt="<option value=''>-select-</option>";
		
		foreach($data as $r)
		{
			$opt.="<option value='".$r->id."'>".$r->unit_name."</option>";
		}

		return $opt;
	}
	
}
