<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;

use Session;

class Labour extends Model
{
    use HasFactory;
	
	protected $table='labours';
	
	protected $fillable = ['id','code','name','skill_type_id','birth_date','gender','mobile','address','state',
	'district','nationality','aadhar_no','assigned_status','wage_status','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'code'=>'required|unique:labours',
	'name'=>'required',
	'skill_type'=>'required',
	'birth_date'=>'required',
	'gender'=>'required',
	'mobile'=>'required',
	'address'=>'required',
	'state'=>'required',
	'district'=>'required',
	'nationality'=>'required',
	'aadhar_no'=>'required|unique:labours',
	
	];
		
	public const EDIT_RULES=[
	'code'=>'required',
	'name'=>'required',
	'birth_date'=>'required',
	'gender'=>'required',
	'mobile'=>'required',
	'address'=>'required',
	'state'=>'required',
	'district'=>'required',
	'nationality'=>'required',
	'aadhar_no'=>'required',
	
	];
		
	public function addLabour($request)
	{

		$result=self::create([
			'code'=>Str::upper($request->code),
			'name'=>Str::upper($request->name),
			'skill_type_id'=>$request->skill_type,
			'birth_date'=>$request->birth_date,
			'gender'=>Str::upper($request->gender),
			'mobile'=>$request->mobile,
			'address'=>Str::upper($request->address),
			'state'=>Str::upper($request->state),
			'district'=>Str::upper($request->district),
			'nationality'=>Str::upper($request->nationality),
			'aadhar_no'=>$request->aadhar_no,
			'added_by'=>Session::get('admin_id'),
			'status'=>1,
		]);
		
		return $result;
		
	}
		
	public function updateLabour($request)
	{
		try
		{
			
		$id=$request->labour_id;

			$dat=[
				'code'=>Str::upper($request->code),
				'name'=>Str::upper($request->name),
				'skill_type_id'=>$request->skill_type,
				'birth_date'=>$request->birth_date,
				'gender'=>Str::upper($request->gender),
				'mobile'=>$request->mobile,
				'address'=>Str::upper($request->address),
				'state'=>Str::upper($request->state),
				'district'=>Str::upper($request->district),
				'nationality'=>Str::upper($request->nationality),
				'aadhar_no'=>$request->aadhar_no,
				'added_by'=>Session::get('admin_id'),
			];
			
			$result=self::whereId($id)->update($dat);
			return $result;
			
		}
		catch(\Exception $e)
		{
			$result=$e->errorInfo[1];
			return $result;
		}
			
		
	}


public function viewLabours($request)  //view data
	{

		$search=$request->search;
		
		
		$dats=self::select('labours.*','skill_types.skill_type','admins.name as user_name')
		->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
		->leftJoin('admins','labours.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("labours.code", 'like', '%' .$search . '%')
						->orWhere("labours.name", 'like', '%' .$search . '%')
						->orWhere("skill_types.skill_type", 'like', '%' .$search . '%')
						->orWhere("labours.mobile", 'like', '%' .$search . '%')
						->orWhere("labours.aadhar_no", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("labours.address", 'like', '%' .$search . '%');
						
			  });
		if($request->state!="" and $request->district!="")
			$dats->where('state','like','%'.$request->state.'%')->where('district','like','%'.$request->district.'%');
		elseif($request->state!="")
			$dats->where('state','like','%'.$request->state.'%');
		elseif($request->district!="")
			$dats->where('district','like','%'.$request->district.'%');
		
		
			 
		$datas=$dats->orderBy('labours.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($datas))
        {
			foreach ($datas as $key=>$r)
            {
					
					if($r->status==1)
					{
						$st='<span class="badge badge-primary">Active</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning shadow btn-b-sm" title="Deactivate Labour"><i class="fa fa-times"></i></a>';
					}
					else
					{
						$st='<span class="badge badge-danger">Inactive</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm" title="Activate Labour"><i class="fa fa-check"></i></a>';
					}
					
					
					$uData['slno'] = ++$key;
					$uData['id'] = $r->id;
					$uData['code'] =$r->code;
					$uData['name'] =$r->name;
					$uData['dob'] =date_create($r->birth_date)->format('d-m-Y');
					$uData['gender'] =$r->gender;
					$uData['mob'] =$r->mobile;
					$uData['add'] =$r->address;
					$uData['state'] =$r->state;
					$uData['dist'] =$r->district;
					$uData['nation'] =$r->nationality;
					$uData['aadhar'] =$r->aadhar_no;
					$uData['status'] =$st;
					$uData['addedby'] =$r->user_name;
					
					//<a href="#" id="'.$r->id.'" class="edit btn btn-rounded btn-primary" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
					
					$btn='<a href="'.url('edit-labour')."/".$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					$uData['action'] = $btn." ".$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getLabours()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
			
	public function getLabourById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function getStates()
	{
		$data=self::select('labours.state')->groupBy('state')->orderBy('state','ASC')->get();
		return $data;
	}

	public function getDistricts($state)
	{
		$data=self::select('labours.district')
		->where('state','like','%'.$state.'%')
		->groupBy('district')->orderBy('id','ASC')->get();
		return $data;
	}

	public function deleteLabour($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
