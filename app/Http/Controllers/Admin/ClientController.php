<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Client;

use Validator;
use DataTables;
use Session;


class ClientController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
    return view('admin.client.client');
  }	
  
   public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Client::RULES);

		if($validate->fails())
		{
			Session::flash('message', 'danger#Invalid datas/GST duplicate not allowed, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Client())->addClient($request);

			if($result)
			{
				Session::flash('message', 'success#Client successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('clients');
	}
	
	public function edit($id)
	{
		$cl=(new Client())->getClientById($id);
		return view('admin.client.edit_client',compact('cl'));
	}
	
	
	 public function update_client(Request $request)
	 {

		$validate=Validator::make($request->all(),Client::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Client())->updateClient($request);

			if($result)
			{
				Session::flash('message', 'success#Client successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('clients');
	}
	
	
   public function destroy($id)
	{

		$result=(new Client())->deleteClient($id);
		
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
            $data = (new Client())->viewClients($request);

            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','cperson','status'])
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

		$result=Client::where('id',$id)->update($new);

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
