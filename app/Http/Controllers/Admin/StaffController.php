<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\StaffRole;

use Validator;
use DataTables;
use Session;


class StaffController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 return view('admin.staffs.staff');
  }	
  
  public function add_staff()
  {
	 $roles=(new StaffRole())->getStaffRoles();
	 return view('admin.staffs.add_staff',compact('roles'));
  }	
  
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Staff::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Staff())->addStaff($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Staff detail successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				return back()->withInput();
			}				

			return redirect('add-staffs');
	}
	
	public function edit($id)
	{
		$st=(new Staff())->getStaffById($id);
		$roles=(new StaffRole())->getStaffRoles();
		return view('admin.staffs.edit_staff',compact('st','roles'));
	}
	
	
	 public function update_staff(Request $request)
	 {

		$validate=Validator::make($request->all(),Staff::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Staff())->updateStaff($request);

			if($result)
			{
				Session::flash('message', 'success#Staff detail successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staffs');
	}
	
	
   public function destroy($id)
	{

		$result=(new Staff())->deleteStaff($id);
		
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
            $data = (new Staff())->viewStaffs($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','bank','mob','esic','state','aadhar','status'])
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

		$result=Staff::where('id',$id)->update($new);

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
	
	
	public function get_staff_details($id)
	{
		$st=(new Staff())->getStaffById($id);
		return view('admin.staffs.staff_details',compact('st'));
	}
	
	
	
}
