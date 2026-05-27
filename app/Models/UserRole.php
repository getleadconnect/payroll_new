<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class UserRole extends Model
{
    use HasFactory;
	
	protected $table='user_roles';
	
	protected $fillable = ['id','role','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//------------fucntions------------------------------
	
	public const RULES=[
	   'role'=>'required|unique:staff_roles',
	];
	
	public const EDIT_RULES=[
	   'ed_role'=>'required',
	];
	
	public function addUserRole($request)
	{
		return self::create([
		'role'=>Str::upper($request->role),
		'added_by'=>Session::get('admin_id'),
		]);
	}
		
	public function updateUserRole($request)
	{

		$id=$request->ed_role_id;

		$dat=[
		  'role'=>Str::upper($request->ed_role),
		  'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);

		return $result;
		
	}

public function viewStaffRoles($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('staff_roles.*','admins.name')
		->leftJoin('admins','staff_roles.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("staff_roles.role", 'like', '%' .$search . '%');
			  })->orderBy('staff_roles.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['role'] =$r->role;
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->role.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
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
