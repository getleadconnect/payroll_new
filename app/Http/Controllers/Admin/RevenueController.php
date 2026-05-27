<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Staff;
use App\Models\ProjectStaff;
use App\Models\Revenue;

use Validator;
use DataTables;
use Session;

class RevenueController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $projs=(new Project())->getProjects();
	 $staff=(new Staff())->getStaffs();
	 return view('admin.revenue.revenue',compact('projs','staff'));
  }	
  
   	
	public function store(Request $request)
	{
		
		$validate=Validator::make($request->all(),Revenue::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing11, try again.');
			return back()->withErrors($validate)->withInput();
		}


		   $result=(new Revenue())->addRevenue($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Revenue successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('revenues');
			
	}

	
	
	public function edit($id)
	{
		
		$rv=(new Revenue())->getRevenueById($id);
		$projs=(new Project())->getProjects();
		$stf=(new ProjectStaff())->getProjectStaffByProjectId($rv->project_id);
		return view('admin.revenue.edit_revenue',compact('projs','rv','stf'));
	}
		
	 public function update_revenue(Request $request)
	 {

		$validate=Validator::make($request->all(),Revenue::EDIT_RULES);
			
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

        $result=(new Revenue())->updateRevenue($request);

			if($result)
			{
				Session::flash('message', 'success#Revenue successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('revenues');
	}
	
    public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new Revenue())->viewRevenues($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action'])
                    ->make(true);
        }
		
	}
	
   public function destroy($id)
	{

		$result=(new Revenue())->deleteRevenue($id);
		
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
