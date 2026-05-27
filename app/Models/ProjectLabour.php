<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Labour;

use DB;
use Session;

class ProjectLabour extends Model
{
    use HasFactory;
	
	protected $table='project_labours';
	
	protected $fillable = ['id','labour_id','labour_wage_id','project_id','start_date','end_date','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	//fucntions
	
	public const RULES=[
	'labour_id'=>'required',
	'labour_wage_id'=>'required',
	'project_id'=>'required',
	'start_date'=>'required',
	'end_date'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_labour_id'=>'required',
	'ed_labour_wage_id'=>'required',
	'ed_project_id'=>'required',
	'ed_start_date'=>'required',
	'ed_end_date'=>'required',
	];
		
	public function addProjectLabour($request)
	{

		DB::beginTransaction();
		$result=false;
		
		try
		{

			$lbrids=substr($request->labour_id,1);
			$lbr_ids=explode(",",$lbrids);
			
			$result="";
			foreach($lbr_ids as $r)
			{
				$wid=LabourWage::where('labour_id',$r)->first();
				if(!empty($wid)){ $wage_id=$wid->id;}else{$wage_id=0;}
				
				$dat=[
				'labour_id'=>$r,
				'project_id'=>$request->project_id,
				'labour_wage_id'=>$wage_id,
				'start_date'=>$request->start_date,
				'end_date'=>$request->end_date,
				'added_by'=>trim(Session::get('admin_id')),
				'status'=>1
				];
				
				$result=ProjectLabour::create($dat);
				
				if($result)
				{
					$ndt=['assigned_status'=>1];
					$res=Labour::where('id',$r)->update($ndt);
				}
			}
			
		DB::commit();
		}
		catch(\Exception $e)
		{
			DB::rollback();
			$result=false;
			Session::flash('message', 'danger#'.$e->getMessage());
		}

	return $result;

	}
	

public function viewLabourDetails($request)  
	{

		$search=$request->search;
		$searchBySkill=$request->searchBySkill;
		
		$dts=Labour::query();

		$dts->select('labours.*','skill_types.skill_type')
		->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
		->where(function($where) use($search)
			    {
					$where->Where("labours.name", 'like', '%' .$search . '%')
						->orWhere("labours.code", 'like', '%' .$search . '%')
						->orWhere("skill_types.skill_type", 'like', '%' .$search . '%');
			  });
			  
		if($searchBySkill!="")
		{
			$dts->where('labours.skill_type_id',$searchBySkill);
		}			
					  
		$dats=$dts->where('assigned_status','0')->orderBy('labours.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				if($r->wage_status=="1")
					{
						$lwst='<span style="color:green;font-size:18px;"><i class="fas fa-check"></i></span>';
						$lbtn="";
					}
					else
					{
						$lwst='<input type="hidden" class="wage" value="0"><span class="badge badge-danger ">Not Set</span>';
						$lbtn='<a href="javascript:void(0)" id="'.$r->id.'" class="setWage btn-outline-success shadow btn-b-sm" data-toggle="modal" title="Set labour wage"><i class="fas fa-edit"></i></a>';
					}
				
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
					$uData['code'] =$r->code;
					$uData['name'] =$r->name;
					$uData['mob'] =$r->mobile;
					$uData['sktype'] =$r->skill_type;
					$uData['wstat'] =$lwst." ".$lbtn;
					$btn='<a href="#" id="'.$r->id.'" class="setWage btn-outline-secondary shadow btn-b-sm" data-toggle="modal" title="Set labour wage">Set</a>'; 
					$uData['action'] = $btn; 

			    $data[] = $uData;
			}
        }
		return $data;
	}		




public function viewAssignedLabours($request)  //assigned project labour details 
	{

		$search=$request->search;
		$searchBySkill=$request->searchBySkill;
		$searchByProject=$request->searchByProject;
		
		$dts=ProjectLabour::query();

		$dts->select('project_labours.*','labours.code','labours.name','projects.project_name','skill_types.skill_type','admins.name as user_name')
		->leftJoin('labours','project_labours.labour_id','=','labours.id')
		->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
		->leftJoin('projects','project_labours.project_id','=','projects.id')
		->leftJoin('admins','project_labours.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->Where("labours.name", 'like', '%' .$search . '%')
						->orWhere("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("labours.code", 'like', '%' .$search . '%')
						->orWhere("skill_types.skill_type", 'like', '%' .$search . '%');
			  });
			  
		if($searchByProject!="" and $searchBySkill=="" )
		{
			$dts->where('project_labours.project_id',$searchByProject);
		}		
		else if($searchByProject!="" and $searchBySkill!="")
		{
			$dts->where('project_labours.project_id',$searchByProject)->where('skill_types.id',$searchBySkill);
		}		
					  
		$dats=$dts->orderBy('project_labours.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
		
					if($r->status=="1")
					{
						$st='<span class="badge badge-primary">Active</span>';
						$sbtn='<a href="javascript:void(0);" id="'.$r->id.'" class="btnRelease btn-outline-info shadow btn-b-sm " data-toggle="modal" title="Set Completion"><i class="fas fa-arrow-right"></i></a>';
						
					}
					else
					{
						$st='<span class="badge badge-danger">Completed</span>';
						$sbtn="";
					}
					
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
					$uData['lcode'] =$r->code;
					$uData['lname'] =$r->name;
					$uData['sktype'] =$r->skill_type;
					$uData['pname'] =$r->project_name;
					$uData['sedate'] =date_create($r->start_date)->format('d-m-Y')." => ".date_create($r->end_date)->format('d-m-Y');
					$uData['status'] =$st." ".$sbtn;
					$uData['addedby'] = $r->user_name; 

					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm" title="Remove labour"><i class="fas fa-trash"></i></a>'; 
					$uData['action'] = $btn; 

			    $data[] = $uData;
			}
        }
		return $data;
	}	

	public function getProjectLabours()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getProjectLabourById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteProjectLabour($id)
	{
		$lw=self::find($id);
		if(!empty($lw))
		{
			$dat=['assigned_status'=>0];
			$res=Labour::where('id',$lw->labour_id)->update($dat);
			$result=$lw->delete();
		}
		
		return $result;
	}

	
	
}
