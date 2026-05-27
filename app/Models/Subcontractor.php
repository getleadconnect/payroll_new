<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;

class Subcontractor extends Model
{
    
	use HasFactory;
	
	protected $table='subcontractors';
	
	protected $fillable = ['id','name','gst_no','pan_no','contact_person','mobile',
	'address','bank_name','bank_ifsc','bank_account_no','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'name'=>'required',
	'gst_no'=>'required|unique:subcontractors',
	'pan_no'=>'required|unique:subcontractors',
	'contact_person'=>'required',
	'mobile'=>'required|unique:subcontractors',
	'address'=>'required',
	'bank_name'=>'required',
	'bank_ifsc'=>'required',
	'bank_account_no'=>'required',
	];
	
	public const EDIT_RULES=[
	'name'=>'required',
	'gst_no'=>'required',
	'pan_no'=>'required',
	'contact_person'=>'required',
	'mobile'=>'required',
	'address'=>'required',
	'bank_name'=>'required',
	'bank_ifsc'=>'required',
	'bank_account_no'=>'required',
	];
	
	public function addSubcontractor($request)
	{
		try
		{		
			return self::create([
			'name'=>Str::upper($request->name),
			'gst_no'=>Str::upper($request->gst_no),
			'pan_no'=>Str::upper($request->pan_no),
			'contact_person'=>Str::upper($request->contact_person),
			'mobile'=>$request->mobile,
			'address'=>Str::upper($request->address),
			'bank_name'=>Str::upper($request->bank_name),
			'bank_ifsc'=>Str::upper($request->bank_ifsc),
			'bank_account_no'=>$request->bank_account_no,
			'added_by'=>Session::get('admin_id'),
			'status'=>1,
			
			]);
			
		}
		catch(\Exception $e)
		{
			$result=$e->errorInfo[1];
			return $result;
		}

	}
		
	public function updateSubcontractor($request)
	{
		try
		{
			
			$id=$request->ed_subcon_id;

			$dat=[
			'name'=>Str::upper($request->name),
			'gst_no'=>Str::upper($request->gst_no),
			'pan_no'=>Str::upper($request->pan_no),
			'contact_person'=>Str::upper($request->contact_person),
			'mobile'=>$request->mobile,
			'address'=>Str::upper($request->address),
			'bank_name'=>Str::upper($request->bank_name),
			'bank_ifsc'=>Str::upper($request->bank_ifsc),
			'bank_account_no'=>$request->bank_account_no,
			'added_by'=>Session::get('admin_id'),
			];
			
			$result=self::whereId($id)->update($dat);
			
			return $result;
		}
		catch(\Exception $e)
		{
			$result=$e->errorInfo[1];
		}
		
		
		
	}


public function viewSubcontractors($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('subcontractors.*','admins.name as user_name')
		->leftJoin('admins','subcontractors.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("subcontractors.name", 'like', '%' .$search . '%')
						->orWhere("contact_person", 'like', '%' .$search . '%')
						->orWhere("subcontractors.mobile", 'like', '%' .$search . '%')
						->orWhere("address", 'like', '%' .$search . '%')
						->orWhere("gst_no", 'like', '%' .$search . '%')
						->orWhere("pan_no", 'like', '%' .$search . '%')
						->orWhere("bank_name", 'like', '%' .$search . '%')
						->orWhere("bank_account_no", 'like', '%' .$search . '%');
			  })->orderBy('id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->status==1)
					{
						$st='<span class="badge badge-info">Active</span>';
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning shadow btn-b-sm" title="Deactivate Supplier"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
					}
					else 
					{
						$st='<span class="badge badge-danger">Inactive</span>';
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm" title="Activate Supplier"><i class="fa fa-check"></i></a>';
					}
					
					$uData['id'] = ++$key;
					$uData['sname'] =$r->name;
					$uData['gst'] ="GST: ".$r->gst_no."<br>PAN: ".$r->pan_no;
					$uData['cperson'] =$r->contact_person."<br><i class='fas fa-mobile'></i>: ".$r->mobile;
					$uData['add'] =$r->address;
					$uData['bank'] =$r->bank_name."<br>IFSC: ".$r->bank_ifsc."<br>A/C :".$r->bank_account_no;
					$uData['status'] =$st;
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit  btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn.$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSubcontractors()
	{
		$data=self::where('status',1)->orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSubcontractorById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSubcontractor($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}


	
	
}
