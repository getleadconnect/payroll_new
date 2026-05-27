<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;

use DB;
use Session;

class MiscVendor extends Model
{
    use HasFactory;
	
	protected $table='misc_vendors';
	
	protected $fillable = ['id','name','gst_no','pan_no','bank_name','bank_ifsc','bank_account_no','added_by'];
	
	protected $primaryKey="id";

	protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'name'=>'required',
	'gst_no'=>'required|unique:misc_vendors',
	'pan_no'=>'required',
	'bank_name'=>'required',
	'bank_ifsc'=>'required',
	'bank_account_no'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_name'=>'required',
	'ed_gst_no'=>'required',
	'ed_pan_no'=>'required',
	'ed_bank_name'=>'required',
	'ed_bank_ifsc'=>'required',
	'ed_bank_account_no'=>'required',
	];
		
		
	public function addMiscVendor($request)
	{
		try
		{
			$result=self::create([
				'name'=>Str::upper($request->name),
				'gst_no'=>Str::upper($request->gst_no),
				'pan_no'=>Str::upper($request->pan_no),
				'bank_name'=>Str::upper($request->bank_name),
				'bank_ifsc'=>Str::upper($request->bank_ifsc),
				'bank_account_no'=>$request->bank_account_no,
				'added_by'=>Session::get('admin_id'),
			]);
		}	
		catch(\Exceltion $e)
		{
			$result=0;
		}
		
		return $result;

	}
		
public function updateMiscVendor($request)
	{
		$id=$request->ed_vendor_id;
		
		try
		{
			$dat=[
				'name'=>Str::upper($request->ed_name),
				'gst_no'=>Str::upper($request->ed_gst_no),
				'pan_no'=>Str::upper($request->ed_pan_no),
				'bank_name'=>Str::upper($request->ed_bank_name),
				'bank_ifsc'=>Str::upper($request->ed_bank_ifsc),
				'bank_account_no'=>$request->ed_bank_account_no,
				'added_by'=>Session::get('admin_id'),
			];
		$result=self::where('id',$id)->update($dat);
		
		}	
		catch(\Exceltion $e)
		{
			$result=0;
		}
		
		return $result;

	}

public function viewMiscVendors($request)  //view data
	{

		$search=$request->search;
		
		$dts=self::query();
		
		$dts->select('misc_vendors.*','admins.name as user_name')
		->leftJoin('admins','misc_vendors.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("misc_vendors.name", 'like', '%' .$search . '%')
						->orWhere("misc_vendors.gst_no", 'like', '%' .$search . '%')
						->orWhere("misc_vendors.pan_no", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%');
			  });
		
		$dats=$dts->orderBy('misc_vendors.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['vname'] =$r->name;
				$uData['gst'] =$r->gst_no;
				$uData['pan'] =$r->pan_no;
				$uData['bank'] =$r->bank_name;
				$uData['ifsc'] =$r->bank_ifsc;
				$uData['acno'] =$r->bank_account_no;
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
				<a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 

				$uData['action'] = $btn;

			  $data[] = $uData;
			}
        }
		return $data;
	}		
	

	public function getMiscVendors()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMiscVendorById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMiscVendor($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

}
