<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Session;

class MaterialPrice extends Model
{
    use HasFactory;
	
	protected $table='material_prices';
	
	protected $fillable = ['id','project_id','supplier_id','material_type_id',
	'material_sub_type_id','material_unit_id','price_date','price','status','added_by'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'project_id'=>'required',
	'supplier_id'=>'required',
	'material_type_id'=>'required',
	'material_sub_type_id'=>'required',
	'material_unit_id'=>'required',
	'price_date'=>'required',
	'price'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_project_id'=>'required',
	'ed_supplier_id'=>'required',
	'ed_material_type_id'=>'required',
	'ed_material_sub_type_id'=>'required',
	'ed_material_unit_id'=>'required',
	'ed_price_date'=>'required',
	'ed_price'=>'required',
	];
	
	public function addMaterialPrice($request)
	{
		return self::create([
		'project_id'=>$request->project_id,
		'supplier_id'=>$request->supplier_id,
		'material_type_id'=>$request->material_type_id,
		'material_sub_type_id'=>$request->material_sub_type_id,
		'material_unit_id'=>$request->material_unit_id,
		'price_date'=>$request->price_date,
		'price'=>number_format($request->price,2,'.',''),
		'added_by'=>Session::get('admin_id'),
		'status'=>1
		]);
	}
		
	public function updateMaterialPrice($request)
	{
		
		$id=$request->ed_mat_price_id;

		$dat=[
		'project_id'=>$request->ed_project_id,
		'supplier_id'=>$request->ed_supplier_id,
		'material_type_id'=>$request->ed_material_type_id,
		'material_sub_type_id'=>$request->ed_material_sub_type_id,
		'material_unit_id'=>$request->ed_material_unit_id,
		'price_date'=>$request->ed_price_date,
		'price'=>number_format($request->ed_price,2,'.',''),
		'added_by'=>Session::get('admin_id'),
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


public function viewMaterialPrices($request)  //view data
	{

		$search=$request->search;
		$project_id=$request->project_id;
		$supplier_id=$request->supplier_id;
				
		$dts=self::query();
		
		$dts->select('material_prices.*','projects.project_name','suppliers.supplier_name','material_types.material_type_name','material_sub_types.sub_type_name','material_units.unit_name','admins.name as user_name')
		->leftJoin('projects','material_prices.project_id','=','projects.id')
		->leftJoin('suppliers','material_prices.supplier_id','=','suppliers.id')
		->leftJoin('material_types','material_prices.material_type_id','=','material_types.id')
		->leftJoin('material_sub_types','material_prices.material_sub_type_id','=','material_sub_types.id')
		->leftJoin('material_units','material_prices.material_unit_id','=','material_units.id')
		->leftJoin('admins','material_prices.added_by','=','admins.id')
		
		->where(function($where) use($search)
			    {
					$where->where("projects.project_name", 'like', '%' .$search . '%')
						->orWhere("suppliers.supplier_name", 'like', '%' .$search . '%')
						->orWhere("material_types.material_type_name", 'like', '%' .$search . '%')
						->orWhere("material_sub_types.sub_type_name", 'like', '%' .$search . '%')
						->orWhere("admins.name", 'like', '%' .$search . '%')
						->orWhere("material_units.unit_name", 'like', '%' .$search . '%');
			  });
			  
		if($project_id!="" and $supplier_id!="")	  
		{
			$dts->where('material_prices.project_id',$project_id)->where('material_prices.supplier_id',$supplier_id);
		}
		else if($project_id!="" and $supplier_id=="")	  
		{
			$dts->where('material_prices.project_id',$project_id);
		}
		else if($project_id=="" and $supplier_id!="")	  
		{
			$dts->where('material_prices.supplier_id',$supplier_id);
		}
	
		$dats=$dts->orderBy('material_prices.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
					
					if($r->status==1)
					{
						$st='<span class="badge badge-success">Active</span>';
						$btns='<a href="javascript:void(0)" id="'.$r->id.'" res=2 class="btnActDeact btn-outline-warning shadow btn-b-sm " title="Deactivate Company"><i class="fa fa-times" style="padding:0px 1px 0px 1px;" ></i></a>';
						
					}
					else
					{
						$st='<span class="badge badge-danger">Inactive</span>';
					    $btns='<a href="javascript:void(0)" id="'.$r->id.'" res=1 class="btnActDeact btn-outline-success shadow btn-b-sm " title="Activate Company"><i class="fa fa-check"></i></a>';
					}
				
					$uData['id'] = ++$key;
					$uData['project'] =$r->project_name;
					$uData['supplier'] =$r->supplier_name;
					$uData['mtype'] =$r->material_type_name;
					$uData['mstype'] =$r->sub_type_name;
					$uData['unit'] =$r->unit_name;
					$uData['pdate'] =($r->price_date!="")?Carbon::createFromFormat('Y-m-d', $r->price_date)->format('d-m-Y'):'--';
					$uData['price'] ="₹ ".number_format($r->price,2,'.',',');
					$uData['status'] =$st;
					$uData['addedby'] =$r->user_name;
					
					$btn='<a href="javascript:void(0)" id="'.$r->id.'" class="edit btn-outline-secondary shadow btn-b-sm " data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						  <a href="javascript:void(0)" id="'.$r->id.'" class=" btndel btn-outline-danger shadow btn-b-sm " title="Delete"><i class="fa fa-trash"></i></a>'; 
					
					$uData['action'] = $btn."&nbsp;".$btns;

			    $data[] = $uData;
			}
        }
		return $data;
	}		

	public function getMaterialPrices()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getMaterialPriceById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteMaterialPrice($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	
	
}
