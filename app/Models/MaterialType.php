<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MaterialType extends Model
{
    use HasFactory;
	
	protected $table='material_types';
	
	protected $fillable = ['id','material_type_name','hsn_no','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'material_type_name'=>'required',
	'hsn_no'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_material_type_name'=>'required',
	'ed_hsn_no'=>'required',
	];
	
	public function addMaterialType($request)
	{
		return self::create([
		'material_type_name'=>Str::upper($request->material_type_name),
		'hsn_no'=>$request->hsn_no,
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateMaterialType($request)
	{
		
		$id=$request->ed_mat_type_id;

		$dat=[
		'material_type_name'=>Str::upper($request->ed_material_type_name),
		'hsn_no'=>$request->ed_hsn_no,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialTypes($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('material_types.*','admins.name')
		->leftJoin('admins','material_types.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("material_types.material_type_name", 'like', '%' .$search . '%');
			  })->orderBy('material_types.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['mtname'] =$r->material_type_name;
					$uData['hsn'] =$r->hsn_no;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->material_type_name.'" data-hsn="'.$r->hsn_no.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialTypes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialTypeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialType($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
