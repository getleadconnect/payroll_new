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
	
	protected $fillable = ['id','entry_date','project_id','labour_id','main_cost_schedule_id','work_type',
				'working_hour','ot_hrs','amt_oh','amt_ch','amt_otn','amt_otc','wage','total_wage','added_by'
			];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'labour_id'=>'required',
	'main_cost_schedule_id'=>'required',
	'work_type'=>'required',
	'working_hour'=>'required',
	'amt_oh'=>'required',
	'amt_ch'=>'required',
	'total_wage'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_entry_date'=>'required',
	'ed_project_id'=>'required',
	'ed_labour_id'=>'required',
	'ed_main_cost_schedule_id'=>'required',
	'ed_work_type'=>'required',
	'ed_working_hour'=>'required',
	'ed_amt_oh'=>'required',
	'ed_amt_ch'=>'required',
	'ed_total_wage'=>'required',
	];
	
	public function addLabourDailyWage($request)
	{
		
		return self::create([
			'current_date'=>$request->current_date,
			'project_id'=>$request->project_id,
			'labour_id'=>$request->labour_id,
			'main_cost_schedule_id'=>$request->main_cost_schedule_id,
			'work_type'=>$request->work_type,
			'working_hour'=>$request->working_hour,
			'amt_oh'=>$request->amt_oh,
			'amt_ch'=>$request->amt_ch,
			'amt_otn'=>$request->amt_otn,
			'amt_otc'=>$request->amt_otc,
			'wage'=>$request->amt_oh_ch,
			'ot_hrs'=>$request->ot_hrs??0,
			'total_wage'=>$request->total_wage,
			'added_by'=>Session::get('admin_id'),
			]);
	}
	
	
		
	public function updateLabourDailyWage($request)
	{
		
		$id=$request->ed_wage_id;

		$dat=[
		    'current_date'=>$request->ed_current_date,
			'project_id'=>$request->ed_project_id,
			'labour_id'=>$request->ed_labour_id,
			'main_cost_schedule_id'=>$request->ed_main_cost_schedule_id,
			'work_type'=>$request->ed_work_type,
			'working_hour'=>$request->ed_working_hour,
			'amt_oh'=>$request->ed_amt_oh,
			'amt_ch'=>$request->ed_amt_ch,
			'amt_otn'=>$request->ed_amt_otn,
			'amt_otc'=>$request->ed_amt_otc,
			'wage'=>$request->ed_amt_oh_ch,
			'ot_hrs'=>$request->ed_ot_hrs??0,
			'total_wage'=>$request->ed_total_wage,
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function viewLabourDailyWages($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('labour_daily_wages.*','projects.project_name','labours.name','admins.name as user_name')
		->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
		->leftJoin('projects','labour_daily_wages.project_id','=','projects.id')
		->leftJoin('admins','labour_daily_wages.added_by','=','admins.id')
		->where('current_date',date('Y-m-d'))
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("labours.name", 'like', '%' .$search . '%')
						->orWhere("labour_daily_wages.current_date", 'like', '%' .$search . '%');
			  })->orderBy('projects.id','DESC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['edate'] =date_create($r->current_date)->format('d-m-Y');
					$uData['proj'] =$r->project_name;
					$uData['lbr'] =$r->name;
					$uData['hrs'] =$r->working_hour;
					$uData['wage'] =number_format($r->wage,2,'.',',');
					$uData['ot'] =$r->ot_hrs;
					$uData['otn'] =number_format($r->amt_otn,2,'.',',');
					$uData['otc'] =number_format($r->amt_otc,2,'.',',');
					$uData['twage'] =number_format($r->total_wage,2,'.',',');
					$uData['addedby'] =$r->user_name;
										
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
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
		
		$dat->select('labour_daily_wages.*','projects.project_name','labours.name','admins.name as user_name')
		->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
		->leftJoin('projects','labour_daily_wages.project_id','=','projects.id')
		->leftJoin('admins','labour_daily_wages.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("labours.name", 'like', '%' .$search . '%')
						->orWhere("labour_daily_wages.current_date", 'like', '%' .$search . '%');
			  });
		if($prid!="" and $sdate=="" and $edate=="")
		{
			$dat->where('labour_daily_wages.project_id',$prid);
		}
		else if($prid=="" and  $sdate!="" and $edate !="")
		{
			$dat->whereBetween('labour_daily_wages.current_date',[$sdate,$edate]);
		}
		else if($prid!="" and $sdate!="" and $edate !="")
		{
			$dat->whereBetween('labour_daily_wages.current_date',[$sdate,$edate]);
		}
		else
		{
			$dat->where('labour_daily_wages.current_date','>=',$cdate);
		}

		$dats=$dat->orderBy('labour_daily_wages.id','DESC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['edate'] =date_create($r->current_date)->format('d-m-Y');
					$uData['proj'] =$r->project_name;
					$uData['lbr'] =$r->name;
					$uData['hrs'] =$r->working_hour;
					$uData['wage'] =number_format($r->wage,2,'.',',');
					$uData['ot'] =$r->ot_hrs;
					$uData['otn'] =number_format($r->amt_otn,2,'.',',');
					$uData['otc'] =number_format($r->amt_otc,2,'.',',');
					$uData['twage'] =number_format($r->total_wage,2,'.',',');
					$uData['addedby'] =$r->user_name;
										
					$btn='<a href="#" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="#" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
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
		
	public function deleteLabourDailyWage($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
