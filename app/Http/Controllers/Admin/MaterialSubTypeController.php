<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MaterialType;
use App\Models\MaterialSubType;

use Validator;
use DataTables;
use Session;


class MaterialSubTypeController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  $mtypes=(new MaterialType())->getMaterialTypes();
    return view('admin.material_sub_type.material_sub_type',compact('mtypes'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MaterialSubType::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		$where1=['material_type_id'=>$request->material_type_id,'sub_type_name'=>$request->sub_type_name];
		$res=MaterialSubType::where($where1)->count();
		if($res>0)
		{
			Session::flash('message', 'danger#Material sub-type already added.');
			return back()->withInput();
		}

		   $result=(new MaterialSubType())->addMaterialSubType($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material sub-type successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-sub-types');
	}
	
	public function edit($id)
	{
		 $mtypes=(new MaterialType())->getMaterialTypes();
		 $mst=(new MaterialSubType())->getMaterialSubTypeById($id);
		 return view('admin.material_sub_type.edit_material_sub_type',compact('mtypes','mst'));
	}
	
	
	 public function update_material_sub_type(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialSubType::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialSubType())->updateMaterialSubType($request);

			if($result)
			{
				Session::flash('message', 'success#Material sub-type successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-sub-types');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialSubType())->deleteMaterialSubType($id);
		
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
            $data = (new MaterialSubType())->viewMaterialSubTypes($request);

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

		$result=MaterialSubType::where('id',$id)->update($new);

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
