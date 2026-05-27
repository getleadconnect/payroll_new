<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\MiscCategory;

use Validator;
use DataTables;
use Session;


class MiscCategoryController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.misc_items.misc_category');
  }	
  
   public function store(Request $request)
	{
		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),MiscCategory::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new MiscCategory())->addMiscCategory($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Category successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('misc-category');
	}
	
	public function edit()
	{
		
	}
	
	
	 public function update_misc_category(Request $request)
	 {

		$validate=Validator::make($request->all(),MiscCategory::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new MiscCategory())->updateMiscCategory($request);

			if($result)
			{
				Session::flash('message', 'success#Category successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('misc-category');
	}
	
	
   public function destroy($id)
	{

		$result=(new MiscCategory())->deleteMiscCategory($id);
		
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
            $data = (new MiscCategory())->viewMiscCategory($request);

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

		$result=MiscCategory::where('id',$id)->update($new);

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
