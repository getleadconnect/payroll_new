<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

use Session;

class MaterialSupply extends Model
{
    use HasFactory;
	
	protected $table='material_supply';
	
	protected $fillable = ['id','project_id','supplier_id','material_gst_id','material_gst',
						'material_type_id','material_sub_type_id','material_price_id','supply_date',
						'supply_time','lorry_no','material_unit_id','material_unit','payment_type_id',
						'quantity','price','gst_amount','round_off','amount','invoice_no','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
		'project_id'=>'required',
		'supplier_id'=>'required',
		'material_gst_id'=>'required',
		'material_price_id'=>'required',
		'material_type'=>'required',
		'material_sub_type'=>'required',
		'material_gst'=>'required',
		'material_unit'=>'required',
		'supply_date'=>'required',
		'supply_time'=>'required',
		'lorry_no'=>'required',
		'payment_type_id'=>'required',
		'quantity'=>'required',
		'price'=>'required',
		'gst_amount'=>'required',
		'amount'=>'required',
		'invoice_no'=>'required',
	];
	

	public function addMaterialSupply($request)
	{
		return self::create([
		'project_id'=>$request->project_id,
		'supplier_id'=>$request->supplier_id,
		'material_gst_id'=>$request->material_gst_id,
		'material_price_id'=>$request->material_price_id,
		'material_type_id'=>$request->material_type,
		'material_sub_type_id'=>$request->material_sub_type,
		'material_gst'=>$request->material_gst,
		'material_unit'=>$request->material_unit,
		'supply_date'=>$request->supply_date,
		'supply_time'=>$request->supply_time,
		'lorry_no'=>Str::upper($request->lorry_no),
		'payment_type_id'=>$request->payment_type_id,
		'quantity'=>$request->quantity,
		'price'=>number_format($request->price,2,'.',''),
		'gst_amount'=>number_format($request->gst_amount,2,'.',''),
		'round_off'=>number_format($request->round_off,2,'.',''),
		'amount'=>number_format($request->amount,2,'.',''),
		'invoice_no'=>Str::upper($request->invoice_no),
		'added_by'=>Session::get('admin_id'),
		'status'=>1
		]);
	}
		
	public function updateMaterialSupply($request)
	{
		
		$id=$request->material_supply_id;

		$dat=[
		'project_id'=>$request->project_id,
		'supplier_id'=>$request->supplier_id,
		'material_gst_id'=>$request->material_gst_id,
		'material_price_id'=>$request->material_price_id,
		'material_type_id'=>$request->material_type,
		'material_sub_type_id'=>$request->material_sub_type,
		'material_gst'=>$request->material_gst,
		'material_unit'=>$request->material_unit,
		'supply_date'=>$request->supply_date,
		'supply_time'=>$request->supply_time,
		'lorry_no'=>Str::upper($request->lorry_no),
		'payment_type_id'=>$request->payment_type_id,
		'quantity'=>$request->quantity,
		'price'=>number_format($request->price,2,'.',''),
		'gst_amount'=>number_format($request->gst_amount,2,'.',''),
		'round_off'=>number_format($request->round_off,2,'.',''),
		'amount'=>number_format($request->amount,2,'.',''),
		'invoice_no'=>Str::upper($request->invoice_no),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialSupply($request)  //view data
	{

		$supplier_id=$request->supplier_id;
		$search=$request->search;
			
		$dts=self::query();
		
		$projs=(new Project())->getProjects();
		$project_id="0";
		
		if(!empty($projs)) { $project_id=$projs[0]->id; }
			
		if($request->project_id!=""){ $project_id=$request->project_id; }
		
		
		if(Session::get('admin_role_id')==4)
		{
			$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
			$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();

			$dts->select('material_supply.*','projects.project_name','suppliers.supplier_name','material_types.material_type_name','material_sub_types.sub_type_name','payment_types.payment_type','admins.name')
			->leftJoin('projects','material_supply.project_id','=','projects.id')
			->leftJoin('suppliers','material_supply.supplier_id','=','suppliers.id')
			->leftJoin('material_types','material_supply.material_type_id','=','material_types.id')
			->leftJoin('payment_types','material_supply.payment_type_id','=','payment_types.id')
			->leftJoin('material_sub_types','material_supply.material_sub_type_id','=','material_sub_types.id')
			->leftJoin('admins','material_supply.added_by','=','admins.id')
			->whereBetween('material_supply.supply_date',[$start_date,$thu_date])
			->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("suppliers.supplier_name", 'like', '%' .$search . '%')
						->orWhere("material_supply.material_gst", 'like', '%' .$search . '%');

			  });
		}
		else
		{
			$dts->select('material_supply.*','projects.project_name','suppliers.supplier_name','material_types.material_type_name','material_sub_types.sub_type_name','payment_types.payment_type','admins.name')
			->leftJoin('projects','material_supply.project_id','=','projects.id')
			->leftJoin('suppliers','material_supply.supplier_id','=','suppliers.id')
			->leftJoin('material_types','material_supply.material_type_id','=','material_types.id')
			->leftJoin('payment_types','material_supply.payment_type_id','=','payment_types.id')
			->leftJoin('material_sub_types','material_supply.material_sub_type_id','=','material_sub_types.id')
			->leftJoin('admins','material_supply.added_by','=','admins.id')
			
			->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("suppliers.supplier_name", 'like', '%' .$search . '%')
						->orWhere("material_supply.material_gst", 'like', '%' .$search . '%');

			  });
		}
			  
		if($project_id!="" and $supplier_id!="")	  
		{
			$dts->where('material_supply.project_id',$project_id)->where('material_supply.supplier_id',$supplier_id);
		}
		else if($project_id=="" and $supplier_id!="")	  
		{
			$dts->where('material_supply.supplier_id',$supplier_id);
		}
		else if($project_id!="" and $supplier_id=="")	  
		{
			$dts->where('material_supply.project_id',$project_id);
		}
					  
		$dats=$dts->orderBy('material_supply.id','ASC')->get();

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
					$uData['project'] =$r->project_name;
					$uData['supplier'] =$r->supplier_name;
					$uData['item'] =$r->material_type_name."-".$r->sub_type_name;
					$uData['gst'] =$r->material_gst."%";
					$uData['inv_no'] =$r->invoice_no;
					$uData['lno'] =$r->lorry_no;
					$uData['sdate'] =($r->supply_date!="")?Carbon::createFromFormat('Y-m-d', $r->supply_date)->format('d-m-Y'):'--';
					$uData['stime'] =($r->supply_time!="")?Carbon::createFromFormat('H:i:s', $r->supply_time)->format('h:i A'):'--';
					$uData['unit'] =$r->material_unit;
					$uData['ptype'] =$r->payment_type;
					$uData['qty'] =$r->quantity;
					$uData['price'] =number_format($r->price,2,'.',',');
					$uData['gamt'] =number_format($r->gst_amount,2,'.',',');
					$uData['roff'] =number_format($r->round_off,2,'.',',');
					$uData['amt'] =number_format($r->amount,2,'.',',');
					$uData['status'] =$st;
					$uData['addedby'] =$r->name;
					
					$btn='<a href="'.url('edit-material-supply')."/".$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm" title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialSupplys()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialSupplyById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialSupply($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
