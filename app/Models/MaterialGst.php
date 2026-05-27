<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class MaterialGst extends Model
{
    use HasFactory;
	
	protected $table='material_gst';
	
	protected $fillable = ['id','material_type_id','gst','gst_date','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'material_type_id'=>'required',
	'gst'=>'required',
	'gst_date'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_material_type_id'=>'required',
	'ed_gst'=>'required',
	'ed_gst_date'=>'required',
	];
	
	public function addMaterialGst($request)
	{
		return self::create([
		'material_type_id'=>$request->material_type_id,
		'gst'=>$request->gst,
		'gst_date'=>$request->gst_date,
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateMaterialGst($request)
	{
		
		$id=$request->ed_mat_gst_id;

		$dat=[
		'material_type_id'=>$request->ed_material_type_id,
		'gst'=>$request->ed_gst,
		'gst_date'=>$request->ed_gst_date,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialGst($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('material_gst.*','material_types.material_type_name','admins.name')
		->leftJoin('material_types','material_gst.material_type_id','=','material_types.id')
		->leftJoin('admins','material_gst.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("material_gst.gst", 'like', '%' .$search . '%');
			  })->orderBy('material_gst.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['mtname'] =$r->material_type_name;
					$uData['gst'] =$r->gst."%";
					$uData['gdt'] =date_create($r->gst_date)->format('d-m-Y');
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialGst()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialGstById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialGst($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
