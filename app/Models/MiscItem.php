<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;

class MiscItem extends Model
{
    use HasFactory;
	
	protected $table='misc_items';
	
	protected $fillable = ['id','project_id','other_item_name','other_category_id','bill_date','bill_no',
	'unit_price','quantity','amount'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'other_item_name'=>'required',
	'other_category_id'=>'required',
	'bill_date'=>'required',
	'bill_no'=>'required',
	'unit_price'=>'required',
	'quantity'=>'required',
	'amount'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_other_item_name'=>'required',
	'ed_other_category_id'=>'required',
	'ed_bill_date'=>'required',
	'ed_bill_no'=>'required',
	'ed_unit_price'=>'required',
	'ed_quantity'=>'required',
	'ed_amount'=>'required',
	];
	
	
	public function addOtherItem($request)
	{
		return self::create([
		'project_id'=>$request->project_id,
		'other_item_name'=>$request->other_item_name,
		'other_category_id'=>$request->other_category_id,
		'bill_date'=>$request->bill_date,
		'bill_no'=>$request->bill_no,
		'unit_price'=>$request->unit_price,
		'quantity'=>$request->quantity,
		'amount'=>$request->amount,
		]);
	}
	
		
	public function updateOtherItem($request)
	{
		
		$id=$request->ed_other_item_id;

		$dat=[
		'project_id'=>$request->ed_project_id,
		'other_item_name'=>$request->ed_other_item_name,
		'other_category_id'=>$request->ed_other_category_id,
		'bill_date'=>$request->ed_bill_date,
		'bill_no'=>$request->ed_bill_no,
		'unit_price'=>$request->ed_unit_price,
		'quantity'=>$request->ed_quantity,
		'amount'=>$request->ed_amount,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewProjects($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('projects.*','company.company_name','clients.client_name','project_types.project_type')
		->leftJoin('company','projects.company_id','=','company.id')
		->leftJoin('clients','projects.client_id','=','clients.id')
		->leftJoin('project_types','projects.project_type_id','=','project_types.id')
		
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("clients.client_name", 'like', '%' .$search . '%')
						->orWhere("company.company_name", 'like', '%' .$search . '%')
						->orWhere("projects.address", 'like', '%' .$search . '%')
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
						$st='<span class="badge badge-info">New</span>';
					}
					else if($r->project_status==1)
					{
						$st='<span class="badge badge-secondary">On Going</span>';
					}
					else
					{
						$st='<span class="badge badge-pill badge-primary"><b>Completed</b></span>';
					    //$btns='<a href="#" id="'.$r->id.'" res=1 class="btnActDeact btn btn-rounded btn-success" title="Activate City"><i class="fa fa-check"></i></a>';
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
					$uData['comp'] =$r->company_name;
					$uData['client'] =$r->client_name;
					$uData['proj'] =$r->project_name;
					$uData['add'] =$r->address;
					$uData['cost'] =$r->cost;
					$uData['sdate'] ="Start: <span style='color:blue;'>".date_create($r->start_date)->format('d-m-Y')."</span><br>End: <span style='color:red;'>".date_create($r->finish_date)->format('d-m-Y')."</span>";
					$uData['status'] =$st.$ch_status;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getProjects()
	{
		$data=self::orderBy('id','ASC')->get();
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
