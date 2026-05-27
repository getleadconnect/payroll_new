<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MaterialUnit;

use Validator;
use DataTables;
use Session;


class MaterialUnitController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.material_unit.material_unit');
  }	
  
   public function store(Request $request)
	{
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),MaterialUnit::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MaterialUnit())->addMaterialUnit($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material unit successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-units');
	}
	
	public function edit()
	{
		
	}
	
	
	 public function update_material_unit(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialUnit::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialUnit())->updateMaterialUnit($request);

			if($result)
			{
				Session::flash('message', 'success#Material unit successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-units');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialUnit())->deleteMaterialUnit($id);
		
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
            $data = (new MaterialUnit())->viewMaterialUnits($request);

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

		$result=MaterialUnit::where('id',$id)->update($new);

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
