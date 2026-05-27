<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\AssetCategory;
use App\Models\AssetSubCategory;

use Validator;
use DataTables;
use Session;


class AssetSubCategoryController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $cats=(new AssetCategory())->getAssetCategories();
    return view('admin.assets.asset_sub_category',compact('cats'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),AssetSubCategory::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new AssetSubCategory())->addAssetSubCategory($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Category successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-sub-category');
	}
	
	public function edit($id)
	{
		$cats=(new AssetCategory())->getAssetCategories();
		$sc=(new AssetSubCategory())->getAssetSubCategoryById($id);
		return view('admin.assets.edit_asset_sub_category',compact('cats','sc'));
	}
	
	
	 public function update_asset_sub_category(Request $request)
	 {

		$validate=Validator::make($request->all(),AssetSubCategory::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new AssetSubCategory())->updateAssetSubCategory($request);

			if($result)
			{
				Session::flash('message', 'success#Category successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-sub-category');
	}
	
	
   public function destroy($id)
	{

		$result=(new AssetSubCategory())->deleteAssetSubCategory($id);
		
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
            $data = (new AssetSubCategory())->viewAssetSubCategories($request);

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

		$result=AssetSubCategory::where('id',$id)->update($new);

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
