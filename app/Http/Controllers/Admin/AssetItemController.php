<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Company;
use App\Models\Client;
use App\Models\AssetCategory;
use App\Models\AssetItem;
use App\Models\ProjectAsset;

use Validator;
use DataTables;
use Session;


class AssetItemController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $comp=(new Company())->getCompany();
	 $pros=(new Project())->getProjects();
	 $cats=(new AssetCategory())->getAssetCategories();
     return view('admin.assets.asset_items',compact('comp','pros','cats'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),AssetItem::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new AssetItem())->addAssetItem($request);
		   
			if($result)
			{
				Session::flash('message', 'success#item successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-items');
	}
	
	public function edit($id)
	{
		$ai=(new AssetItem())->getAssetItemById($id);
		$comp=(new Company())->getCompany();
		$cats=(new AssetCategory())->getAssetCategories();
		$pros=(new Project())->getProjectsByCompanyId($ai->company_id);
		return view('admin.assets.edit_asset_item',compact('ai','comp','pros','cats'));
	}
	

	 public function update_asset_item(Request $request)
	 {

		$validate=Validator::make($request->all(),AssetItem::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new AssetItem())->updateAssetItem($request);

			if($result)
			{
				Session::flash('message', 'success#AssetItem successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-items');
	}
	
	
   public function destroy($id)
	{

		$result=(new AssetItem())->deleteAssetItem($id);
		
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
            $data = (new AssetItem())->viewAssetItems($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
	}

	
	public function view_asset_data(Request $request) //assign project items
	{

		if ($request->ajax()) {
            $data = (new AssetItem())->viewAssetItemsForProjects($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
		
	}
		
	public function change_AssetItem_status($id,$op)
	{
		$new=['AssetItem_status'=>$op];
		$result=AssetItem::where('id',$id)->update($new);
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

		$result=AssetItem::where('id',$id)->update($new);

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
	
	public function get_projects_by_company_id($id)
	{
		$pros=Project::where('company_id',$id)->get();
		$opt="<option value=''>--select--</option>";
		foreach($pros as $r)
		{
			$opt.="<option value='".$r->id."'>".$r->project_name."</option>";
		}
		return $opt;
	}
	
//-------------------------------------------------------------------------
	
	public function assign_project_assets()
	{
		$comp=(new Company())->getCompany();
		$cats=(new AssetCategory())->getAssetCategories();
		return view('admin.assets.assign_project_assets',compact('comp','cats'));
	}

	public function assign_asset_item($id)
	{
		$ai=(new AssetItem())->getAssetItemById($id);
		$pros=(new Project())->getprojects();
		return view('admin.assets.assign_asset_item',compact('ai','pros'));
	}
	
	public function save_item_to_project(Request $request)
	{

		$validate=Validator::make($request->all(),ProjectAsset::ASSIGN_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new ProjectAsset())->addProjectAssetItem($request);
		   
			if($result)
			{
				/*$avqty=$request->ass_available_quantity-$request->ass_quantity;
				$dat=['available_quantity'=>$avqty];
				
				$res=AssetItem::where('id',$request->ass_item_id)->update($dat);*/
				
				Session::flash('message', 'success#item successfully assigned.');
			}
			else
			{
				Session::flash('message', 'danger#Quantity Insuffient, try again.');
			}				

			return redirect('assign-project-assets');
	}
	
	
	
	
}
