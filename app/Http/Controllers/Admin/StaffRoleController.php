<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\StaffRole;
use App\Models\Role;

use Validator;
use DataTables;
use Session;


class StaffRoleController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  $role=Role::orderBy('id','ASC')->get();
	  return view('admin.staffs.staff_role',compact('role'));
  }	
  
  
  public function store(Request $request)
	{
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];
		
		$validate=Validator::make($request->all(),StaffRole::RULES,$messages);
	
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new StaffRole())->addStaffRole($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Role successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staff-roles');
	}
	
	public function edit($id)
	{
		$sr=(new StaffRole())->getStaffRoleById($id);
		$role=Role::orderBy('id','ASC')->get();
	    return view('admin.staffs.edit_staff_role',compact('role','sr'));
	}
	
	
	public function update_staff_role(Request $request)
	 {

		$validate=Validator::make($request->all(),StaffRole::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new StaffRole())->updateStaffRole($request);

			if($result)
			{
				Session::flash('message', 'success#Role successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staff-roles');
	}
	
	
   public function destroy($id)
	{

		$result=(new StaffRole())->deleteStaffRole($id);
		
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
            $data = (new StaffRole())->viewStaffRoles($request);

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

		$result=StaffRole::where('id',$id)->update($new);

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
