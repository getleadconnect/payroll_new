<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;

use DB;
use Session;

class ProjectStaff extends Model
{
    use HasFactory;
	
	protected $table='project_staffs';
	
	protected $fillable = ['id','project_id','staff_id','period_from','period_to','status','added_by'];
	
	protected $primaryKey="id";

	protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'staff_id'=>'required',
	];
		
		
	public function AssignProjectStaff($request)
	{
		DB::beginTransaction();
		$result="";
		try
		{
			$result=self::create([
				'project_id'=>$request->project_id,
				'staff_id'=>$request->staff_id,
				'period_from'=>date('Y-m-d'),
				'added_by'=>Session::get('admin_id'),
				'status'=>1,
			]);
			
			$res=Staff::where('id',$request->staff_id)->update(['available'=>1]);
			DB::commit();
		}	
		catch(\Exceltion $e)
		{
			DB::rollback();
			$result=0;
		}
		return $result;

	}
		

public function viewProjectStaffs($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->project_id;
		
		$dts=self::query();
		
		$dts->select('project_staffs.*','staffs.name','projects.project_name','admins.name as user_name')
		->leftJoin('staffs','project_staffs.staff_id','=','staffs.id')
		->leftJoin('projects','project_staffs.project_id','=','projects.id')
		->leftJoin('admins','project_staffs.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("staffs.name", 'like', '%' .$search . '%')
						->orWhere("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%');
			  });
			  
		if($project_id!="")
		{
			$dts->where('project_id',$project_id);
		}			
		
		$dats=$dts->orderBy('project_staffs.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				if($r->status==1)
					{
						$st='<span class="badge badge-success">Active</span>';
						$btns='&nbsp;<a href="javascript:void();" id="'.$r->id.'" class="btnRelease btn-outline-info shadow btn-b-sm"  title="Release Staff"><i class="fa fa-arrow-left"></i></a>';
					}
					else
					{
						$st='<span class="badge badge-danger">Inactive</span>';
						$btns="";
					}

				$uData['id'] = ++$key;
				$uData['pname'] =$r->project_name;
				$uData['sname'] =$r->name;
				$uData['sdate'] =date_create($r->period_from)->format('d-m-Y');
				$uData['edate'] =($r->period_to==null)?'-':date_create($r->end_date)->format('d-m-Y');
				$uData['status'] =$st;
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 

				$uData['action'] = $btn.$btns;

			  $data[] = $uData;
			}
        }
		return $data;
	}		
	

	public function getProjectStaffs()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getStaffSalaryById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteProjectStaff($id)
	{
		$dat=self::find($id);
		
		try
		{
			$staff_id=$dat->staff_id;
			Staff::where('id',$staff_id)->update(['available'=>0]);
			$result=$dat->delete();
		}
		catch(\Exception $e)
		{
			$result=0;	
		}
		return $result;
	}

	public function getProjectStaffByProjectId($id)
	{
		$data=self::select('staffs.id','staffs.name')
		->leftJoin('staffs','project_staffs.staff_id','=','staffs.id')
		->where('project_id',$id)->where('staffs.status',1)->orderBy('id','ASC')->get();
		
		return $data;
	}
	
	
}
