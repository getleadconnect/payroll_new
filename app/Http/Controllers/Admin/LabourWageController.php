<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Labour;
use App\Models\LabourType;
use App\Models\SkillType;
use App\Models\LabourWage;

use Validator;
use DataTables;
use Session;
//use MessageBag;


class LabourWageController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	$skill=(new SkillType())->getSkillTypes();
	return view('admin.labours.labour_wages',compact('skill'));
  }	
  
  
   public function store(Request $request)
	{
		
		$validate=Validator::make($request->all(),LabourWage::RULES);
		
		  if($validate->fails())
		  {
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		  }

			$lwcnt=labourWage::where('labour_id',$request->labour_id)->count();
			if($lwcnt>0)
			{
				Session::flash('message', 'danger#Labour wages already added.');
				return back();  
			}

		   $result=(new LabourWage())->addLabourWage($request);
		   
		   if($result)
			{
				Session::flash('message', 'success#Labour wages successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}
		
		 $purl=explode("/",url()->previous());
		 if($purl[count($purl)-1]=='assign-labours')
		 {
			 return redirect('assign-labours');
		 }
		 else
		 {
		    return redirect('labour-wages');
		 }
		
	}
	
	
	public function set_labour_wage($id) //to set labour wage
	{
		$lbr=(new Labour())->getLabourById($id);
		return view('admin.labours.set_labour_wage',compact('lbr'));
	} 
	
	public function edit($id) 
	{
		$lw=(new LabourWage())->getLabourWageById($id);
		return view('admin.labours.edit_labour_wage',compact('lw'));
	}
	
	public function update_labour_wage(Request $request)
	 {

		$validate=Validator::make($request->all(),LabourWage::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new LabourWage())->updateLabourWage($request);

		if($result)
		{
			Session::flash('message', 'success#Labour successfully updated.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}				

		return redirect('labour-wages');
	}
	
	
    public function destroy($id)
	{

		$result=(new LabourWage())->deleteLabourWage($id);
		
		  if($result)
		  {
			Session::flash('message', 'success#Labour wage successfully removed.');
		  }
		  else
		  {
			Session::flash('message', 'danger#Something wrong, try again.');
		  }	
		  return redirect('labour-wages');
	}
	
	
   /*public function view_labour_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LabourWage())->viewLabours($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action',])
                    ->make(true);
        }
		
	}*/
	
	
	public function view_labour_data($skill_id)
	{
			$dts=Labour::query();
			if($skill_id!="")
			{
				$dts->select('labours.id','labours.code','labours.name','skill_types.skill_type')
				->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id')
				->where('skill_type_id',$skill_id);
			}
			else
			{
				$dts->select('labours.id','labours.code','labours.name','skill_types.skill_type')
				->leftJoin('skill_types','labours.skill_type_id','=','skill_types.id');
				
			}
			
			$data=$dts->where('wage_status','0')->orderBy('labours.id','ASC')->get();	

			$opt="<option value=''>--select--</option>";
			if(!$data->isEmpty())
			{
				foreach($data as $r)
				{
					$opt.="<option value='".$r->id."'>".$r->name."</option>";
				}
			}
			
			return $opt;
		
	}
	
	
	public function view_labour_wages(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LabourWage())->viewLabourWages($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action',])
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
