<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\MaterialSupply;
use App\Models\MaterialType;
use App\Models\MaterialSubType;
use App\Models\MaterialUnit;
use App\Models\Supplier;
use App\Models\Project;
use App\Models\MaterialGst;
use App\Models\MaterialPrice;
use App\Models\PaymentType;


use Validator;
use DataTables;
use Session;


class MaterialSupplyController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$projs=(new Project())->getProjects();  
	$supp=(new Supplier())->getSuppliers();
	/*$mtype=(new MaterialType())->getMaterialTypes();
	$munit=(new MaterialUnit())->getMaterialUnits();  */
	
    return view('admin.materials.material_supply',compact('projs','supp'));
  }	
  
  public function add_material_supply()
  {
	$proj=(new Project())->getProjects();  
	$supp=(new Supplier())->getSuppliers();
	$munit=(new MaterialUnit())->getMaterialUnits(); 
	$gst=(new MaterialGst())->getMaterialGst();
	$ptype=(new PaymentType())->getPaymentTypes();
	return view('admin.materials.add_material_supply',compact('proj','supp','munit','gst','ptype'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MaterialSupply::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MaterialSupply())->addMaterialSupply($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('add-material-supply');
	}
	
	public function edit($id)
	{
		$ms=(new MaterialSupply())->getMaterialSupplyById($id);
		$proj=(new Project())->getProjects();  
		$supp=(new Supplier())->getSuppliers();
		$mtype=(new MaterialType())->getMaterialTypes();
		$munit=(new MaterialUnit())->getMaterialUnits(); 
		$ptype=(new PaymentType())->getPaymentTypes();		
		$mstype=(new MaterialSubType())->getMaterialSubTypeBy_TypeId($ms->material_type_id);	
		return view('admin.materials.edit_material_supply',compact('ms','proj','supp','mtype','munit','mstype','ptype'));
	}
		
	 public function update_material_supply(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialSupply::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialSupply())->updateMaterialSupply($request);

			if($result)
			{
				Session::flash('message', 'success#Material price successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-supply');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialSupply())->deleteMaterialSupply($id);
		
			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				
			return $res;
	}
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new MaterialSupply())->viewMaterialSupply($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status'])
                    ->make(true);
        }
		
	}

	public function activate_deactivate($id,$op)
	{
		if($op==1)
		{
		   $new=['status'=>1];
		}
		else
		{	
		   $new=['status'=>0];
		}

		$result=MaterialSupply::where('id',$id)->update($new);

			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				

			return $res;
	}
	
	
	public function get_material_suppliers($pid)
	{
		$dat=Supplier::select('suppliers.id','suppliers.supplier_name')
			->Join('material_prices', function ($join) use($pid) {
					$join->on('suppliers.id', '=', 'material_prices.supplier_id')
					->where('material_prices.project_id',$pid);
			})
			->groupBy('suppliers.id','suppliers.supplier_name')
			->orderBy('suppliers.id','ASC')->get();
						
		$opt="<option value=''>--select--</option>";
		if(!$dat->isEmpty())
		{
			foreach($dat as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->supplier_name."</option>";
			}
		}
		return $opt; 
	}
	
	
	public function get_material_types($id,$pid)
	{
		$mtypes=MaterialPrice::select('material_type_id','material_types.material_type_name')
				->leftJoin('material_types','material_types.id','=','material_prices.material_type_id')
			    ->where('material_prices.project_id',$pid)->where('material_prices.supplier_id',$id)
				->groupBy('material_type_id','material_types.material_type_name')
				->get();
				
		$opt="<option value=''>--select--</option>";
		
		if(!$mtypes->isEmpty())
		{
			foreach($mtypes as $r)
			{
				$opt.="<option value='".$r->material_type_id."'>".$r->material_type_name."</option>";
			}
		}
		return $opt;
	}
	
	
	public function get_supply_material_sub_types($id)
	{
		
		$mstypes=MaterialPrice::select('material_sub_type_id','material_sub_types.sub_type_name')
				->leftJoin('material_sub_types','material_sub_types.id','=','material_prices.material_sub_type_id')
			    ->where('material_prices.material_type_id',$id)
				->groupBy('material_sub_type_id','material_sub_types.sub_type_name')
				->get();
				
		$opt="<option value=''>--select--</option>";
		
		if(!$mstypes->isEmpty())
		{
			foreach($mstypes as $r)
			{
				$opt.="<option value='".$r->material_sub_type_id."'>".$r->sub_type_name."</option>";
			}
		}
		return $opt;
	}
	
	
	public function get_material_price_details($id,$prid,$spid)
	{
		$mp=MaterialPrice::select('material_prices.*','material_sub_types.sub_type_name')
				->leftJoin('material_sub_types','material_sub_types.id','=','material_prices.material_sub_type_id')
			    ->where('material_prices.project_id',$prid)->where('material_prices.supplier_id',$spid)
			    ->where('material_prices.material_sub_type_id',$id)				
				->orderBy('material_prices.id','DESC')->first();
				
		$price_dt=[];	
		$gst=0;$gst_id=0; $unit=0; $unit_id=0; $pr=0;$pr_id=0;
		
		if(!empty($mp))
		{
			$pr_id=$mp->id;
		    
			$mgst=MaterialGst::where('material_type_id',$mp->material_type_id)->orderBy('id','DESC')->first();
			if(!empty($mgst)){$gst=$mgst->gst;$gst_id=$mgst->id;}else{$gst=0;$gst_id=0;	}
			
			$munit=MaterialUnit::where('id',$mp->material_unit_id)->first();
			if(!empty($munit)){$unit=$munit->unit_name;$unit_id=$munit->id;}else{$unit=0;}
			
			$pr=$mp->price;
		}

		$price_dt=[
		'gst_id'=>$gst_id,
		'gst'=>$gst,
		'unit_id'=>$unit_id,
		'unit'=>$unit,
		'price_id'=>$pr_id,
		'price'=>$pr,
		];

		return json_encode($price_dt);
	}
	
}
