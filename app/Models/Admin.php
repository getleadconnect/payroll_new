<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use Session;

class Admin extends Authenticatable
{
    use HasFactory;
	
	protected $table='admins';
	
    protected $fillable = [
      'staff_id','name','role_id','staff_role_id','email','mobile','password','status',
    ];

    protected $hidden = [
        'password',
		'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'staff_id'=>'required',
	'name'=>'required',
	'mobile'=>'required',
	'email'=>'required|unique:admins',
	'staff_role'=>'required',
	'password'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_name'=>'required',
	'ed_mobile'=>'required',
	'ed_email'=>'required',
	'ed_staff_role'=>'required',
	];
	
	public const PASS_RULES=[
	'new_password'=>'required',
	'conf_password'=>'required|same:new_password',
	];
	
	
	public function addAdminUser($request)
	{
		$role=StaffRole::select('role_id')->where('id',$request->staff_role)->first();
				
		   $res=self::create([
		    'staff_id'=>$request->staff_id,
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'email'=>$request->email,
			'staff_role_id'=>$request->staff_role,
			'role_id'=>$role->role_id??0,
			'password'=>Hash::make($request->password),
			'status'=>1
			]);
		return $res;
	}
		
	public function updateAdminUser($request)
	{
		$role=StaffRole::select('role_id')->where('id',$request->ed_staff_role)->first();
				
		if($request->ed_password!="")
		{
			$new=[
			'name'=>$request->ed_name,
			'mobile'=>$request->ed_mobile,
			'email'=>$request->ed_email,
			'staff_role_id'=>$request->ed_staff_role,
			'role_id'=>$role->role_id??0,
			'password'=>Hash::make($request->ed_password),
			];
		}
		else
		{
		   $new=[
			'name'=>$request->ed_name,
			'mobile'=>$request->ed_mobile,
			'email'=>$request->ed_email,
			'staff_role_id'=>$request->ed_staff_role,
			'role_id'=>$role->role_id??0,
			];
		}
		
		$res=self::where('id',$request->ed_admin_id)->update($new);
		return $res;
    }
	
	public function deleteAdminUser($id)
	{
		return self::find($id)->delete();
	}
	
	public function getAdminById($id)
	{
		return self::find($id);
	}
		
	public function viewAdminUsers($request)
	{
		
		$search=$request->search;
		
		$dts=self::select('admins.*','staff_roles.role_name')
		->leftJoin('staff_roles','admins.staff_role_id','=','staff_roles.id')
		->where('admins.id','!=',2)
		->where(function($where) use($search)
			    {
					$where->where('admins.name', 'like', '%' .$search . '%')
					->orWhere('admins.email', 'like', '%' .$search . '%')
					->orWhere('admins.mobile', 'like', '%' .$search . '%')
					->orWhere('staff_roles.role_name', 'like', '%' .$search . '%');
			  })->orderBy('admins.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-toggle="modal" class="edit  btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
				<a href="'.url('delete-admin-user').'/'.$r->id.'" id="conf" class=" btn-outline-danger shadow btn-b-sm  mr-1" title="Delete"><i class="fa fa-trash"></i></a>'; 
				if($r->status==1)
				{
					$st='<span class="badge badge-success">Active</span>';
					$btn.='<a href="javascript:void(0)" id="'.$r->id."/2".'" class="btnActDeact btn-outline-warning shadow  mr-1 btn-b-sm" title="Deactivate"><i class="fa fa-times"></i></a>';
				}
				else
				{					
				   $st='<span class="badge badge-danger">Inactive</span>';
				   $btn.='<a href="javascript:void(0)" id="'.$r->id."/1".'" class="btnActDeact btn-outline-success shadow mr-1 btn-b-sm" title="Activate"><i class="fa fa-check"></i></a>'; 	
				}
			
				$uData['id'] = ++$key; //$r->id;
				$uData['stf_id']=$r->staff_id??"--";
				$uData['name']=$r->name;
				$uData['mobile']=$r->mobile;
				$uData['email']=$r->email;
				$uData['role']=$r->role_name;
				$uData['status']=$st;
				
				if($r->staff_role_id==1)
				{
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-toggle="modal" class="changePass  btn-outline-info shadow btn-b-sm" data-toggle="modal"  title="Change Password"><i class="fa fa-key"></i></a>';
				}
				
				$uData['action']=$btn;
						
				$data[] = $uData;
			}
        }

		return $data;
	}
	
	
	
}
