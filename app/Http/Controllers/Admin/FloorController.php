<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\FloorNo;

use Validator;
use DataTables;
use Session;


class FloorController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  return view('admin.floors.floor_nos');
  }	
  
  
  public function store(Request $request)
	{

		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),FloorNo::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invlaid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new FloorNo())->addFloorNo($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Floor no successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('floors');
	}
	
	public function edit($id)
	{
		//-----code here -----
	}
	
	
	public function update_floor_no(Request $request)
	 {

		$validate=Validator::make($request->all(),FloorNo::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new FloorNo())->updateFloorNo($request);

			if($result)
			{
				Session::flash('message', 'success#Floor no successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('floors');
	}
	
	
   public function destroy($id)
	{

		$result=(new FloorNo())->deleteFloorNo($id);
		
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
            $data = (new FloorNo())->viewFloorNos($request);

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

		$result=FloorNo::where('id',$id)->update($new);

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
