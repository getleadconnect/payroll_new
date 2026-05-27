<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;
use Carbon\Carbon;

class SubcontractorWork extends Model
{
    use HasFactory;
	
	protected $table='subcontractor_works';
	
	protected $fillable = ['id','entry_date','project_id','subcontractor_id','floor_no_id',
	'main_cost_center_id','subcontractor_rate_id','material_unit_id',
	'description','length','bredth','width','nos','quantity','item_rate','amount','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'subcontractor_id'=>'required',
	'nos'=>'required',
	'floor_no'=>'required',
	'main_cost_center_id'=>'required',
	'item_name'=>'required',
	'item_rate'=>'required',
	'quantity'=>'required',
	'description'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_subcontractor_id'=>'required',
	'ed_item_id'=>'required',
	'ed_item_rate'=>'required',
	'ed_quantity'=>'required',
	'ed_description'=>'required',
	];
	
	public function addSubcontractorWork($request)
	{
		
		$edate=date('Y-m-d');
		$pro_id=$request->project_id;
		$sc_id=$request->subcontractor_id;
		$floor_id=$request->floor_no;
		$item_id=$request->item_name;
		$rate_id=$request->rate_id;
		$rate=$request->item_rate;
		$unit=$request->unit_id;
				
		$result=false;
		
		$desc=$request->description;
		
		$sci=SubcontractorItem::where('id',$item_id)->first();
		if(!empty($sci)){$mcid=$sci->main_cost_item_id;}else{$mcid=0;}		
		
		
		try
		{
		
		  foreach($desc as $key=>$r)
		  {
				if($r!="")
				{
					
				    $result=self::create([
						'entry_date'=>date('Y-m-d'),
						'project_id'=>$pro_id,
						'main_cost_center_id'=>$request->main_cost_center_id,
						'floor_no_id'=>$request->floor_no,
						//'main_cost_item_id'=>$mcid,
						'subcontractor_id'=>$sc_id,
						'subcontractor_rate_id'=>$rate_id,
						'material_unit_id'=>$unit,
						'nos'=>$request->nos[$key]??0,
						'length'=>number_format($request->length[$key]??0,2,'.',''),
						'width'=>number_format($request->width[$key]??0,2,'.',''),
						'bredth'=>number_format($request->bredth[$key]??0,2,'.',''),
						'quantity'=>number_format($request->quantity[$key]??0,2,'.',''),
						'item_rate'=>number_format($rate,2,'.',''),
						'amount'=>round($request->amount[$key]??0,0),
						'description'=>Str::upper($r),
						'added_by'=>Session::get('admin_id'),
					]);
				}

		  }

		}
		catch(\Exception $e)
		{
			$result=$e->getMessage();
		}

		return $result;
	}
	
		
	public function updateSubcontractorWork($request)
	{
		
		$id=$request->ed_subcon_work_id;

		$dat=[
			'subcontractor_id'=>$request->ed_subcontractor_id,
			'floor_no_id'=>$request->ed_floor_no,
			'subcontractor_rate_id'=>$request->ed_item_id,
			'material_unit_id'=>$request->ed_unit_id,
			'nos'=>$request->ed_nos??0,
			'length'=>number_format($request->ed_length??0,2,'.',''),
			'width'=>number_format($request->ed_width??0,2,'.',''),
			'bredth'=>number_format($request->ed_bredth??0,2,'.',''),
			'quantity'=>number_format($request->ed_quantity??0,2,'.',''),
			'item_rate'=>number_format($request->ed_item_rate??0,2,'.',''),
			'amount'=>round($request->ed_amount,0),
			'description'=>Str::upper($request->ed_description),
			'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function viewSubcontractorWorks($request)  //view data
	{
		
		$user_id=auth()->guard('admin')->user()->id;
		
		$search=$request->search;
		$contractor_id=$request->contractor_id;
		$period_from=$request->period_from;
		$period_to=$request->period_to;
		
		$dts=self::query();
		
		$dts->select('subcontractor_works.*','subcontractors.name','subcontractor_items.item_name','material_units.unit_name','floor_nos.floor_no','admins.name as user_name')
			->leftJoin('subcontractors','subcontractor_works.subcontractor_id','=','subcontractors.id')
			->leftJoin('subcontractor_rates','subcontractor_works.subcontractor_rate_id','=','subcontractor_rates.id')
			->leftJoin('subcontractor_items','subcontractor_rates.subcontractor_item_id','=','subcontractor_items.id')
			->leftJoin('floor_nos','subcontractor_works.floor_no_id','=','floor_nos.id')
			->leftJoin('material_units','subcontractor_works.material_unit_id','=','material_units.id')
			->leftJoin('admins','subcontractor_works.added_by','=','admins.id');
		
		if(Session::get('admin_role_id')==4)
		{
			$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
			$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();
			
			$dts->whereBetween('subcontractor_works.entry_date',[$start_date,$thu_date])
			    ->where('subcontractor_works.added_by',$user_id);
		}
		
		$dts->where(function($where) use($search)
			{
					$where->where("subcontractors.name", 'like', '%' .$search . '%')
						->orWhere("subcontractor_items.item_name", 'like', '%' .$search . '%')
						->orWhere("material_units.unit_name", 'like', '%' .$search . '%');
			  });

		if($contractor_id=="" )
		{
		   	$dts->where('entry_date','>=',date('Y-m-d',strtotime("-6 months")));
		}
			  
		if($contractor_id!="" and $period_from=="" and $period_to=="")
		{
			$dts->where('subcontractor_works.subcontractor_id',$contractor_id);
		}
		else if($contractor_id!="" and $period_from!="" and $period_to!="")
		{
		    $dts->where('subcontractor_works.subcontractor_id',$contractor_id)
			     ->whereBetween('entry_date',[$period_from,$period_to]);
		}
			  
		$dats=$dts->orderBy('subcontractor_works.id','ASC')->get();

			
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				$mcc=MainCostCenter::select('main_cost_items.main_item')
				->leftJoin('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
				->where('main_cost_center.id',$r->main_cost_center_id)
				->first();
				
				$mcc_item="--";
				if(!empty($mcc))
				{
					$mcc_item=$mcc->main_item;
				}
				
					$uData['id'] = ++$key;
					$uData['cdate'] =date_create($r->entry_date)->format('d-m-Y');
					$uData['scon'] =$r->name;
					$uData['nos'] =$r->nos;
					$uData['fno'] =$r->floor_no;
					$uData['mcc'] =$mcc_item;
					$uData['iname'] =$r->item_name;
					$uData['unit'] =$r->unit_name;
					$uData['desc'] =$r->description;
					$uData['length'] =$r->length?number_format($r->length,2,'.',''):"--";
					$uData['bredth'] =$r->bredth?number_format($r->bredth,2,'.',''):"--";
					$uData['width'] =$r->width?number_format($r->width,2,'.',''):"--";
					$uData['qty'] =number_format($r->quantity,2,'.','');
					$uData['rate'] =number_format($r->item_rate,2,'.',',');
					$uData['amt'] =number_format($r->amount,2,'.',',');
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow  btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					//$uData['action'] = $btn."&nbsp;".$btns;
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getSubcontractorWorks()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSubcontractorWorkById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSubcontractorWork($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
