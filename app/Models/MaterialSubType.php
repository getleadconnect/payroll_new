<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MaterialSubType extends Model
{
    use HasFactory;
	
	protected $table='material_sub_types';
	
	protected $fillable = ['id','material_type_id','sub_type_name','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'sub_type_name'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_sub_type_name'=>'required',
	];
	
	public function addMaterialSubType($request)
	{
		return self::create([
		'material_type_id'=>$request->material_type_id,
		'sub_type_name'=>Str::upper($request->sub_type_name),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateMaterialSubType($request)
	{
		
		$id=$request->ed_sub_type_id;

		$dat=[
		'material_type_id'=>$request->ed_material_type_id,
		'sub_type_name'=>Str::upper($request->ed_sub_type_name),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialSubTypes($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('material_sub_types.*','material_types.material_type_name','admins.name')
		->leftJoin('material_types','material_sub_types.material_type_id','=','material_types.id')
		->leftJoin('admins','material_sub_types.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("material_sub_types.sub_type_name", 'like', '%' .$search . '%')
					->orWhere("material_types.material_type_name", 'like', '%' .$search . '%');
			  })->orderBy('material_sub_types.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['mtype'] =$r->material_type_name;
					$uData['stname'] =$r->sub_type_name;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialSubTypes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialSubTypeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialSubType($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	public function getMaterialSubTypeBy_TypeId($id)
	{
		$data=self::where('material_type_id',$id)->orderBy('id','ASC')->get();
		return $data;
	}
	
}
