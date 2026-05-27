<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MaterialGst;
use App\Models\MaterialType;

use Validator;
use DataTables;
use Session;


class MaterialGstController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$mtypes=(new MaterialType())->getMaterialTypes();
    return view('admin.material_gst.material_gst',compact('mtypes'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),MaterialGst::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MaterialGst())->addMaterialGst($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material gst successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-gst');
	}
	
	public function edit($id)
	{
		$mg=(new MaterialGst())->getMaterialGstById($id);
		$mtypes=(new MaterialType())->getMaterialTypes();
		return view('admin.material_gst.edit_material_gst',compact('mg','mtypes'));
	}
	
	 public function update_material_gst(Request $request)
	 {

		$validate=Validator::make($request->all(),MaterialGst::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MaterialGst())->updateMaterialGst($request);

			if($result)
			{
				Session::flash('message', 'success#Material gst successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('material-gst');
	}
	
	
   public function destroy($id)
	{

		$result=(new MaterialGst())->deleteMaterialGst($id);
		
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
            $data = (new MaterialGst())->viewMaterialGst($request);

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

		$result=MaterialGst::where('id',$id)->update($new);

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
