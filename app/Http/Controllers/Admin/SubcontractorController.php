<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Subcontractor;

use Validator;
use DataTables;
use Session;


class SubcontractorController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 return view('admin.subcontractors.subcontractor');
  }	
  
  
  public function add_subcontractor()
  {
	 return view('admin.subcontractors.add_subcontractor');
  }	
  
   public function store(Request $request)
	{
		/*$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];*/

		$validate=Validator::make($request->all(),Subcontractor::RULES);
		
		if($validate->fails())
		{
				if($validate->errors()->has('gst_no'))  //unique data check
				{
				   Session::flash('message', 'danger#'.$validate->errors()->first('gst_no'));	
				}
				else if($validate->errors()->has('pan_no'))
				{
					Session::flash('message', 'danger#'.$validate->errors()->first('pan_no'));	
				}
				else
				{
					Session::flash('message', 'danger#Details missing, try again.');
				}
			
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Subcontractor())->addSubcontractor($request);
	
		    
			
			if($result)
			{
				Session::flash('message', 'success#Subcontractor detail successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('add-sub-contractors');
	}
	
	public function edit($id)
	{
		$sp=(new Subcontractor())->getSubcontractorById($id);
		return view('admin.subcontractors.edit_subcontractor',compact('sp'));
	}
		
	 public function update_subcontractor(Request $request)
	 {

		$validate=Validator::make($request->all(),Subcontractor::EDIT_RULES);
				
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Subcontractor())->updateSubcontractor($request);
			
			if($result)
			{
				Session::flash('message', 'success#Subcontractor detail successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details/GST/PAN duplicate not allowed, try again.');
			}				

			return redirect('sub-contractors');
	}
	
	
   public function destroy($id)
	{

		$result=(new Subcontractor())->deleteSubcontractor($id);
		
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
            $data = (new Subcontractor())->viewSubcontractors($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','bank','cperson','gst','status'])
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

		$result=Subcontractor::where('id',$id)->update($new);

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
