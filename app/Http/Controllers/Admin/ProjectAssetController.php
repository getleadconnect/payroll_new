<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Company;
use App\Models\AssetItem;
use App\Models\ProjectAsset;

use Validator;
use DataTables;
use Session;


class ProjectAssetController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
     $pros=(new Project())->getProjects();
	 return view('admin.project_assets.project_assets',compact('pros'));
  }	
  
   public function store(Request $request)
	{
		//--- code here -----------------------
		
	}
	
	public function edit($id)
	{
		$pa=(new ProjectAsset())->getProjectAssetItemById($id);
		$comp=(new Company())->getCompany();
		$pros=(new Project())->getProjectsByCompanyId($pa->company_id);
		$aitem=AssetItem::where('id',$pa->asset_item_id)->first();
		
		return view('admin.project_assets.edit_project_asset_item',compact('pa','comp','pros','aitem'));
	}
	
	
	public function update_project_asset(Request $request)
	{
		
		$validate=Validator::make($request->all(),ProjectAsset::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new ProjectAsset())->updateProjectAssetItem($request);

			if($result)
			{
				Session::flash('message', 'success#Project asset successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('project-assets');
	}
	
	
   public function destroy($id)
	{

		$result=(new ProjectAsset())->deleteProjectAssetItem($id);
		
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
            $data = (new ProjectAsset())->viewProjectAssets($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
		
	}
	
	public function return_project_asset_item($id)
	{
		$pa=(new ProjectAsset())->getProjectAssetItemById($id);
		$aitem=AssetItem::where('id',$pa->asset_item_id)->first();
		return view('admin.project_assets.return_project_asset_item',compact('pa','aitem'));
	}
	
	
	public function update_return_project_asset(Request $request)
	{
		
		if($request->ret_quantity<=$request->current_qty)
		{
			$result=(new ProjectAsset())->updateReturnProjectAssetItem($request);

				if($result)
				{
					Session::flash('message', 'success#Project asset successfully updated.');
				}
				else
				{
					Session::flash('message', 'danger#Details missing, try again.');
				}				
		}
		else
		{
			Session::flash('message', 'danger#Return quantity invalid, try again.');
		}
		
	   return redirect('project-assets');
	
	}
	
	
}
