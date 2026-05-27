<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\PaymentType;

use Validator;
use DataTables;
use Session;


class PaymentTypeController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.payment_type.payment_type');
  }	
  
   public function store(Request $request)
	{

		$messages = [
			'required' => 'The :attribute field is required.',
			'unique' => 'The :attribute, duplicate data not allowed.',
		];

		$validate=Validator::make($request->all(),PaymentType::RULES,$messages);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Duplicate/Invalid data, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new PaymentType())->addPaymentType($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Project type successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('payment-types');
	}
	
	public function edit($id)
	{
		
	}
	
	
	 public function update_payment_type(Request $request)
	 {

		$validate=Validator::make($request->all(),PaymentType::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new PaymentType())->updatePaymentType($request);

			if($result)
			{
				Session::flash('message', 'success#Payment type successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('payment-types');
	}
	
	
   public function destroy($id)
	{

		$result=(new PaymentType())->deletePaymentType($id);
		
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
            $data = (new PaymentType())->viewPaymentTypes($request);

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

		$result=PaymentType::where('id',$id)->update($new);

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
