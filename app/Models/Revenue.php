<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//use App\Models\Company;
//use App\Models\Client;

use Carbon\Carbon;
use Session;

class Revenue extends Model
{
    use HasFactory;
	
	protected $table='revenue';
	
	protected $fillable = ['id','entry_date','revenue_type','project_id','staff_id','voucher_no',
				'voucher_date','cash_cheque','income','expense','description','to_date','added_by'
			];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
		'entry_date'=>'required',
		'revenue_type'=>'required',
		'project_id'=>'required',
		'staff_id'=>'required',
		'voucher_no'=>'required',
		'voucher_date'=>'required',
		'cash_cheque'=>'required',
		'amount'=>'required',
		'description'=>'required',
	];
	
	public const EDIT_RULES=[
		'ed_entry_date'=>'required',
		'ed_revenue_type'=>'required',
		'ed_project_id'=>'required',
		'ed_staff_id'=>'required',
		'ed_voucher_no'=>'required',
		'ed_voucher_date'=>'required',
		'ed_cash_cheque'=>'required',
		'ed_amount'=>'required',
		'ed_description'=>'required',
	];
	
	public function addRevenue($request)
	{
		
		if($request->revenue_type=="GET")
		{
			$income=$request->amount;
			$expense=0;
		}
		else
		{
			$income=0;
			$expense=$request->amount;
		}			
				
		return self::create([
			'entry_date'=>$request->entry_date,
			'revenue_type'=>$request->revenue_type,
            'project_id'=>$request->project_id,
            'staff_id'=>$request->staff_id,
            'voucher_no'=>$request->voucher_no,
            'voucher_date'=>$request->voucher_date,
            'cash_cheque'=>Str::upper($request->cash_cheque),
            'income'=>$income,
            'expense'=>$expense,
            'description'=>Str::upper($request->description),
            'to_date'=>Carbon::createFromFormat('Y-m-d', $request->entry_date)->addDays(6),
			'added_by'=>Session::get('admin_id'),
			]);
	}
		
	public function updateRevenue($request)
	{
		
		$id=$request->ed_revenue_id;

		if($request->ed_revenue_type=="GET")
		{
			$income=$request->ed_amount;
			$expense=0;
		}
		else
		{
			$income=0;
			$expense=$request->ed_amount;
		}			
				
				
		$dat=[
		    'revenue_type'=>$request->ed_revenue_type,
            'project_id'=>$request->ed_project_id,
            'staff_id'=>$request->ed_staff_id,
            'voucher_no'=>$request->ed_voucher_no,
            'voucher_date'=>$request->ed_voucher_date,
            'cash_cheque'=>Str::upper($request->ed_cash_cheque),
            'income'=>$income,
            'expense'=>$expense,
            'description'=>Str::upper($request->ed_description),
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function viewRevenues($request)  //view data
	{

		$search=$request->search;
		
		$dats=self::select('revenue.*','projects.project_name','staffs.name','admins.name as user_name')
		->leftJoin('staffs','revenue.staff_id','=','staffs.id')
		->leftJoin('projects','revenue.project_id','=','projects.id')
		->leftJoin('admins','revenue.added_by','=','admins.id')
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("staffs.name", 'like', '%' .$search . '%')
                        ->orWhere("revenue.voucher_no", 'like', '%' .$search . '%')
                        ->orWhere("revenue.voucher_date", 'like', '%' .$search . '%')
						->orWhere("revenue.entry_date", 'like', '%' .$search . '%');
			  });
			  
		if($request->projectId!="" and $request->staffId!="")
			{
				$dats->where('revenue.project_id',$request->projectId)->where('revenue.staff_id',$request->staffId);
			}
		elseif($request->projectId!="")
			{
				$dats->where('revenue.project_id',$request->projectId);
			}
		elseif($request->staffId!="")
			{
				$dats->where('revenue.staff_id',$request->staffId);
			}

		$datas=$dats->orderBy('revenue.id','DESC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($datas))
        {
			foreach ($datas as $key=>$r)
            {

					$uData['id'] = ++$key;
					$uData['edate'] =date_create($r->entry_date)->format('d-m-Y');
                    $uData['rtype'] =$r->revenue_type;
					$uData['pname'] =$r->project_name;
					$uData['stname'] =$r->name;
					$uData['vno'] =$r->voucher_no;
                    $uData['vdate'] =date_create($r->voucher_date)->format('d-m-Y');
                    $uData['trans'] =$r->cash_cheque;
					$uData['inc_amt'] =number_format($r->income,2,'.',',');
                    $uData['ret_amt'] =number_format($r->expense,2,'.',',');
                    $uData['desc'] =$r->description;
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		
	


	public function getRevenue()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getRevenueById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
		
	public function deleteRevenue($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
