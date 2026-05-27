<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Company;
use App\Models\Client;
use App\Models\ProjectType;

use Validator;
use DataTables;
use Session;


class ProjectController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $comp=(new Company())->getCompany();
	 $client=(new Client())->getClients();
	 $ptype=(new ProjectType())->getProjectTypes();
     return view('admin.projects.project',compact('comp','client','ptype'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Project::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Project())->addProject($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Project successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('projects');
	}
	
	public function edit($id)
	{
		$pr=(new Project())->getProjectById($id);
		$company=(new Company())->getCompany();
		$client=(new Client())->getClients();
		$ptype=(new ProjectType())->getProjectTypes();
		return view('admin.projects.edit_project',compact('pr','company','client','ptype'));
	}
		
	 public function update_Project(Request $request)
	 {

		$validate=Validator::make($request->all(),Project::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Project())->updateProject($request);

			if($result)
			{
				Session::flash('message', 'success#Project successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('projects');
	}
	
	
   public function destroy($id)
	{

		$result=(new Project())->deleteProject($id);
		
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
            $data = (new Project())->viewProjects($request);

            return DataTables::of($data)
              ->addIndexColumn()
			  ->rawColumns(['action','sdate','status','pstatus'])
              ->make(true);
        }
	}
		
	public function change_project_status($id,$op)
	{

		$new1=['project_status'=>$op,'status'=>1];
		$new2=['project_status'=>$op,'status'=>0];

		if($op==2)
			$result=Project::where('id',$id)->update($new2);	
		else
			$result=Project::where('id',$id)->update($new1);	

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

		$result=Project::where('id',$id)->update($new);

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
