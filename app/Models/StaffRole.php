<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class StaffRole extends Model
{
    use HasFactory;
	
	protected $table='staff_roles';
	
	protected $fillable = ['id','role_id','role_name','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//------------fucntions------------------------------
	
	public const RULES=[
	   'role_name'=>'required|unique:staff_roles',
	   'role_id'=>'required',
	];
	
	public const EDIT_RULES=[
	   'ed_role_name'=>'required',
	   'ed_role_id'=>'required',
	];
	
	public function addStaffRole($request)
	{
		return self::create([
		'role_id'=>Str::upper($request->role_id),
		'role_name'=>Str::upper($request->role_name),
		'added_by'=>Session::get('admin_id'),
		'status'=>1,
		]);
	}
		
	public function updateStaffRole($request)
	{

		$id=$request->st_role_id;

		$dat=[
		  'role_id'=>Str::upper($request->ed_role_id),
		  'role_name'=>Str::upper($request->ed_role_name),
		  'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);

		return $result;
		
	}

public function viewStaffRoles($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('staff_roles.*','roles.role','admins.name')
		->leftJoin('roles','staff_roles.role_id','=','roles.id')
		->leftJoin('admins','staff_roles.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("staff_roles.role_name", 'like', '%' .$search . '%')
					->orWhere("roles.role", 'like', '%' .$search . '%');
			  })->orderBy('staff_roles.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = $r->id;
				$uData['role'] =$r->role;
				$uData['rname'] =$r->role_name;
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getStaffRoles()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getStaffRoleById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	 public function deleteStaffRole($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}



	
	
}
