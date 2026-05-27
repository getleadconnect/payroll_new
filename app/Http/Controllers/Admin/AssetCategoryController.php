<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\AssetCategory;

use Validator;
use DataTables;
use Session;


class AssetCategoryController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.assets.asset_category');
  }	
  
   public function store(Request $request)
	{
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];
		$validate=Validator::make($request->all(),AssetCategory::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new AssetCategory())->addAssetCategory($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Category successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-category');
	}
	
	
	public function edit($id)
	{
		$ac=(new AssetCategory())->getAssetCategoryById($id);
		return view('admin.assets.edit_asset_category',compact('ac'));
	}
	
	
	 public function update_asset_category(Request $request)
	 {

		$validate=Validator::make($request->all(),AssetCategory::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new AssetCategory())->updateAssetCategory($request);

			if($result)
			{
				Session::flash('message', 'success#Category successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('asset-category');
	}
	
	
   public function destroy($id)
	{
		
		$result=(new AssetCategory())->deleteAssetCategory($id);
		
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
            $data = (new AssetCategory())->viewAssetCategories($request);

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

		$result=AssetCategory::where('id',$id)->update($new);

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
