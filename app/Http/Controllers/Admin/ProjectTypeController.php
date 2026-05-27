<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\ProjectType;

use Validator;
use DataTables;
use Session;


class ProjectTypeController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.project_type.project_type');
  }	
  
   public function store(Request $request)
	{

		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),ProjectType::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new ProjectType())->addProjectType($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Project type successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('project-types');
	}
	
	public function edit($id)
	{
		$cl=(new ProjectType())->getProjectTypeById($id);
		return view('admin.project_type.edit_project_type',compact('cl'));
	}
	
	
	 public function update_project_type(Request $request)
	 {

		$validate=Validator::make($request->all(),ProjectType::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new ProjectType())->updateProjectType($request);

			if($result)
			{
				Session::flash('message', 'success#Project type successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('project-types');
	}
	
	
   public function destroy($id)
	{
		
		$result=(new ProjectType())->deleteProjectType($id);
		
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
            $data = (new ProjectType())->viewProjectTypes($request);

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

		$result=ProjectType::where('id',$id)->update($new);

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
