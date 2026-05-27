<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class Company extends Model
{
    use HasFactory;
	
	protected $table='company';
	
	protected $fillable = ['id','company_name','address','gst_no','pan_no','others','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'company_name'=>'required',
	'address'=>'required',
	'gst_no'=>'required',
	'pan_no'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_company_name'=>'required',
	'ed_address'=>'required',
	'ed_gst_no'=>'required',
	'ed_pan_no'=>'required',
	];
	
	/*public function addCompany($request)
	{
		return self::create([
		'company_name'=>Str::upper($request->company_name),
		'address'=>Str::upper($request->address),
		'gst_no'=>$request->gst_no,
		'pan_no'=>Str::upper($request->pan_no),
		'others'=>Str::upper($request->others),
		'added_by'=>Session::get('admin_id'),
		'status'=>1,
		]);
	}*/
		
	public function updateCompany($request)
	{
		
		$id=$request->ed_company_id;

		$dat=[
		'company_name'=>Str::upper($request->ed_company_name),
		'address'=>Str::upper($request->ed_address),
		'email'=>$request->ed_email,
		'mobile'=>$request->ed_mobile,
		'gst_no'=>$request->ed_gst_no,
		'pan_no'=>Str::upper($request->ed_pan_no),
		'others'=>Str::upper($request->ed_others),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


/*
public function viewCompany($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('company.*','admins.name')
		->leftJoin('admins','company.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("company.company_name", 'like', '%' .$search . '%')
						->orWhere("company.gst_no", 'like', '%' .$search . '%')
						->orWhere("company.pan_no", 'like', '%' .$search . '%')
						->orWhere("company.address", 'like', '%' .$search . '%');
			  })->orderBy('company.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->status==1)
					{
						$st='<span class="badge badge-success">Active</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn btn-rounded btn-warning  btn-xs btn-sm" title="Deactivate Company"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
						
					}
					else
					{
						$st='<span class="badge badge-danger">Inactive</span>';
					    $btns='<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn btn-rounded btn-success btn-xs btn-sm" title="Activate Company"><i class="fa fa-check"></i></a>';
					}
				
					$uData['id'] = ++$key;
					$uData['cname'] =$r->company_name;
					$uData['add'] =$r->address;
					$uData['gstno'] =$r->gst_no;
					$uData['panno'] =$r->pan_no;
					$uData['other'] =$r->others;
					$uData['status'] =$st;
					$uData['user'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn btn-rounded btn-secondary btn-xs btn-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>'; 
					
					$uData['action'] = $btn."&nbsp;".$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}		
*/

	public function getCompany()
	{
		$data=self::orderBy('id','ASC')->first();
		return $data;
	}
		
	public function getCompanyById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteCompany($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}
	
}
