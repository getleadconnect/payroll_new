<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;

use Session;

class Project extends Model
{
    use HasFactory;
	
	protected $table='projects';
	
	protected $fillable = ['id','company_id','client_id','project_name','address','description','project_type_id',
	'cost','start_date','finish_date','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'company_id'=>'required',
	'client_id'=>'required',
	'project_type_id'=>'required',
	'project_name'=>'required',
	'address'=>'required',
	'description'=>'required',
	'cost'=>'required',
	'start_date'=>'required',
	'finish_date'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_company_id'=>'required',
	'ed_client_id'=>'required',
	'ed_project_type_id'=>'required',
	'ed_project_name'=>'required',
	'ed_address'=>'required',
	'ed_description'=>'required',
	'ed_cost'=>'required',
	'ed_start_date'=>'required',
	'ed_finish_date'=>'required',
	];
	
	public function addProject($request)
	{
		return self::create([
		'company_id'=>$request->company_id,
		'client_id'=>$request->client_id,
		'project_type_id'=>$request->project_type_id,
		'project_name'=>Str::upper($request->project_name),
		'address'=>Str::upper($request->address),
		'description'=>Str::upper($request->description),
		'cost'=>$request->cost,
		'start_date'=>$request->start_date,
		'finish_date'=>$request->finish_date,
		'project_status'=>0,
		'added_by'=>Session::get('admin_id'),
		'status'=>1,
		]);
		
	}
		
	public function updateProject($request)
	{
		
		$id=$request->ed_project_id;

		$dat=[
		'company_id'=>$request->ed_company_id,
		'client_id'=>$request->ed_client_id,
		'project_type_id'=>$request->ed_project_type_id,
		'project_name'=>Str::upper($request->ed_project_name),
		'address'=>Str::upper($request->ed_address),
		'description'=>Str::upper($request->ed_description),
		'cost'=>$request->ed_cost,
		'start_date'=>$request->ed_start_date,
		'finish_date'=>$request->ed_finish_date,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewProjects($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('projects.*','company.company_name','clients.client_name','project_types.project_type','admins.name')
		->leftJoin('company','projects.company_id','=','company.id')
		->leftJoin('clients','projects.client_id','=','clients.id')
		->leftJoin('project_types','projects.project_type_id','=','project_types.id')
		->leftJoin('admins','projects.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("clients.client_name", 'like', '%' .$search . '%')
						->orWhere("company.company_name", 'like', '%' .$search . '%')
						->orWhere("projects.address", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("projects.start_date", 'like', '%' .$search . '%')
						->orWhere("projects.finish_date", 'like', '%' .$search . '%');
			  })->orderBy('projects.id','ASC')->get();





		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->project_status==0)
					{
						$pst='<span class="badge badge-info">New</span>';
					}
					else if($r->project_status==1)
					{
						$pst='<span class="badge badge-secondary">On Going</span>';
					}
					else
					{
						$pst='<span class="badge badge-pill badge-primary"><b>Completed</b></span>';
					}
					

					if($r->status==1)
					{
						$st='<span class="badge badge-info">Active</span>';
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning  shadow btn-b-sm" title="Deactivate Project"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
					}
					else 
					{
						$st='<span class="badge badge-danger">Inactive</span>';
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm" title="Activate Project"><i class="fa fa-check"></i></a>';
					}


					$ch_status='&nbsp;<span class="dropdown">
									<a href="#" data-toggle="dropdown"><i class="fas fa-edit"></i> </a>
									<div class="dropdown-menu" style="border: 1px solid #d78dd7;">
										<a class="dropdown-item change-status" id="'.$r->id.'" data-id="0" href="#">New</a>
										<a class="dropdown-item change-status" id="'.$r->id.'" data-id="1" href="#">On Going</a>
										<a class="dropdown-item change-status" id="'.$r->id.'" data-id="2" href="#">Completed</a>
									</div>
                                </span>';
							 
	
					$uData['id'] = ++$key;
					$uData['comp'] =Str::upper($r->company_name);
					$uData['client'] =Str::upper($r->client_name);
					$uData['proj'] =Str::upper($r->project_name);
					$uData['desc'] =Str::upper($r->description);
					$uData['add'] =Str::upper($r->address);
					$uData['cost'] =number_format($r->cost,2,'.',',');
					$uData['sdate'] ="<span style='color:blue;'>".date_create($r->start_date)->format('d-m-Y')."</span> => <span style='color:red;'>".date_create($r->finish_date)->format('d-m-Y')."</span>";
					$uData['status'] =$st;
					$uData['pstatus'] =$pst.$ch_status;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn.$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}
	

	public function getProjects()
	{
		$role_id=Session::get('admin_role_id');
		if($role_id==4)
		{
			$stf_id=Session::get('admin_staff_id');
			$data=self::select('projects.*')->join('project_staffs','project_staffs.project_id','=','projects.id')
			->where('project_staffs.staff_id',$stf_id)
			->where('status',1)->get();
		}			
		else
		{
	
		   $data=self::where('status',1)->orderBy('id','ASC')->get();
		}
		return $data;
	}

			
	public function getProjectById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
		
	public function getProjectsByCompanyId($id)
	{
		$data=self::where('company_id',$id)->get();
		return $data;
	}

	public function deleteProject($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
