<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MainCostItem;
use App\Models\Staff;

use Validator;
use DataTables;
use Session;


class MainCostItemController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  return view('admin.main_cost_items.main_cost_items');
  }	
  
  
  public function store(Request $request)
	{

		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),MainCostItem::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}


		   $result=(new MainCostItem())->addMainCostItem($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Cost item successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('main-cost-items');
	}
	
	public function edit($id)
	{
		$stfs=(new Staff())->getStaffs();
		$sb=(new MainCostItem())->getMainCostItemById($id);
		return view('admin.staffs.edit_staff_bonus',compact('stfs','sb'));
	}
	
	
	public function update_cost_item(Request $request)
	 {

		$validate=Validator::make($request->all(),MainCostItem::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MainCostItem())->updateMainCostItem($request);

			if($result)
			{
				Session::flash('message', 'success#cost item successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('main-cost-items');
	}
	
	
   public function destroy($id)
	{

		$result=(new MainCostItem())->deleteMainCostItem($id);
		
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
            $data = (new MainCostItem())->viewMainCostItems($request);

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

		$result=MainCostItem::where('id',$id)->update($new);

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
