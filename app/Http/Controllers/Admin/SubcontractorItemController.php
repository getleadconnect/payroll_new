<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MaterialUnit;
use App\Models\Subcontractor;
use App\Models\SubcontractorItem;
use App\Models\MainCostItem;

use Validator;
use DataTables;
use Session;


class SubcontractorItemController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$units=(new MaterialUnit())->getMaterialUnits();
	$scon=(new Subcontractor())->getSubcontractors();
	$mitems=(new MainCostItem())->getMainCostItems();
    return view('admin.subcontractor_items.sub_contractor_items',compact('units','scon','mitems'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SubcontractorItem::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		

		$where1=['item_name'=>$request->item_name,'material_unit_id'=>$request->unit_id];
		$res=SubcontractorItem::where($where1)->count();
		if($res>0)
		{
			Session::flash('message', 'danger#Duplicate data not allowed, Try again.');
			return redirect()->back();
		}


		   $result=(new SubcontractorItem())->addSubcontractorItem($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Item details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('sub-contractor-items');
	}
	
	public function edit($id)
	{
		 $units=(new MaterialUnit())->getMaterialUnits();
		 $sc=(new SubcontractorItem())->getSubcontractorItemById($id);
		 $mitems=(new MainCostItem())->getMainCostItems();
		 return view('admin.subcontractor_items.edit_sub_contractor_item',compact('units','sc','mitems'));
	}
	
	
	 public function update_subcontractor_item(Request $request)
	 {

		$validate=Validator::make($request->all(),SubcontractorItem::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SubcontractorItem())->updateSubcontractorItem($request);

			if($result)
			{
				Session::flash('message', 'success#Item successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('sub-contractor-items');
	}
	
	
   public function destroy($id)
	{

		$result=(new SubcontractorItem())->deleteSubcontractorItem($id);
		
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
            $data = (new SubcontractorItem())->viewSubcontractorItems($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
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

		$result=SubcontractorItem::where('id',$id)->update($new);

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
