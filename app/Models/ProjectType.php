<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class ProjectType extends Model
{
    use HasFactory;
	
	protected $table='project_types';
	
	protected $fillable = ['id','project_type','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_type'=>'required|unique:project_types',
	];
	
	public const EDIT_RULES=[
	'ed_project_type'=>'required',
	];
	
	public function addProjectType($request)
	{
		return self::create([
		'project_type'=>Str::upper($request->project_type),
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateProjectType($request)
	{
		
		$id=$request->ed_project_type_id;

		$dat=[
		'project_type'=>Str::upper($request->ed_project_type),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewProjectTypes($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('project_types.*','admins.name')
		->leftJoin('admins','project_types.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("project_types.project_type", 'like', '%' .$search . '%');
			  })->orderBy('project_types.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					$uData['id'] = ++$key;
					$uData['ptype'] =$r->project_type;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->project_type.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow  btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getProjectTypes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getProjectTypeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteProjectType($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
