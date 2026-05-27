<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;

use DB;
use Session;
use Carbon\Carbon;

class MiscWork extends Model
{
    use HasFactory;
	
	protected $table='misc_works';
	
	protected $fillable = ['id','project_id','misc_category_id','misc_vendor_id','description',
	'invoice_no','invoice_date','gst_amount','total_amount','payment_type_id','added_by'];
	
	protected $primaryKey="id";

	protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'misc_category_id'=>'required',
	'misc_vendor_id'=>'required',
	'description'=>'required',
	'invoice_no'=>'required',
	'invoice_date'=>'required',
	'gst_amount'=>'required',
	'total_amount'=>'required',
	'payment_type'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_misc_category_id'=>'required',
	'ed_misc_vendor_id'=>'required',
	'ed_description'=>'required',
	'ed_invoice_no'=>'required',
	'ed_invoice_date'=>'required',
	'ed_gst_amount'=>'required',
	'ed_total_amount'=>'required',
	'ed_payment_type'=>'required',
	];
		
		
	public function addMiscWork($request)
	{
		try
		{
			$result=self::create([
				'project_id'=>$request->project_id,
				'misc_category_id'=>$request->misc_category_id,
				'misc_vendor_id'=>$request->misc_vendor_id,
				'description'=>Str::upper($request->description),
				'invoice_no'=>Str::upper($request->invoice_no),
				'invoice_date'=>$request->invoice_date,
				'gst_amount'=>$request->gst_amount,
				'total_amount'=>$request->total_amount,
				'payment_type_id'=>$request->payment_type,
				'added_by'=>Session::get('admin_id'),
			]);
		}	
		catch(\Exceltion $e)
		{
			$result=0;
		}
		
		return $result;

	}
		
public function updateMiscWork($request)
	{
		$id=$request->ed_work_id;
		
		try
		{
			$dat=[
				'project_id'=>$request->ed_project_id,
				'misc_category_id'=>$request->ed_misc_category_id,
				'misc_vendor_id'=>$request->ed_misc_vendor_id,
				'description'=>Str::upper($request->ed_description),
				'invoice_no'=>Str::upper($request->ed_invoice_no),
				'invoice_date'=>$request->ed_invoice_date,
				'gst_amount'=>$request->ed_gst_amount,
				'total_amount'=>$request->ed_total_amount,
				'payment_type_id'=>$request->ed_payment_type,
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

public function viewMiscWorks($request)  //view data
 {

		$vid=$request->searchVendor;
		$spay=$request->searchPay;
		
		$projs=(new Project())->getProjects();
		$proid="0";
		
		if(!empty($projs)) { $proid=$projs[0]->id; }
		
		$search=$request->search;
		
		if($request->searchPro!=""){ $proid=$request->searchPro; }
		
		$dts=self::query();
				
		if(Session::get('admin_role_id')==4)
		{
			$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
			$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();

		
		$dts->select('misc_works.*','misc_vendors.name','projects.project_name','misc_category.category_name','payment_types.payment_type','admins.name as user_name')
		->leftJoin('projects','misc_works.project_id','=','projects.id')
		->leftJoin('misc_category','misc_works.misc_category_id','=','misc_category.id')
		->leftJoin('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
		->leftJoin('payment_types','misc_works.payment_type_id','=','payment_types.id')
		->leftJoin('admins','misc_vendors.added_by','=','admins.id')
		->whereBetween('misc_works.invoice_date',[$start_date,$thu_date]);
		}
		else
		{
			$dts->select('misc_works.*','misc_vendors.name','projects.project_name','misc_category.category_name','payment_types.payment_type','admins.name as user_name')
			->leftJoin('projects','misc_works.project_id','=','projects.id')
			->leftJoin('misc_category','misc_works.misc_category_id','=','misc_category.id')
			->leftJoin('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
			->leftJoin('payment_types','misc_works.payment_type_id','=','payment_types.id')
			->leftJoin('admins','misc_vendors.added_by','=','admins.id');
		}
		
		$dts->where(function($where) use($search)
			    {
					$where->where("misc_vendors.name", 'like', '%' .$search . '%')
						->orWhere("misc_category.category_name", 'like', '%' .$search . '%')
						->orWhere("misc_works.invoice_no", 'like', '%' .$search . '%')
						->orWhere("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("payment_types.payment_type", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%');
			  });
			  
		if($proid!="" and $vid!="" and $spay!="")
		{
			$dts->where('misc_works.project_id',$proid)->where('misc_works.misc_vendor_id',$vid)->where('misc_works.payment_type_id',$spay);
		}
		else if($proid!="" and $vid=="" and $spay=="")
		{
			$dts->where('misc_works.project_id',$proid);
		}
		else if($proid!="" and $vid!="" and $spay=="")
		{
			$dts->where('misc_works.project_id',$proid)->where('misc_works.misc_vendor_id',$vid);
		}
		else if($proid!="" and $vid=="" and $spay!="")
		{
			$dts->where('misc_works.project_id',$proid)->where('misc_works.payment_type_id',$spay);
		}
		else 
		{
			$dts->where('misc_works.project_id',$proid);
		}
		
		$dats=$dts->orderBy('misc_works.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				$uData['id'] = ++$key;
				$uData['pname'] =Str::upper($r->project_name);
				$uData['mcat'] =Str::upper($r->category_name);
				$uData['vname'] =Str::upper($r->name);
				$uData['desc'] =Str::upper($r->description);
				$uData['inv_no'] =Str::upper($r->invoice_no);
				$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['gamt'] =number_format($r->gst_amount,2,'.',',');
				$uData['tamt'] ="<b>".number_format($r->total_amount,2,'.',',')."</b>";
				$uData['paid_id'] =$r->payment_type;
				$uData['addedby'] =$r->user_name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a>
				<a href="javascript:void(0)" id="'.$r->id.'" class="btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 

				$uData['action'] = $btn;

			  $data[] = $uData;
			}
        }
		return $data;
	}		
	

	public function getMiscWorks()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMiscWorkById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMiscWork($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

}
