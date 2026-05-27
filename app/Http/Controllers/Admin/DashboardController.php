<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Labour;
use App\Models\Project;
use App\Models\Staff;
use App\Models\Client;
use App\Models\Subcontractor;
use App\Models\Supplier;
use App\Models\Revenue;

use Session;
use Validator;
use DataTables;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  use AuthenticatesUsers;
  
  protected $guard = 'admin';
    
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
	{
		$cm = (new Company())->getCompany();

		$lbr_count        		 = Labour::count();
		$prj_count		         = Project::count();
		$stf_count        		 = Staff::count();
		$client_count     		 = Client::count();
		$sub_count        		 = Subcontractor::count();
		$active_prj_count 		 = Project::where('status', 1)->count();
		$completed_prj_count	 = Project::where('project_status', 2)->count();
		$supplier_count   		 = Supplier::count();
		$active_user_count		 = Admin::where('status', 1)->count();

		$recent_projects = Project::select('projects.*', 'clients.client_name')
			->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
			->orderBy('projects.id', 'DESC')
			->limit(5)
			->get();

		$now = Carbon::now();

		$monthly_income  = (float) Revenue::whereYear('entry_date', $now->year)
			->whereMonth('entry_date', $now->month)
			->sum('income');

		$monthly_expense = (float) Revenue::whereYear('entry_date', $now->year)
			->whereMonth('entry_date', $now->month)
			->sum('expense');

		// Yearly project counts (by created_at) — last 6 years including current,
		// filled with zero for any year that has no projects so the chart is continuous.
		$yearRows = Project::selectRaw('YEAR(created_at) as year, COUNT(*) as cnt')
			->groupBy('year')
			->pluck('cnt', 'year')
			->toArray();

		$yearly_projects = [];
		for ($i = 5; $i >= 0; $i--) {
			$y = (int) $now->copy()->subYears($i)->year;
			$yearly_projects[] = [
				'year' => $y,
				'cnt'  => (int) ($yearRows[$y] ?? 0),
			];
		}

		return view('admin.dashboard.dashboard', compact(
			'cm', 'lbr_count', 'prj_count', 'stf_count',
			'client_count', 'sub_count', 'active_prj_count', 'completed_prj_count',
			'supplier_count', 'active_user_count',
			'recent_projects', 'monthly_income', 'monthly_expense',
			'yearly_projects'
		));
	}

  //TO CHANGE ADMIN PASSWORD
  
	public function change_password(Request $request)
	{

	$dat=['password'=>Hash::make($request->new_pass)];
	$res=Admin::where('id',$request->aid)->update($dat);

	return $res;

	}

  
}
