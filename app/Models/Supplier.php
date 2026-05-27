<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;

class Supplier extends Model
{
    use HasFactory;
	
	protected $table='suppliers';
	
	protected $fillable = ['id','supplier_name','gst_no','contact_person','mobile',
	'address','bank_name','bank_ifsc','bank_account_no','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'supplier_name'=>'required',
	'gst_no'=>'required|unique:suppliers',
	'contact_person'=>'required',
	'mobile'=>'required',
	'address'=>'required',
	'bank_name'=>'required',
	'bank_ifsc'=>'required',
	'bank_account_no'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_supplier_name'=>'required',
	'ed_gst_no'=>'required',
	'ed_contact_person'=>'required',
	'ed_mobile'=>'required',
	'ed_address'=>'required',
	'ed_bank_name'=>'required',
	'ed_bank_ifsc'=>'required',
	'ed_bank_account_no'=>'required',
	];
	
	public function addSupplier($request)
	{
		return self::create([
		'supplier_name'=>Str::upper($request->supplier_name),
		'gst_no'=>Str::upper(trim($request->gst_no)),
		'contact_person'=>Str::upper($request->contact_person),
		'mobile'=>$request->mobile,
		'address'=>Str::upper($request->address),
		'bank_name'=>Str::upper($request->bank_name),
		'bank_ifsc'=>Str::upper($request->bank_ifsc),
		'bank_account_no'=>$request->bank_account_no,
		'added_by'=>Session::get('admin_id'),
		]);
		
	}
		
	public function updateSupplier($request)
	{
		
		$id=$request->ed_supplier_id;

		$dat=[
		'supplier_name'=>Str::upper($request->ed_supplier_name),
		'gst_no'=>Str::upper(trim($request->ed_gst_no)),
		'contact_person'=>Str::upper($request->ed_contact_person),
		'mobile'=>$request->ed_mobile,
		'address'=>Str::upper($request->ed_address),
		'bank_name'=>Str::upper($request->ed_bank_name),
		'bank_ifsc'=>Str::upper($request->ed_bank_ifsc),
		'bank_account_no'=>$request->ed_bank_account_no,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewSuppliers($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('suppliers.*','admins.name as user_name')
		->leftJoin('admins','suppliers.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("supplier_name", 'like', '%' .$search . '%')
						->orWhere("contact_person", 'like', '%' .$search . '%')
						->orWhere("suppliers.mobile", 'like', '%' .$search . '%')
						->orWhere("address", 'like', '%' .$search . '%')
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
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning  shadow btn-b-sm" title="Deactivate Supplier"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
					}
					else 
					{
						$st='<span class="badge badge-danger">Inactive</span>';
						$btns='&nbsp;<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm" title="Activate Supplier"><i class="fa fa-check"></i></a>';
					}
					
					$uData['id'] = ++$key;
					$uData['sname'] =$r->supplier_name;
					$uData['gst'] =$r->gst_no;
					$uData['cperson'] =$r->contact_person."<br><i class='fas fa-mobile'></i>: ".$r->mobile;
					$uData['add'] =$r->address;
					$uData['bank'] =$r->bank_name."<br>IFSC: ".$r->bank_ifsc."<br>A/C :".$r->bank_account_no;
					$uData['status'] =$st;
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn.$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSuppliers()
	{
		$data=self::where('status',1)->orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSupplierById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSupplier($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
