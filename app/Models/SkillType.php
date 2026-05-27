<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class SkillType extends Model
{
    use HasFactory;
	
	protected $table='skill_types';
	
	protected $fillable = ['id','skill_type','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//------------fucntions------------------------------
	
	public const RULES=[
	   'skill_type'=>'required|unique:skill_types',
	];
	
	public const EDIT_RULES=[
	   'ed_skill_type'=>'required',
	];
	
	public function addSkillType($request)
	{
		return self::create([
		'skill_type'=>Str::upper($request->skill_type),
		'added_by'=>Session::get('admin_id'),
		'status'=>1,
		]);
	}
		
	public function updateSkillType($request)
	{

		$id=$request->ed_skill_type_id;

		$dat=[
		  'skill_type'=>Str::upper($request->ed_skill_type),
		  'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);

		return $result;
		
	}


public function viewSkillTypes($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('skill_types.*','admins.name')
		->leftJoin('admins','skill_types.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("skill_types.skill_type", 'like', '%' .$search . '%');
			  })->orderBy('skill_types.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['sktype'] =$r->skill_type;
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->skill_type.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		


	public function getSkillTypes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSkillTypeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSkillType($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
