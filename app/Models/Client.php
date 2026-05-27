<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class Client extends Model
{
    use HasFactory;
	
	protected $table='clients';
	
	protected $fillable = ['id','client_name','contact_person','mobile','address','gst_no','others','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'client_name'=>'required',
	'contact_person'=>'required',
	'mobile'=>'required',
	'address'=>'required',
	'gst_no'=>'required|unique:clients',
	];
	
	public const EDIT_RULES=[
	'ed_client_name'=>'required',
	'ed_contact_person'=>'required',
	'ed_mobile'=>'required',
	'ed_address'=>'required',
	'ed_gst_no'=>'required',
	];
	
	public function addClient($request)
	{
		try
		{		
			$result=self::create([
			'client_name'=>Str::upper($request->client_name),
			'contact_person'=>Str::upper($request->contact_person),
			'mobile'=>$request->mobile,
			'address'=>Str::upper($request->address),
			'gst_no'=>Str::upper($request->gst_no),
			'others'=>Str::upper($request->others),
			'added_by'=>Session::get('admin_id'),
			'status'=>1,
			]);
		}
		catch(\Exception $e)
		{
			$result=$e->getMessage();
		}
		return $result;
		
	}
		
	public function updateClient($request)
	{
		
		$id=$request->ed_client_id;

		$dat=[
		'client_name'=>Str::upper($request->ed_client_name),
		'contact_person'=>Str::upper($request->ed_contact_person),
		'mobile'=>$request->ed_mobile,
		'address'=>Str::upper($request->ed_address),
		'gst_no'=>Str::upper($request->ed_gst_no),
		'others'=>Str::upper($request->ed_others),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewClients($request)  //view data
	{

		$search=$request->search;
				
		
		$dats=self::select('clients.*','admins.name')
		->leftJoin('admins','clients.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("clients.client_name", 'like', '%' .$search . '%')
						->orWhere("clients.gst_no", 'like', '%' .$search . '%')
						->orWhere("clients.address", 'like', '%' .$search . '%')
						->orWhere("clients.contact_person", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("clients.mobile", 'like', '%' .$search . '%');
			  })->orderBy('clients.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->status==1)
					{
						$st='<span class="badge badge-success">Active</span>';
					}
					else
					{
						$st='<span class="badge badge-danger">Inactive</span>';
					}
				
					$uData['id'] = ++$key;
					$uData['cname'] =$r->client_name;
					$uData['cperson'] =$r->contact_person."<br><i class='fas fa-mobile'></i> : ".$r->mobile;
					$uData['add'] =$r->address;
					$uData['gstno'] =$r->gst_no;
					$uData['other'] =$r->others;
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getClients()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getClientById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteClient($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
