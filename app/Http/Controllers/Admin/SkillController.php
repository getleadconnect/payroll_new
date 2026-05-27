<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\SkillType;

use Validator;
use DataTables;
use Session;


class SkillController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	  return view('admin.skill_type.skill_type');
  }	
  
  
  public function store(Request $request)
	{

	$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];
		
		$validate=Validator::make($request->all(),SkillType::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new SkillType())->addSkillType($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Skill type successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('skill-types');
	}
	
	public function edit($id)
	{
		$cl=(new SkillType())->getSkillTypeById($id);
		return view('admin.skill_type.edit_skill_type',compact('cl'));
	}
	
	
	public function update_skill_type(Request $request)
	 {

		$validate=Validator::make($request->all(),SkillType::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SkillType())->updateSkillType($request);

			if($result)
			{
				Session::flash('message', 'success#Skill type successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('skill-types');
	}
	
	
   public function destroy($id)
	{

		$result=(new SkillType())->deleteSkillType($id);
		
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
            $data = (new SkillType())->viewSkillTypes($request);

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

		$result=SkillType::where('id',$id)->update($new);

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
