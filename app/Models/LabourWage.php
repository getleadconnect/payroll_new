<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Labour;

use DB;
use Session;

class LabourWage extends Model
{
    use HasFactory;
	
	protected $table='labour_wages';
	
	protected $fillable = ['id','labour_id','wage_date','wage_normal','wage_concrete','wage_ot','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'labour_id'=>'required',
	'wage_date'=>'required',
	'wage_normal'=>'required',
	'wage_concrete'=>'required',
	'wage_ot'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_labour_wage_id'=>'required',
	'ed_wage_date'=>'required',
	'ed_wage_normal'=>'required',
	'ed_wage_concrete'=>'required',
	'ed_wage_ot'=>'required',
	];
		
	public function addLabourWage($request)
	{

		DB::beginTransaction();
		$result=false;
		
		try
		{

		 $result=self::create([
			'labour_id'=>$request->labour_id,
			'wage_date'=>$request->wage_date,
			'wage_normal'=>$request->wage_normal,
			'wage_concrete'=>$request->wage_concrete,
			'wage_ot'=>$request->wage_ot,
			'added_by'=>Session::get('admin_id'),
		]);
		
		$dat=['wage_status'=>1];
		$res=Labour::where('id',$request->labour_id)->update($dat);

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
		
	public function updateLabourWage($request)
	{

		$id=$request->ed_labour_wage_id;

			$dat=[
			'wage_date'=>$request->ed_wage_date,
			'wage_normal'=>$request->ed_wage_normal,
			'wage_concrete'=>$request->ed_wage_concrete,
			'wage_ot'=>$request->ed_wage_ot,
			'added_by'=>Session::get('admin_id'),
			];
			
			$result=self::whereId($id)->update($dat);
			return $result;
	}

/*public function viewLabours($request)  //set labour wages
	{

		$search=$request->search;
		$searchBySkill=$request->searchBySkill;
		
		$dts=Labour::query();

		$dts->select('labours.id','labours.code','labours.name','skill_types.skill_type')
		->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
		->where(function($where) use($search)
			    {
					$where->where("labours.name", 'like', '%' .$search . '%')
						->orWhere("labours.code", 'like', '%' .$search . '%')
						->orWhere("skill_types.skill_type", 'like', '%' .$search . '%');
			  });
		if($searchBySkill!="")
		{
			$dts->where('labours.skill_type_id',$searchBySkill);
		}			
					  
		$dats=$dts->where('wage_status','0')->orderBy('labours.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['code'] =$r->code;
					$uData['name'] =$r->name;
					$uData['sktype'] =$r->skill_type;

					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="setWage btn-rounded btn btn-secondary btn-xs btn-sm" data-toggle="modal" title="Set labour wage">Set</a>'; 
					$uData['action'] = $btn; 

			    $data[] = $uData;
			}
        }
		return $data;
	}	*/	

public function viewLabours($skill_id)  //set labour wages
	{
		$search=$request->search;
		$data=Labour::query();
		if($skill_id!="")
		{
			$data->select('labours.id','labours.code','labours.name','skill_types.skill_type')
			->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
			->where('wage_status','0')->where('skill_type',$skill_id)->orderBy('labours.id','ASC')->get();
		}
		else
		{
			$data->select('labours.id','labours.code','labours.name','skill_types.skill_type')
			->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
			->where('wage_status','0')->orderBy('labours.id','ASC')->get();	
		}

		return $data;
	}


public function viewLabourWages($request)  //view labour wages 
	{

		$search=$request->search;

		$dats=self::select('labour_wages.*','labours.code','labours.name','admins.name as user_name')
		->leftJoin('labours','labour_wages.labour_id','=','labours.id')
		->leftJoin('admins','labour_wages.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->where("labours.name", 'like', '%' .$search . '%')
						->orWhere("labours.code", 'like', '%' .$search . '%')
						->orWhere("labour_wages.wage_normal", 'like', '%' .$search . '%')
						->orWhere("labour_wages.wage_concrete", 'like', '%' .$search . '%');
						
			  })->orderBy('labour_wages.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['code'] =$r->code;
				$uData['name'] =$r->name;
				$uData['wdate'] =date_create($r->wage_date)->format('d-m-Y');
				$uData['wnormal'] =number_format($r->wage_normal,2,'.',',');
				$uData['wcon'] =number_format($r->wage_concrete,2,'.',',');
				$uData['wot'] =number_format($r->wage_ot,2,'.',',');
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="'.url('delete-labour-wage')."/".$r->id.'" id="conf" class="btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getLabourWages()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getLabourWageById($id)
	{
		$data=self::select('labour_wages.*','labours.name')
			->leftJoin('labours','labour_wages.labour_id','=','labours.id')
			->where('labour_wages.id',$id)->first();
		return $data;
	}

	public function deleteLabourWage($id)
	{
		$lw=self::find($id);
		if(!empty($lw))
		{
			$dat=['wage_status'=>0];
			$res=Labour::where('id',$lw->labour_id)->update($dat);
			$result=$lw->delete();
		}
		return $result;
	}

	
	
}
