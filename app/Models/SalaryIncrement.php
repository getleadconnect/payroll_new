<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use DB;
use Session;

class SalaryIncrement extends Model
{
    use HasFactory;
	
	protected $table='salary_increments';
	
	protected $fillable = ['id','staff_id','salary_date','old_salary','current_salary',
	'percentage','increment','ot_rate','sunday_rate','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'salary_date'=>'required',
	'staff_id'=>'required',
	'old_salary'=>'required',
	'current_salary'=>'required',
	'increment'=>'required',
	'ot_rate'=>'required',
	'sunday_rate'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_salary_date'=>'required',
	'ed_old_salary'=>'required',
	'ed_current_salary'=>'required',
	'ed_increment'=>'required',
	'ed_ot_rate'=>'required',
	'ed_sunday_rate'=>'required',
	];
	
	public function addSalaryIncrement($request)
	{
		DB::beginTransaction();
		try
		{
		
		$new=['status'=>0];
		$res=SalaryIncrement::where('staff_id',$request->staff_id)->update($new);
				
		$result=self::create([
			'staff_id'=>$request->staff_id,
			'old_salary'=>$request->old_salary,
			'percentage'=>$request->percentage??0,
			'increment'=>$request->increment,
			'current_salary'=>$request->current_salary,
			'salary_date'=>$request->salary_date,
			'ot_rate'=>$request->ot_rate,
			'sunday_rate'=>$request->sunday_rate,
			'added_by'=>Session::get('admin_id'),
			'status'=>1,
			]);
			
			DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollBack();
			$result=$e->errorInfo[1];
		}
		return $result;
		
	}
		
	public function updateSalaryIncrement($request)
	{
		
		$id=$request->ed_salary_id;

		$dat=[
		'old_salary'=>$request->ed_old_salary,
		'percentage'=>$request->ed_percentage,
		'increment'=>$request->ed_increment,
		'current_salary'=>$request->ed_current_salary,
		'salary_date'=>$request->ed_salary_date,
		'ot_rate'=>$request->ed_ot_rate,
		'sunday_rate'=>$request->ed_sunday_rate,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}



public function viewSalaryIncrements($request)  //view data
	{

		$search=$request->search;
		$searchByStaff=$request->searchByStaff;
		
		$dts=self::query();

		$dts->select('salary_increments.*','staffs.id as sta_id','staffs.name','staff_roles.role_name','admins.name as user_name')
		->leftJoin('staffs','salary_increments.staff_id','=','staffs.id')
		->leftJoin('staff_roles','staffs.staff_role_id','=','staff_roles.id')
		->leftJoin('admins','salary_increments.added_by','=','admins.id')
		->where(function($where) use($search)
			  {
				$where->where("staffs.name", 'like', '%' .$search . '%')
					->orWhere("staff_roles.role_name", 'like', '%' .$search . '%')
					->orWhere("salary_increments.old_salary", 'like', '%' .$search . '%')
					->orWhere("admins.name", 'like', '%' .$search . '%')
					->orWhere("salary_increments.current_salary", 'like', '%' .$search . '%');
			  });
			  
		if($searchByStaff!="")
		{
			$dts->where('salary_increments.staff_id',$searchByStaff);  //to display all increment entries
		}
		else
		{
			$dts->where('salary_increments.status',1);   //to display active current salary only for each staff
		}
		
		$dats=$dts->orderByRaw('salary_increments.id DESC, salary_increments.staff_id ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			//$staf_id=$dats[0]->id;
			foreach ($dats as $key=>$r)
            {
				$uData['id'] =++$key;
				$uData['sdt'] =date_create($r->salary_date)->format('d-m-Y');
				$uData['name'] =$r->name;
				$uData['role'] =$r->role_name;
				$uData['old_sal']=number_format($r->old_salary,2,'.',',');
				$uData['salary']=number_format($r->current_salary,2,'.',',');
				$uData['per']=$r->percentage."%";
				$uData['inc']=number_format($r->increment,2,'.',',');
				$uData['otr']=number_format($r->ot_rate,2,'.',',');
				$uData['srate']=number_format($r->sunday_rate,2,'.',',');
				$uData['addedby']=$r->user_name;
				
				if($r->status==1)
				{
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
				      <a href="javascript:void(0)" id="'.$r->id.'" data-val="'.$r->staff_id.'" class="btndel btn-outline-danger shadow btn-b-sm" title="delete"><i class="fa fa-trash"></i></a>'; 
				}
				else
				{
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm" title="delete"><i class="fa fa-trash"></i></a>'; 
				}					
				
				$uData['action'] = $btn;
			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSalaryIncrements()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSalaryIncrementById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function get_Salary_Increment_By_Id($id)
	{
		$data=self::select('salary_increments.*','staffs.name')
		->leftJoin('staffs','salary_increments.staff_id','=','staffs.id')
		->where('salary_increments.id',$id)->first();
		return $data;
	}
	
	

	public function deleteSalaryIncrement($id,$st_id)
	{
				
		DB::beginTransaction();
		try
		{
		
			$dat=self::find($id);
			$result=$dat->delete();
			
			$new=['status'=>1];
			
			$res=SalaryIncrement::where('staff_id',$st_id)->orderBy('id','DESC')->first();
			if(!empty($res))
			{
				$result=self::where('id',$res->id)->update($new);
			}
			
			DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollBack();
			$result=$e->errorInfo[1];
		}

		return $result;
	}


	

}
