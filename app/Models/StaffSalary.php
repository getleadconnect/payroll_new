<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
use App\Models\SalaryIncrement;

use DB;
use Session;

class StaffSalary extends Model
{
    use HasFactory;
	
	protected $table='staff_salary';
	
	protected $fillable = ['id','entry_date','project_id','staff_id','month','year','salary','salary_increment_id',
						'normal_ot','sunday_ot','normal_rate','sunday_rate','normal_amt','sunday_amt',
						'leave_no','leave_amt','net_salary','added_by'];
	
	protected $primaryKey="id";

	protected $mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
    
	protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'entry_date'=>'required',
	'project_id'=>'required',
	'staff_id'=>'required',
	'month'=>'required',
	'year'=>'required',
	'salary'=>'required',
	'sunday_ot'=>'required',
	'normal_amt'=>'required',
	'sunday_amt'=>'required',
	'net_salary'=>'required',
	'leave'=>'required'
	];
	
	public const EDIT_RULES=[
	'ed_entry_date'=>'required',
	'ed_project_id'=>'required',
	'ed_staff_id'=>'required',
	'ed_month'=>'required',
	'ed_year'=>'required',
	'ed_salary'=>'required',
	'ed_sunday_ot'=>'required',
	'ed_normal_amt'=>'required',
	'ed_sunday_amt'=>'required',
	'ed_net_salary'=>'required',
	];
	
	public function addStaffSalary($request)
	{
		$res=SalaryIncrement::where('staff_id',$request->staff_id)->orderBy('id','DESC')->first();
		$ot_rate=0;
		$sun_rate=0;
		$sinc_id=null;
		
		if(!empty($res))
		{
			$ot_rate=$res->ot_rate;
			$sun_rate=$res->sunday_rate;
			$sinc_id=$res->id;
		}
		
		$lamt=0;
		if($request->leave>0)
		{
			$lamt=round(($request->salary/30)*$request->leave,0);
		}

		$result=self::create([
			'entry_date'=>$request->entry_date,
			'project_id'=>$request->project_id,
			'staff_id'=>$request->staff_id,
			'month'=>$request->month,
			'year'=>$request->year,
			'salary_increment_id'=>$sinc_id,
			'salary'=>$request->salary,
			'normal_ot'=>$request->normal_ot,
			'sunday_ot'=>$request->sunday_ot,
			'normal_rate'=>$ot_rate,
			'sunday_rate'=>$sun_rate,
			'normal_amt'=>$request->normal_amt,
			'sunday_amt'=>$request->sunday_amt,
			'leave_no'=>$request->leave,
			'leave_amt'=>$lamt,
			'net_salary'=>round($request->net_salary,0),
			'added_by'=>Session::get('admin_id'),
		]);
		
		return $result;

	}
	
		
	public function updateStaffSalary($request)
	{
		
		$id=$request->ed_salary_id;

		$lamt=0;
		if($request->ed_leave_no>0)
		{
			$lamt=round(($request->ed_salary/30)*$request->ed_leave_no,0);
		}
		
		$dat=[
			'entry_date'=>$request->ed_entry_date,
			'project_id'=>$request->ed_project_id,
			'staff_id'=>$request->ed_staff_id,
			'month'=>$request->ed_month,
			'year'=>$request->ed_year,
			'salary_increment_id'=>$request->ed_sal_inc_id,
			'salary'=>$request->ed_salary,
			'normal_ot'=>$request->ed_normal_ot,
			'sunday_ot'=>$request->ed_sunday_ot,
			'normal_rate'=>$request->ed_nrate,
			'sunday_rate'=>$request->ed_srate,
			'normal_amt'=>$request->ed_normal_amt,
			'sunday_amt'=>$request->ed_sunday_amt,
			'leave_no'=>$request->ed_leave_no,
			'leave_amt'=>$lamt,
			'net_salary'=>round($request->ed_net_salary,0),
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function viewStaffSalary($request)  //view data
	{

		$search=$request->search;
		$stid=$request->ByStaffId;
		$mon=$request->ByMonth;
		$yr=$request->ByYear;
		
		$dat=self::query();
		
		$dat->select('staff_salary.*','staffs.name','projects.project_name','admins.name as user_name')
		->leftJoin('staffs','staff_salary.staff_id','=','staffs.id')
		->leftJoin('projects','staff_salary.project_id','=','projects.id')
		->leftJoin('admins','staff_salary.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("staffs.name", 'like', '%' .$search . '%')
						->orWhere("staff_salary.salary", 'like', '%' .$search . '%')
						->orWhere("staff_salary.month", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("staff_salary.year", 'like', '%' .$search . '%');
			  });

		if($stid!="" and $mon!="" and $yr!="")
		{
			$dat->where('staff_salary.staff_id',$stid)->where('staff_salary.month',$mon)->where('staff_salary.year',$yr);
		}
		
		$dats=$dat->orderBy('id','ASC')->get();


		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['pname'] =$r->project_name;
				$uData['name'] =$r->name;
				$uData['sdate'] =date_create($r->entry_date)->format('d-m-Y');
				$uData['month'] =$this->mon[$r->month-1];
				$uData['year'] =$r->year;
				$uData['sal'] =number_format($r->salary,'2','.',',');
				$uData['nhrs'] =$r->normal_ot;
				$uData['shrs'] =$r->sunday_ot;
				$uData['nrate'] =number_format($r->normal_rate,'2','.',',');
				$uData['srate'] =number_format($r->sunday_rate,'2','.',',');
				$uData['namt'] =number_format($r->normal_amt,'2','.',',');
				$uData['samt'] =number_format($r->sunday_amt,'2','.',',');
				$uData['leave'] =$r->leave_no;
				$uData['lamt'] =number_format($r->leave_amt,'2','.',',');
				$uData['net'] =number_format($r->net_salary,'2','.',',');
				
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btnSlip btn-outline-info shadow  btn-b-sm " data-toggle="modal" title="Salary Slip"><i class="fa fa-print"></i></a>'; 

				$uData['action'] = $btn;

			  $data[] = $uData;
			}
        }
		return $data;
	}		
	

	public function getStaffSalary()
	{
		$data=self::where('status',1)->orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getStaffSalaryById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteStaffSalary($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
