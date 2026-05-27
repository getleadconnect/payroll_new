<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\StaffRole;
use App\Models\Staff;

use Validator;
use DataTables;
use Session;


class AdminUserController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$stroles=StaffRole::orderBy('id','ASC')->get();
	$staffs=Staff::orderBy('id','ASC')->get();
    return view('admin.admin_users.admin_users',compact('staffs','stroles'));
  }	
  
   public function store(Request $request)
	{
		
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),Admin::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate Email/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

			$ausr=Admin::where('staff_id',$request->staff_id)->count();
			if($ausr>0)
			{
				Session::flash('message', 'danger#User already exists.');
				return redirect()->back();
			}

		   $result=(new Admin())->addAdminUser($request);
		   
			if($result)
			{
				Session::flash('message', 'success#User successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('admin-users');
	}
	
	public function edit($id)
	{
		$au=(new Admin())->getAdminById($id);
		$roles=(new StaffRole())->getStaffRoles();
		return view('admin.admin_users.edit_admin_user',compact('au','roles'));
	}
	
	
	public function update_admin_user(Request $request)
	 {

		$validate=Validator::make($request->all(),Admin::EDIT_RULES);

		if($validate->fails())
		{
			Session::flash('message', 'danger#Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
			$ed=Admin::where('email',$request->ed_email)->first();
			if(!empty($ed))
			{
				if($ed->id!=$request->ed_admin_id)
				{
					Session::flash('message', 'danger#Duplicate Email/Invalid data, try again2.');
					return back()->withErrors($validate)->withInput();
				}
			}

		$result=(new Admin())->updateAdminUser($request);

			if($result)
			{
				Session::flash('message', 'success#Admin user successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('admin-users');
	}
	
	
   public function destroy($id)
	{

		$result=(new Admin())->deleteAdminUser($id);
		
			if($result)
			{
				Session::flash('message', 'success#Admin user successfully deleted.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('admin-users');
	}
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new Admin())->viewAdminUsers($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','cperson','status'])
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

		$result=Admin::where('id',$id)->update($new);

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
	
	
	public function get_staff($id)
	{
		$sdt=Staff::where('id',$id)->first();
		return $sdt;
	}
	
	public function update_admin_password(Request $request)
	 {

		$validate=Validator::make($request->all(),Admin::PASS_RULES);

		if($validate->fails())
		{
			Session::flash('message', 'danger#Password not maching/missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
			
			$result='';
			if($request->has('admin_user_id') and $request->filled('new_password'))
			{
			
			$id=$request->admin_user_id;
			$dat=['password'=>Hash::make($request->new_password)];
			}

			$result=Admin::where('id',$id)->update($dat);

			if($result)
			{
			   //Session::flash('message', 'success#Admin user password updated.');
			   $res=1;
			}
			else
			{
			   Session::flash('message', 'danger#Details missing, try again.');
			   $res=0;
			}				

			return $res;
	}
	
	
}
