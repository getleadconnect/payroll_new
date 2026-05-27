<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\SalaryIncrement;

use DB;
use Session;
use Carbon\Carbon;
use DateTime;

class StaffOverTime extends Model
{
	
	use HasFactory;

	protected $table='staff_over_times';

	protected $fillable = ['id','ot_date','project_id','staff_id','time_in','time_out','normal_ot',
							'sunday_ot','normal_amt','sunday_amt','added_by'];

	protected $primaryKey="id";

	protected $hidden = [
		'created_at',
		'updated_at',
	];
		
 // fucntions -- --------------------------------------------------------- -->
	
	public function addStaffOverTime($request)
	{
		
		try
		{
			$sid=$request->staff_id;
			
			$sal=SalaryIncrement::where('staff_id',$sid)->where('status',1)->orderBy('id','DESC')->first();
			
			$n_ot_amt=0;
			$s_ot_amt=0;
			$ovt="0.0";
			
			if(!empty($sal))
			{

				if($request->start_time!="" And $request->end_time!="")
				{				

					$sTime = Carbon::parse($request->start_time)->addHours(9)->addMinute(30);
					$eTime = Carbon::parse($request->end_time);
					$seconds = $eTime->diffInSeconds($sTime);
					
					$hours = floor($seconds / 3600);
					$mins = floor($seconds / 60 % 60);
					//$secs = floor($seconds % 60);
					$ovt=($hours??0).".".($mins??0);
					
					
					$ot1=$sal->ot_rate*$hours;
					$ot2=($sal->ot_rate/60)*$mins;
					
					$n_ot_amt=round($ot1+$ot2,0); 
				}
				
				$s_ot_amt=$sal->sunday_rate*$request->sunday_ot;
			}
			
			$result=self::create([
				'project_id'=>$request->project_id,
				'staff_id'=>$request->staff_id,
				'ot_date'=>$request->ot_date,
				'time_in'=>$request->start_time,
				'time_out'=>$request->end_time,
				'normal_ot'=>($ovt!=0)?$ovt:"0.0",
				'sunday_ot'=>$request->sunday_ot??0,
				'normal_amt'=>$n_ot_amt,
				'sunday_amt'=>$s_ot_amt,
				'added_by'=>Session::get('admin_id'),
			]);
		}	
		catch(\Exceltion $e)
		{
			$result=0;
		}

		return $result;
	 }


public function UpdateStaffOverTime($request)
	{
		try
		{
			$id=$request->ed_sot_id;
			$sid=$request->ed_staff_id;
			
			$sal=SalaryIncrement::where('staff_id',$sid)->where('status',1)->orderBy('id','DESC')->first();
			$n_ot_amt=0;
			$s_ot_amt=0;
			$ovt="0.0";
			
			if(!empty($sal))
			{
				
				if($request->ed_start_time!="" And $request->ed_end_time!="")
				{				

					$sTime = Carbon::parse($request->ed_start_time)->addHours(9)->addMinute(30);
					$eTime = Carbon::parse($request->ed_end_time);
					$seconds = $eTime->diffInSeconds($sTime);
					
					$hours = floor($seconds / 3600);
					$mins = floor($seconds / 60 % 60);
					//$secs = floor($seconds % 60);
					$ovt=($hours??0).":".$mins??0;
					
					
					$ot1=$sal->ot_rate*$hours;
					$ot2=($sal->ot_rate/60)*$mins;
					
					$n_ot_amt=round($ot1+$ot2,0); 
				}

				$s_ot_amt=$request->ed_sunday_ot*$sal->sunday_rate;
			}
			
			$dat=[
				'project_id'=>$request->ed_project_id,
				'staff_id'=>$request->ed_staff_id,
				'ot_date'=>$request->ed_ot_date,
				'time_in'=>$request->ed_start_time,
				'time_out'=>$request->ed_end_time,
				'normal_ot'=>($ovt!=0)?$ovt:"0.0",
				'sunday_ot'=>$request->ed_sunday_ot,
				'normal_amt'=>$n_ot_amt,
				'sunday_amt'=>$s_ot_amt,
				'added_by'=>Session::get('admin_id'),
			];
			
			$result=self::where('id',$id)->update($dat);
		}	
		catch(\Exceltion $e)
		{
			$result=0;
		}

		return $result;
	 }
	 

 public function viewStaffOverTimes($request)  //view data
	 {

		$search=$request->search;
		$staff_id=$request->byStaff_id;
		$month=$request->byMonth;
		$year=$request->byYear;
		
		if($year==""){$year=date('Y');}
		
		$dts=self::query();
		
		$dts->select('staff_over_times.*','staffs.name','projects.project_name','admins.name as user_name')
		->leftJoin('staffs','staff_over_times.staff_id','=','staffs.id')
		->leftJoin('projects','staff_over_times.project_id','=','projects.id')
		->leftJoin('admins','staff_over_times.added_by','=','admins.id')
		->whereYear('ot_date',$year)
		->where(function($where) use($search)
				{
					$where->where("staffs.name", 'like', '%' .$search . '%')
						->orWhere("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%');
			  });
			  
		if($staff_id!="" and $month!="")
		{
			$dts->where('staff_id',$staff_id)->whereMonth('ot_date',$month);
		}			
		
		$dats=$dts->orderBy('staff_over_times.id','ASC')->get();

		$data = array();
		$uData = array();
		
		if(!empty($dats))
		{
			$ntot=0;
			$stot=0;
			foreach ($dats as $key=>$r)
			{
				$time_in="--";
				$time_out="--";
				
				if($r->time_in!=""){ $time_in=Carbon::createFromFormat('H:i:s', $r->time_in)->format('h:i A');}
				if($r->time_out!=""){ $time_out=Carbon::createFromFormat('H:i:s', $r->time_out)->format('h:i A');}
				
				$uData['id'] = ++$key;
				$uData['pname'] =$r->project_name;
				$uData['sname'] =$r->name;
				$uData['odate'] =date_create($r->ot_date)->format('d-m-Y');
				$uData['stime'] =$time_in;
				$uData['etime'] =$time_out;
				$uData['n_ot_hrs'] =$r->normal_ot;
				$uData['s_ot_hrs'] =$r->sunday_ot;
				$uData['n_ot_amt'] =number_format($r->normal_amt,2,'.',',');
				$uData['s_ot_amt'] =number_format($r->sunday_amt,2,'.',',');
				$uData['addedby'] =$r->user_name;
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" data-toggle="modal" class="edit btn-outline-secondary shadow btn-b-sm" title="Edit"><i class="fa fa-edit"></i></a>
					  <a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;
			    $data[] = $uData;
			}
		}
		
	 return $data;
	}
	
	
	public function getStaffOverTimes()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getStaffOverTimeByid($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
		
	public function getStaffOverTimeByStaffId($id)
	{
		$data=self::where('staff_id',$id);
		return $data;
	}

	public function deleteStaffOverTime($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}


}
