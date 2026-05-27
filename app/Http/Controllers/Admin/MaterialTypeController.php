<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MaterialType;

use Validator;
use DataTables;
use Session;


class MaterialTypeController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.material_type.material_type');
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MaterialType::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}


		$where1=['material_type_name'=>$request->material_type_name,'hsn_no'=>$request->hsn_no];
		$res=MaterialType::where($where1)->count();
		if($res>0)
		{
			Session::flash('message', 'danger#Material type already added.');
			return back()->withInput();
		}

		   $result=(new MaterialType())->addMaterialType($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material type successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-types');
	}
	
	public function edit()
	{
		
	}
	
	
	 public function update_material_type(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialType::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialType())->updateMaterialType($request);

			if($result)
			{
				Session::flash('message', 'success#Material type successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-types');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialType())->deleteMaterialType($id);
		
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
            $data = (new MaterialType())->viewMaterialTypes($request);

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

		$result=MaterialType::where('id',$id)->update($new);

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
