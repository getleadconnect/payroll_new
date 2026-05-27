<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Labour;
use App\Models\LabourType;
use App\Models\SkillType;

use Validator;
use DataTables;
use Session;
//use MessageBag;


class LabourController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $state=(new Labour())->getStates();
     return view('admin.labours.labour',compact('state'));
  }	
  
  public function add_labour()
  {
	 $skill=(new SkillType())->getSkillTypes();
	 return view('admin.labours.add_labour',compact('skill'));
  }	

  
  public function store(Request $request)
	{
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];
		
		$validate=Validator::make($request->all(),Labour::RULES,$messages);
		
			if($validate->fails())
			{
				Session::flash('message', 'danger#Details missing/Code and Aadhar no duplicate not allowed, try again.');
				return back()->withErrors($validate)->withInput();
			}

		   $result=(new Labour())->addLabour($request);
		   
		   if($result)
			{
				Session::flash('message', 'success#Labour successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}

		return redirect('add-labour');
		
	}
	
	public function edit($id)
	{
		$lbr=(new Labour())->getLabourById($id);
		$skill=(new SkillType())->getSkillTypes();
		return view('admin.labours.edit_labour',compact('lbr','skill'));
	}
	
	
	 public function update_labour(Request $request)
	 {

		$validate=Validator::make($request->all(),Labour::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($msg)->withInput();
		}
		
		$result=(new Labour())->updateLabour($request);

		if($result==1062)  //to check unique data (aadhar no/Code)
		{
			$validate->getMessageBag()->add('aadhar_no','The Aadhar No, duplicate data not allowed.');
			Session::flash('message', 'danger#Duplicate Data not Allowed (CODE & AADHAR NO).');
			return back()->withErrors($validate)->withInput();
		}
		elseif($result)
		{
			Session::flash('message', 'success#Labour successfully updated.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}				

		return redirect('labours');
	}
	
	
   public function destroy($id)
	{

		$result=(new Labour())->deleteLabour($id);
		
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
            $data = (new Labour())->viewLabours($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','sdate','status'])
                    ->make(true);
        }
		
	}
	
	public function get_districts($state)
	{
            $data = (new Labour())->getDistricts($state);
			$opt="<option value=''>select</option>";
			if($data)
				{
				foreach($data  as $row)
				{
					$opt.="<option value='".$row->district."'>".$row->district."</option>";
				}
				}
		return $opt;
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

		$result=Labour::where('id',$id)->update($new);

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
