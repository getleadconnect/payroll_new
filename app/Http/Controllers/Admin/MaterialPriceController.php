<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\MaterialPrice;
use App\Models\MaterialType;
use App\Models\MaterialSubType;
use App\Models\MaterialUnit;
use App\Models\Supplier;
use App\Models\Project;


use Validator;
use DataTables;
use Session;


class MaterialPriceController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$proj=(new Project())->getProjects();  
	$supp=(new Supplier())->getSuppliers();
	$mtype=(new MaterialType())->getMaterialTypes();
	$munit=(new MaterialUnit())->getMaterialUnits();  
    return view('admin.material_price.material_price',compact('proj','supp','mtype','munit'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MaterialPrice::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MaterialPrice())->addMaterialPrice($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material price successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-prices');
	}
	
	public function edit($id)
	{
		$mp=(new MaterialPrice())->getMaterialPriceById($id);
		$proj=(new Project())->getProjects();  
		$supp=(new Supplier())->getSuppliers();
		$mtype=(new MaterialType())->getMaterialTypes();
		$munit=(new MaterialUnit())->getMaterialUnits();  
		$mstype=(new MaterialSubType())->getMaterialSubTypeBy_TypeId($mp->material_type_id);	
	
		return view('admin.material_price.edit_material_price',compact('mp','proj','supp','mtype','munit','mstype'));
	}
		
	 public function update_material_price(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialPrice::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialPrice())->updateMaterialPrice($request);

			if($result)
			{
				Session::flash('message', 'success#Material price successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-prices');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialPrice())->deleteMaterialPrice($id);
		
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
            $data = (new MaterialPrice())->viewMaterialPrices($request);

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

		$result=MaterialPrice::where('id',$id)->update($new);

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
	
	
	public function get_material_sub_types($id)
	{
		$dat=MaterialSubType::where('material_type_id',$id)->orderBy('id','ASC')->get();
		$opt="<option value=''>--select--</option>";
		if(!$dat->isEmpty())
		{
			foreach($dat as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->sub_type_name."</option>";
			}
		}
		return $opt;
	}
	
	
}
