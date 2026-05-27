<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Labour;
use App\Models\Project;
use App\Models\LabourDailyWage;

use Validator;
use DataTables;
use Session;
//use MessageBag;
use Carbon\Carbon;


class LabourReportController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	
	$projs=(new Project())->getProjects();

	$thu_date= Carbon::parse('this thursday')->toDateString();  //next and current thursday date
	$start_date=Carbon::createFromDate($thu_date)->subDays(6)->toDateString();	
	$data=[];
	$pr=[];
	Session::forget('weekly_report_project');
	return view('admin.labour_reports.labour_weekly_work_reports_new',compact('projs','pr','start_date','thu_date','data'));
  }	
    
  public function weekly_report(Request $request)
  {
	$pr=(new Project())->getProjectById($request->flt_project_id);
	$projs=(new Project())->getProjects();
	
	$edate=$request->flt_end_date;
	
	if(Session::get('admin_role_id')==1)
	{
		
		$thu_date=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$start_date=($request->flt_start_date!="")?$request->flt_start_date:Carbon::createFromDate($thu_date)->subDays(6)->toDateString();	
		
	}
	else
	{
		$thu_date=$edate;
		$start_date=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
	
	Session::put(['weekly_report_project'=>$request->flt_project_id]);
	$data=$this->viewLabourWeeklyReports($request);
	
	return view('admin.labour_reports.labour_weekly_work_reports_new',compact('projs','pr','start_date','thu_date','data'));
  }	
  
   
  public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = $this->viewLabourWeeklyReports($request);

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }
	}
 
	//--------------------------------------------------------------------------------------------------
	
	public function viewLabourWeeklyReports($request) //view data
	{

		$search=$request->search;
		$pro_id=$request->flt_project_id;
		$sdate="";$edate="";

			$edate=$request->flt_end_date;
			
			if(Session::get('admin_role_id')==1)
			{
				$sdate=$request->flt_start_date;
				$edate=$request->flt_end_date;
			}
			else
			{
				if($request->flt_end_date!="")
				{
					$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
					
				}
			}
			
			if($sdate!="" and $edate!="")
			{
					Session::put(['weekly_start_date'=>date_create($sdate)->format('d-m-Y')]);
					Session::put(['weekly_end_date'=>date_create($edate)->format('d-m-Y')]);	
			}
			

		$lbrs=LabourDailyWage::select('labour_id','normal_wage', 'concrete_wage', 'normal_ot','concrete_ot','labours.name','labours.code')
		->leftJoin('labours','labour_daily_wages.labour_id','=','labours.id')
		->groupBy('labour_id','normal_wage', 'concrete_wage', 'normal_ot','concrete_ot','labours.name','labours.code')
		->whereBetween('entry_date',[$sdate,$edate])
		->orderBy('labours.code','ASC')
		->get();

		$data = array();
		$uData = array();
		$total=0;
		if(!$lbrs->isEmpty())
		{
			foreach($lbrs as $key=>$r)
			{
					$res=LabourDailyWage::groupBy('labour_id')
					->selectRaw('sum(normal_hour) as sum_w_hrs, sum(concrete_hour) as sum_c_hrs, sum(amt_otn) as sum_otn,
					sum(amt_oh) as sum_oh, sum(amt_ch) as sum_ch,sum(amt_otc) as sum_otc, sum(otn_hrs) as sum_otn_hrs,
					sum(otc_hrs) as sum_otc_hrs,sum(total_wage) as sum_twage')
					->whereBetween('entry_date',[$sdate,$edate])
					->where('project_id',$pro_id)->where('labour_id',$r->labour_id)
					->orderBy('labour_id','ASC')->get();

					if(!$res->isEmpty())
					{
						$uData['id'] = ++$key;
						$uData['cod'] = $r->code;
						$uData['edate'] =date_create($sdate)->format('d-m-Y')." => ".date_create($edate)->format('d-m-Y');
						$uData['lbr'] =$r->name;
						$uData['hrs'] =$res[0]->sum_w_hrs;
						$uData['normal_rate'] =number_format($r->normal_wage,2,'.',',');
						$uData['concrete_rate'] =number_format($r->concrete_wage,2,'.',',');
						$uData['normal_ot'] =number_format($r->normal_ot,2,'.',',');
						$uData['concrete_ot'] =number_format($r->concrete_ot,2,'.',',');
						$uData['days_n']=($res[0]->sum_w_hrs/8);
						$uData['days_c']=($res[0]->sum_c_hrs/8);
						$uData['otn_hrs'] =$res[0]->sum_otn_hrs;
						$uData['otc_hrs'] =$res[0]->sum_otc_hrs;
						
						$uData['ot_wage'] =number_format(($res[0]->sum_otn+$res[0]->sum_otc),2,'.',',');
												
						$uData['twage'] =number_format(($res[0]->sum_oh+$res[0]->sum_ch),2,'.',',');
						
						$uData['gtwage'] =number_format($res[0]->sum_twage,2,'.',',');
						
						$total+=$res[0]->sum_twage;
						
						$uData['netpay'] =number_format($total,2,'.',',');
						
						$data[] = $uData;
					}
			}
			
			$data[0]['netpay']=number_format($total,2,'.',',');
		}
		
		return $data;
	}

}
