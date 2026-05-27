<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Supplier;

use Validator;
use DataTables;
use Session;


class SupplierController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 return view('admin.supplier.supplier');
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Supplier::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Invalid datas/GST duplicate not allowed, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Supplier())->addSupplier($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Supplier detail successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('suppliers');
	}
	
	public function edit($id)
	{
		$sp=(new Supplier())->getSupplierById($id);
		return view('admin.supplier.edit_supplier',compact('sp'));
	}
	
	
	 public function update_supplier(Request $request)
	 {

		$validate=Validator::make($request->all(),Supplier::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Supplier())->updateSupplier($request);

			if($result)
			{
				Session::flash('message', 'success#Supplier detail successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('suppliers');
	}
	
	
   public function destroy($id)
	{

		$result=(new Supplier())->deleteSupplier($id);
		
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
            $data = (new Supplier())->viewSuppliers($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','bank','cperson','status'])
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

		$result=Supplier::where('id',$id)->update($new);

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
