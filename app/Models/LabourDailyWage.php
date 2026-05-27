<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;

class LabourDailyWage extends Model
{
    use HasFactory;
	
	protected $table='labour_daily_wages';
	
	protected $fillable = ['id','entry_date','project_id','labour_id','floor_no_id','main_cost_center_id','work_type',
				'normal_hour','concrete_hour','normal_wage','concrete_wage','normal_ot','concrete_ot','amt_oh','amt_ch',
				'otn_hrs','otc_hrs','amt_otn','amt_otc','total_wage','added_by'
			];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'labour_id'=>'required',
	'main_cost_center_id'=>'required',
	'floor_no'=>'required',
	'work_type'=>'required',
	'working_hour'=>'required',
	'amt_oh'=>'required',
	'amt_ch'=>'required',
	'total_wage'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_labour_id'=>'required',
	'ed_main_cost_center_id'=>'required',
	'ed_work_type'=>'required',
	'ed_working_hour'=>'required',
	'ed_over_time'=>'required',
	];
	
	
	public function addLabourDailyWage($request)
	{
		
		$edate=date('Y-m-d');
		$pro_id=$request->project_id;
		$mcc_id=$request->main_cost_center_id;
		$floor_id=$request->floor_no;
		
		$lbr_ids=$request->labour_id;
		$wtype=$request->work_type;
		$whrs=$request->working_hrs;
		$otime=$request->over_time;
		
		$result=false;
		
		try
		{
		
		  foreach($lbr_ids as $key=>$r)
		  {
			$lwage=LabourWage::where('labour_id',$r)->orderBy('id','DESC')->first();

			if(!empty($lwage))			
			{
				
				if($wtype[$key]==1)  //overtime,wage and total wage 
				{
					$amt_oh=$lwage->wage_normal;  //8 hrs wage
					$amt_ch=0;
					$amt_otn=0;
					
					if($whrs[$key]==4){
						$amt_oh=round($lwage->wage_normal/2,0);	
						}
					
					if($otime[$key]>0)
					  {

						$hr=explode(".",number_format($otime[$key],2,'.',''));
						$ot=round((($lwage->wage_normal/8)*$lwage->wage_ot),0);
						$ot1=$ot*$hr[0];
						$ot2=($ot/60)*($hr[1]??0);
						$amt_otn=round($ot1,0)+round($ot2,0); 
					  }

					$amt_otc=0;
					$nor_hrs=$whrs[$key];
					$con_hrs=0;
					
					$otn_hrs=$otime[$key];
					$otc_hrs=0;
					
					if($whrs[$key]==0)
					{
						$amt_oh=0;
						$amt_ch=0;
						$total_wage=$amt_otn;   //over time only
					}
					else
					{
						$total_wage=$amt_oh+$amt_otn;  //overtime + daily wage
					}
					
				}
				else if($wtype[$key]==2)
				{
					$amt_ch=$lwage->wage_concrete;   //4hrs wage
					$amt_oh=0;
					
					if($whrs[$key]==4){	
					  $amt_ch=round($lwage->wage_concrete/2,0);			
					}
					$con_hrs=$whrs[$key];
					$nor_hrs=0;
					$otc_hrs=$otime[$key];
					$otn_hrs=0;
					$amt_otn=0;
					$amt_otc=0;
					
					if($otime[$key]>0)
					{
						$hr=explode(".",number_format($otime[$key],2,'.',''));
						$ot=round((($lwage->wage_concrete/8)*$lwage->wage_ot),0);
						$ot1=$ot*$hr[0];
						$ot2=($ot/60)*($hr[1]??0);
						$amt_otc=round($ot1,0)+round($ot2,0); 
					}

					if($whrs[$key]==0)
					{
						$amt_oh=0;
						$amt_ch=0;
						$total_wage=$amt_otc;  //over time value only
					}
					else
					{
						$total_wage=$amt_ch+$amt_otc;
					}
				}

				$dat=[
				'entry_date'=>$edate,
				'labour_id'=>$r,
				'project_id'=>$pro_id,
				'main_cost_center_id'=>$mcc_id,
				'floor_no_id'=>$floor_id,
				'work_type'=>$wtype[$key],
				'normal_hour'=>$nor_hrs,
				'concrete_hour'=>$con_hrs,
				'normal_wage'=>$lwage->wage_normal,
				'concrete_wage'=>$lwage->wage_concrete,
				'normal_ot'=>round((($lwage->wage_normal/8)*$lwage->wage_ot),0),
				'concrete_ot'=>round((($lwage->wage_concrete/8)*$lwage->wage_ot),0),
				'otn_hrs'=>$otn_hrs,
				'otc_hrs'=>$otc_hrs,
				'amt_oh'=>$amt_oh,
				'amt_ch'=>$amt_ch,
				'amt_otn'=>$amt_otn,
				'amt_otc'=>$amt_otc,
				'total_wage'=>$total_wage,
				'added_by'=>Session::get('admin_id'),
				];
				
				$where=['labour_id'=>$r,'project_id'=>$pro_id];  //replace existing data
				$res=LabourDailyWage::where($where)->whereDate('entry_date','=',$edate)->count();

				if($res>0)
				{
					$result=LabourDailyWage::where($where)->whereDate('entry_date','=',$edate)->update($dat);
				}
				else
				{
					$result=LabourDailyWage::create($dat);	
				}
			 }
		  }
		}
		catch(\Exception $e)
		{
			$result=false;
		}

		return $result;
	}
	
	
	public function updateLabourDailyWage($request)
	{
		
		$ldw_id=$request->ed_wage_id;

		$pro_id=$request->ed_project_id;
		$mcc_id=$request->ed_main_cost_center_id;
		$floor_id=$request->ed_floor_no;
		
		$lbr_id=$request->ed_labour_id;
		$wtype=$request->ed_work_type;
		$whrs=$request->ed_working_hour;
		$otime=$request->ed_over_time;
		
		$result=false;
		
		try
		{
		  
			$lwage=LabourWage::where('labour_id',$lbr_id)->orderBy('id','DESC')->first();

			if(!empty($lwage))			
			{
				if($wtype==1)  //overtime,wage and total wage 
				{
					$amt_oh=$lwage->wage_normal;  //8 hrs wage
					$amt_ch=0;
					$amt_otn=0;
					
					if($whrs==4){
						$amt_oh=round($lwage->wage_normal/2,0);	
						}
					
					if($otime>0)
					  {
						$otv=round((($lwage->wage_normal/8)*$lwage->wage_ot),0);
						$amt_otn=round(($otv*$otime),0); 
					  }

					$amt_otc=0;
					$nor_hrs=$whrs;
					$con_hrs=0;
					
					$otn_hrs=$otime;
					$otc_hrs=0;
					
					if($whrs==0)  //over time only
					{
						$amt_oh=0;
						$amt_ch=0;
						$total_wage=$amt_otn; //over time only
					}
					else
					{
						$total_wage=$amt_oh+$amt_otn;
					}
					
				}
				else if($wtype==2)
				{
					$amt_ch=$lwage->wage_concrete;   //8hrs wage
					$amt_oh=0;
					
					if($whrs==4){	
					  $amt_ch=round($lwage->wage_concrete/2,0);			
					}
					$con_hrs=$whrs;
					$nor_hrs=0;
					$otc_hrs=$otime;
					$otn_hrs=0;
					$amt_otn=0;
					$amt_otc=0;
					
					if($otime>0)
					{
						$otv=round((($lwage->wage_concrete/8)*$lwage->wage_ot),0);
						$amt_otc=round(($otv*$otime),0);
					}
					if($whrs==0)  //over time only
					{
						$amt_oh=0;
						$amt_ch=0;
						$total_wage=$amt_otc; //over time only
					}
					else
					{
						$total_wage=$amt_ch+$amt_otc;
					}
				}

				//super admin edit
				if(Session::get('admin_role_id')==1  && $request->has('ed_entry_date') && $request->filled('ed_entry_date'))
				{

					$dat=[
						'entry_date'=>$request->ed_entry_date,
						'labour_id'=>$lbr_id,
						'project_id'=>$pro_id,
						'main_cost_center_id'=>$mcc_id,
						'floor_no_id'=>$floor_id,
						'work_type'=>$wtype,
						'normal_hour'=>$nor_hrs,
						'concrete_hour'=>$con_hrs,
						'normal_wage'=>$lwage->wage_normal,
						'concrete_wage'=>$lwage->wage_concrete,
						'normal_ot'=>round((($lwage->wage_normal/8)*$lwage->wage_ot),0),
						'concrete_ot'=>round((($lwage->wage_concrete/8)*$lwage->wage_ot),0),
						'otn_hrs'=>$otn_hrs,
						'otc_hrs'=>$otc_hrs,
						'amt_oh'=>$amt_oh,
						'amt_ch'=>$amt_ch,
						'amt_otn'=>$amt_otn,
						'amt_otc'=>$amt_otc,
						'total_wage'=>$total_wage,
						'added_by'=>Session::get('admin_id'),
					];
				}
				else   //users edit (today)
				{
					$dat=[
						'labour_id'=>$lbr_id,
						'project_id'=>$pro_id,
						'main_cost_center_id'=>$mcc_id,
						'floor_no_id'=>$floor_id,
						'work_type'=>$wtype,
						'normal_hour'=>$nor_hrs,
						'concrete_hour'=>$con_hrs,
						'normal_wage'=>$lwage->wage_normal,
						'concrete_wage'=>$lwage->wage_concrete,
						'normal_ot'=>round((($lwage->wage_normal/8)*$lwage->wage_ot),0),
						'concrete_ot'=>round((($lwage->wage_concrete/8)*$lwage->wage_ot),0),
						'otn_hrs'=>$otn_hrs,
						'otc_hrs'=>$otc_hrs,
						'amt_oh'=>$amt_oh,
						'amt_ch'=>$amt_ch,
						'amt_otn'=>$amt_otn,
						'amt_otc'=>$amt_otc,
						'total_wage'=>$total_wage,
						'added_by'=>Session::get('admin_id'),
					];
				}
						
				$result=LabourDailyWage::where('id',$ldw_id)->update($dat);
			 }
		}
		catch(\Exception $e)
		{
			$result=false;
		}

		return $result;
	}
	
	


public function viewLabourDailyWages($request)  //view data
	{

		$search=$request->search;
		$admin_id=Session::get('admin_id');
		$role_id=Session::get('admin_role_id');
		
		$dts=self::query();
		
		if($role_id!=1)
		{
			$dts->select('labour_daily_wages.*','projects.project_name','labours.code','labours.name','admins.name as user_name')
			->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
			->leftJoin('projects','labour_daily_wages.project_id','=','projects.id')
			->leftJoin('admins','labour_daily_wages.added_by','=','admins.id')
			->where('labour_daily_wages.entry_date',date('Y-m-d'))->where('labour_daily_wages.added_by',$admin_id);
		}
		else
		{
			$dts->select('labour_daily_wages.*','projects.project_name','labours.code','labours.name','admins.name as user_name')
			->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
			->leftJoin('projects','labour_daily_wages.project_id','=','projects.id')
			->leftJoin('admins','labour_daily_wages.added_by','=','admins.id')
			->where('labour_daily_wages.entry_date',date('Y-m-d'));
		}

		$dts->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("labours.name", 'like', '%' .$search . '%')
						->orWhere("labours.code", 'like', '%' .$search . '%')
						->orWhere("labour_daily_wages.entry_date", 'like', '%' .$search . '%');
			  });
			  
		$dats=$dts->orderBy('projects.id','DESC')->get();
			
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['lcode'] =$r->code;
					$uData['edate'] =date_create($r->entry_date)->format('d-m-Y');
					$uData['proj'] =$r->project_name;
					$uData['lbr'] =$r->name;
					
					$uData['nc_wage'] =$r->normal_wage."/".$r->concrete_wage;

					if($r->amt_oh!=0){
					$uData['hrs'] =$r->normal_hour;
					$uData['wage'] =number_format($r->amt_oh,2,'.',',');
					}
					else
					{
					$uData['hrs'] =$r->concrete_hour;
					$uData['wage'] =number_format($r->amt_ch,2,'.',',');
					}

					$uData['otnc_rate'] =$r->normal_ot."/".$r->concrete_ot;;

					$uData['otn_hrs'] =$r->otn_hrs;
					$uData['otc_hrs'] =$r->otc_hrs;
					
					$uData['otn_amt'] =number_format($r->amt_otn,2,'.',',');
					$uData['otc_amt'] =number_format($r->amt_otc,2,'.',',');
					$uData['twage'] =number_format($r->total_wage,2,'.',',');
					$uData['addedby'] =$r->user_name;

					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 

					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	
	public function viewAllLabourDailyWages($request)  //view all labour wages
	{

		$cdate=date("Y-m-d", strtotime("-3 Months"));
		
		$prid=$request->projectId;
		$sdate=$request->startDate;
		$edate=$request->endDate;
		
		$search=$request->search;
		
		$dat=self::query();
		
		$dat->select('labour_daily_wages.*','projects.project_name','labours.code','labours.name','admins.name as user_name')
		->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
		->leftJoin('projects','labour_daily_wages.project_id','=','projects.id')
		->leftJoin('admins','labour_daily_wages.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("labours.name", 'like', '%' .$search . '%')
						->orWhere("labour_daily_wages.entry_date", 'like', '%' .$search . '%');
			  });
		
		if($prid!="" and $sdate!="" and $edate!="")
		{
			$dat->where('labour_daily_wages.project_id',$prid)->whereBetween('labour_daily_wages.entry_date',[$sdate,$edate]);
		}
		else if($prid!="" and $sdate=="" and $edate=="")
		{
			$dat->where('labour_daily_wages.project_id',$prid);
		}
		else if($prid=="" and  $sdate!="" and $edate !="")
		{
			$dat->whereBetween('labour_daily_wages.entry_date',[$sdate,$edate]);
		}
		else
		{
			$dat->where('labour_daily_wages.entry_date','>=',$cdate);
		}

		$dats=$dat->orderBy('labour_daily_wages.id','DESC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['lcode'] =$r->code;
					$uData['edate'] =date_create($r->entry_date)->format('d-m-Y');
					$uData['proj'] =$r->project_name;
					$uData['lbr'] =$r->name;
					
					$uData['nc_wage'] =$r->normal_wage."/".$r->concrete_wage;

					if($r->amt_oh!=0){
					$uData['hrs'] =$r->normal_hour;
					$uData['wage'] =number_format($r->amt_oh,2,'.',',');
					}
					else
					{
					$uData['hrs'] =$r->concrete_hour;
					$uData['wage'] =number_format($r->amt_ch,2,'.',',');
					}

					$uData['otnc_rate'] =$r->normal_ot."/".$r->concrete_ot;;

					$uData['otn_hrs'] =$r->otn_hrs;
					$uData['otc_hrs'] =$r->otc_hrs;
					
					$uData['otn_amt'] =number_format($r->amt_otn,2,'.',',');
					$uData['otc_amt'] =number_format($r->amt_otc,2,'.',',');
					$uData['twage'] =number_format($r->total_wage,2,'.',',');
					$uData['addedby'] =$r->user_name;
										
					$btn='<a href="#" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="#" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		
	
	
	public function getLabourDailyWages()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getLabourDailyWageById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function getLabourDailyWageEntryById($id)
	{
		$data=self::select('labour_daily_wages.*','labours.name')
		->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
		->where('labour_daily_wages.id',$id)->first();
		
		return $data;
	}
			
	public function deleteLabourDailyWage($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}


	
}
