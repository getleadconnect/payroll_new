<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;
use Session;
use Carbon\Carbon;

class MiscSiteExpense extends Model
{
    use HasFactory;
	
	protected $table='misc_site_expenses';
	
	protected $fillable = ['id','project_id','misc_category_id','payment_type_id',
	'item_name','invoice_date','invoice_no','description','amount','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'category_id'=>'required',
	'payment_type'=>'required',
	'item_name'=>'required',
	'invoice_date'=>'required',
	'invoice_no'=>'required',
	'description'=>'required',
	'amount'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_category_id'=>'required',
	'ed_payment_type'=>'required',
	'ed_item_name'=>'required',
	'ed_invoice_date'=>'required',
	'ed_invoice_no'=>'required',
	'ed_description'=>'required',
	'ed_amount'=>'required',
	];
	
	
	public function addMiscSiteExpense($request)
	{
		return self::create([
		'project_id'=>$request->project_id,
		'misc_category_id'=>$request->category_id,
		'payment_type_id'=>$request->payment_type,
		'item_name'=>Str::upper($request->item_name),
		'description'=>Str::upper($request->description),
		'invoice_date'=>$request->invoice_date,
		'invoice_no'=>$request->invoice_no,
		'amount'=>$request->amount,
		'added_by'=>Session::get('admin_id'),
		]);
	}
		
	public function updateMiscSiteExpense($request)
	{
		
		$id=$request->ed_site_exp_id;

		$dat=[
		'project_id'=>$request->ed_project_id,
		'misc_category_id'=>$request->ed_category_id,
		'payment_type_id'=>$request->ed_payment_type,
		'item_name'=>Str::upper($request->ed_item_name),
		'description'=>Str::upper($request->ed_description),
		'invoice_date'=>$request->ed_invoice_date,
		'invoice_no'=>$request->ed_invoice_no,
		'amount'=>$request->ed_amount,
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function viewMiscSiteExpenses($request)  //view data
	{
		$projs=(new Project())->getProjects();
		$pid="0";
		
		if(!empty($projs)) { $pid=$projs[0]->id; }
		
		$search=$request->search;
		if($request->searchProjectId!=""){ 	$pid=$request->searchProjectId; }
		
		$dts=MiscSiteExpense::query();
		
		if(Session::get('admin_role_id')==4)
		{
			$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
			$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();

			$dts->select('misc_site_expenses.*','projects.project_name','misc_category.category_name','payment_types.payment_type','admins.name')
			->leftJoin('projects','misc_site_expenses.project_id','=','projects.id')
			->leftJoin('misc_category','misc_site_expenses.misc_category_id','=','misc_category.id')
			->leftJoin('payment_types','misc_site_expenses.payment_type_id','=','payment_types.id')
			->leftJoin('admins','misc_site_expenses.added_by','=','admins.id')
			->where('misc_site_expenses.project_id',$pid)
			->whereBetween('misc_site_expenses.invoice_date',[$start_date,$thu_date]);

		}
		else
		{
			$dts->select('misc_site_expenses.*','projects.project_name','misc_category.category_name','payment_types.payment_type','admins.name')
			->leftJoin('projects','misc_site_expenses.project_id','=','projects.id')
			->leftJoin('misc_category','misc_site_expenses.misc_category_id','=','misc_category.id')
			->leftJoin('payment_types','misc_site_expenses.payment_type_id','=','payment_types.id')
			->leftJoin('admins','misc_site_expenses.added_by','=','admins.id')
			->where('misc_site_expenses.project_id',$pid);
		}			
		
		$dats=$dts->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("misc_site_expenses.item_name", 'like', '%' .$search . '%')
						->orWhere("misc_site_expenses.invoice_date", 'like', '%' .$search . '%')
						->orWhere("misc_site_expenses.invoice_no", 'like', '%' .$search . '%')
						->orWhere("misc_category.category_name", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("misc_site_expenses.amount", 'like', '%' .$search . '%');
						
			  })->orderBy('misc_site_expenses.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['cdate'] =date_create($r->created_at)->format('d-m-Y');
				$uData['pname'] =Str::upper($r->project_name);
				$uData['mcat'] =Str::upper($r->category_name);
				$uData['ptype'] =Str::upper($r->payment_type);
				$uData['iname'] =Str::upper($r->item_name);
				$uData['desc'] =Str::upper($r->description);
				$uData['ivdate'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['ivno'] =Str::upper($r->invoice_no);
				$uData['amt'] =number_format($r->amount,2,'.',',');
				$uData['addedby'] =$r->name;
				
				$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				//$uData['action'] = $btn."&nbsp;".$btns;
				$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMiscSiteExpenses()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMiscSiteExpenseById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
		
	public function deleteMiscSiteExpense($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
}
