<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
use App\Models\SalaryIncrement;

use DB;
use Session;

class Staff extends Model
{
    use HasFactory;
	
	protected $table='staffs';
	
	protected $fillable = ['id','join_date','name','address','gender','email','mobile','qualification',
	'experience','staff_role_id','aadhar_no','bank_name','bank_ifsc','bank_account_no',
	'state','district','nationality','status','added_by'];
	
	protected $primaryKey="id";

	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'join_date'=>'required',
	'name'=>'required',
	'address'=>'required',
	'gender'=>'required',
	'mobile'=>'required',
	'email'=>'required',
	'qualification'=>'required',
	'experience'=>'required',
	'staff_role_id'=>'required',
	'aadhar_no'=>'required',
	'bank_name'=>'required',
	'bank_ifsc'=>'required',
	'bank_account_no'=>'required',
	'state'=>'required',
	'district'=>'required',
	'nationality'=>'required',
	];

	
	public function addStaff($request)
	{
		
		DB::beginTransaction();
		try
		{
			  $result=self::create([
				'join_date'=>$request->join_date,
				'name'=>Str::upper($request->name),
				'address'=>Str::upper($request->address),
				'gender'=>Str::upper($request->gender),
				'mobile'=>$request->mobile,
				'email'=>$request->email,
				'qualification'=>Str::upper($request->qualification),
				'experience'=>Str::upper($request->experience),
				'staff_role_id'=>$request->staff_role_id,
				'aadhar_no'=>$request->aadhar_no,
				'bank_name'=>Str::upper($request->bank_name),
				'bank_ifsc'=>Str::upper($request->bank_ifsc),
				'bank_account_no'=>$request->bank_account_no,
				'state'=>Str::upper($request->state),
				'district'=>Str::upper($request->district),
				'nationality'=>Str::upper($request->nationality),
				'added_by'=>Session::get('admin_id'),
				'status'=>1,
			]);
						
			$staff_id=$result->id;
			
			$res=SalaryIncrement::create([
			'salary_date'=>$request->join_date,
			'staff_id'=>$staff_id,
			'old_salary'=>$request->salary,
			'current_salary'=>$request->salary,
			'percentage'=>0,
			'increment'=>0,
			'ot_rate'=>$request->ot_rate,
			'sunday_rate'=>$request->sunday_rate,
			'status'=>1,
			'added_by'=>Session::get('admin_id'),
			]);
					
			DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollBack();
			$result=0;
		}
		
		return $result;
	}
	
	public function updateStaff($request)
	{
		
		$id=$request->staff_id;

		$dat=[
			'join_date'=>$request->join_date,
			'name'=>Str::upper($request->name),
			'address'=>Str::upper($request->address),
			'gender'=>Str::upper($request->gender),
			'mobile'=>$request->mobile,
			'email'=>$request->email,
			'qualification'=>Str::upper($request->qualification),
			'experience'=>Str::upper($request->experience),
			'staff_role_id'=>$request->staff_role_id,
			'aadhar_no'=>$request->aadhar_no,
			'bank_name'=>Str::upper($request->bank_name),
			'bank_ifsc'=>Str::upper($request->bank_ifsc),
			'bank_account_no'=>$request->bank_account_no,
			'state'=>Str::upper($request->state),
			'district'=>Str::upper($request->district),
			'nationality'=>Str::upper($request->nationality),
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewStaffs($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('staffs.*','staff_roles.role_name','admins.name as user_name')
		->leftJoin('staff_roles','staffs.staff_role_id','=','staff_roles.id')
		->leftJoin('admins','staffs.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("staffs.name", 'like', '%' .$search . '%')
						->orWhere("staffs.gender", 'like', '%' .$search . '%')
						->orWhere("staffs.mobile", 'like', '%' .$search . '%')
						->orWhere("staffs.address", 'like', '%' .$search . '%')
						->orWhere("staffs.bank_name", 'like', '%' .$search . '%')
						->orWhere("staffs.aadhar_no", 'like', '%' .$search . '%')
						->orWhere("staffs.bank_account_no", 'like', '%' .$search . '%');
			  })->orderBy('id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				$sal=SalaryIncrement::where('staff_id',$r->id)->orderBy('id','DESC')->first();
				if(!empty($sal)){ $salary=$sal->current_salary;}else{$salary=0;}
				
				if($r->status==1)
				{
					$st='<span class="badge badge-info">Active</span>';
					$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning shadow btn-b-sm" title="Deactivate Supplier"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
				}
				else 
				{
					$st='<span class="badge badge-danger">Inactive</span>';
					$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm" title="Activate Supplier"><i class="fa fa-check"></i></a>';
				}
				
				$uData['id'] = ++$key;
				$uData['name'] =$r->name;
				$uData['mob'] ="<i class='fas fa-mobile'></i>: ".$r->mobile."<br><i class='fas fa-envelope'></i>: ".$r->email;
				$uData['quali'] =$r->qualification;
				$uData['aadhar'] =$r->aadhar_no;
				$uData['role'] =$r->role_name;
				$uData['sal'] =number_format($salary,'2','.',',');
				$uData['status'] =$st;
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="'.url('edit-staff')."/".$r->id.'" class=" btn-outline-secondary shadow btn-b-sm"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>
					  <a href="javascript:void(0)" id="'.$r->id.'" class="btnview btn-outline-info shadow btn-b-sm" data-toggle="modal"  title="View Details"><i class="fa fa-eye"></i></a> '; 

				$uData['action'] = $btn.$btns;

			  $data[] = $uData;
			}
        }
		return $data;
	}		
	
	
	public function getAvailableStaffs()
	{
		$data=self::where('status',1)->where('available',0)->orderBy('id','ASC')->get();
		return $data;
	}

	public function getStaffs()
	{
		$data=self::where('status',1)->orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getStaffById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteStaff($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}


	
		
}
