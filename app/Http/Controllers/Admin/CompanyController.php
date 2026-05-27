<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Company;

use Validator;
use DataTables;
use Session;
use Auth;


class CompanyController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  /*public function index()
  {
	 $cm=(new Company())->getCompany();
    return view('admin.company.company',compact('cm'));
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Company::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Company())->addCompany($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Company successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('company');
	}
	*/
	
	public function edit($id)
	{
		$cm=(new Company())->getCompanyById($id);
		return view('admin.company.edit_company',compact('cm'));
	}
	
	
	 public function update_company(Request $request)
	 {

		$validate=Validator::make($request->all(),Company::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Company())->updateCompany($request);

			if($result)
			{
				Session::flash('message', 'success#Company successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('dashboard');
	}
	
	
  /* public function destroy($id)
	{

		$result=(new Company())->deleteCompany($id);
		
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
            $data = (new Company())->viewCompany($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status'])
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

		$result=Company::where('id',$id)->update($new);

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
	*/
	
}
