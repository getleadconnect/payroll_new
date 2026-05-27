<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\SubcontractorRate;
use App\Models\Subcontractor;
use App\Models\SubcontractorItem;
use App\Models\Company;
use App\Models\Project;
use App\Models\MaterialUnit;

use Validator;
use DataTables;
use Session;


class SubcontractorRateController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$scon=(new Subcontractor())->getSubcontractors();
	$projs=(new Project())->getProjects(); 
	$sitems=(new SubcontractorItem())->getSubcontractorItems();  	
    return view('admin.subcontractor_rate.subcontractor_rate',compact('projs','scon','sitems'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SubcontractorRate::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new SubcontractorRate())->addSubcontractorRate($request);
		   
			if($result)
			{
				Session::flash('message', 'success#SubcontractorRate successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('sub-contractor-rates');
	}
	
	public function edit($id)
	{
		$sr=(new SubcontractorRate())->getSubcontractorRateById($id);
		$scon=(new Subcontractor())->getSubcontractors();
		$proj=(new Project())->getProjects();
		$scitems=(new SubcontractorItem())->getSubcontractorItems();
		$item_unit=$this->get_subcontractor_item_unit_name($sr->subcontractor_item_id);
		return view('admin.subcontractor_rate.edit_subcontractor_rate',compact('sr','scon','proj','scitems','item_unit'));
	}
		
	 public function update_subcontractor_rate(Request $request)
	 {

		$validate=Validator::make($request->all(),SubcontractorRate::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SubcontractorRate())->updateSubcontractorRate($request);

			if($result)
			{
				Session::flash('message', 'success#SubcontractorRate successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('sub-contractor-rates');
	}
	
	
   public function destroy($id)
	{

		$result=(new SubcontractorRate())->deleteSubcontractorRate($id);
		
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
            $data = (new SubcontractorRate())->viewSubcontractorRates($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','cperson','status'])
                    ->make(true);
        }
		
	}
	
	
	public function get_items_by_subcontractor_id($id)
	{
		$items=SubcontractorItem::where('subcontractor_id',$id)->get();
		$opt="<option value=''>--select--</option>";
		foreach($items as $r)
		{
			$opt.="<option value='".$r->id."'>".$r->item_name."</option>";
		}
		
		return $opt;
	}
	
	public function get_subcontractor_item_unit_name($id)
	{
		$items=SubcontractorItem::select('material_units.unit_name')
		->leftJoin('material_units','subcontractor_items.material_unit_id','=','material_units.id')
		->where('subcontractor_items.id',$id)->first();
		
		$item_unit="";
		if(!empty($items))
		{
			$item_unit=$items->unit_name;
		}
		return $item_unit;
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

		$result=SubcontractorRate::where('id',$id)->update($new);

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
	
	
}
