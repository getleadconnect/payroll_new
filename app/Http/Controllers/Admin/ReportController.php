<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Models\Labour;
use App\Models\Company;
use App\Models\Project;
use App\Models\LabourDailyWage;
use App\Models\MiscSiteExpense;
use App\Models\MiscWork;
use App\Models\SubcontractorWork;
use App\Models\SubcontractorRate;
use App\Models\MaterialSupply;
use App\Models\Staff;
use App\Models\StaffSalary;
use App\Models\Revenue;

use Validator;
use DataTables;
use Session;
//use MessageBag;
use Carbon\Carbon;


class ReportController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	 $lbrs=(new Labour())->getLabours();
	 return view('admin.labour_reports.labour_details_reports',compact('lbrs'));
  }	
    
  public function get_labour_detail_report($id)
  {
	 $ldt=(new Labour())->getLabourById($id);
	 $cm=(new Company())->getCompany();
	 return view('admin.labour_reports.labour_details',compact('ldt','cm'));
  }
   
  //----------------------------------------------------------------------------------------
   
  public function project_reports()
  {
	$projs=Project::select('projects.*','clients.client_name','project_types.project_type')
	->leftJoin('clients','projects.client_id','=','clients.id')
	->leftJoin('project_types','projects.project_type_id','=','project_types.id')
	->where('projects.status',1)
	->orderBy('id','ASC')
	->get();
	
	 $cm=(new Company())->getCompany();
	return view('admin.reports.project_reports',compact('projs','cm'));
  }	

//=====================MISCELLANEOUS (NON-GST) SITE REPORT =======================================

public function miscellaneous_report(Request $request)
  {
	
	$projs=(new Project())->getProjects();
	$proid=$request->flt_project_id??"";

	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
		
	$data=[];
	if($sdate!="" && $edate!="" && $proid!="")
	{
		$data=$this->viewMiscellaneousNonGstReport($request,$sdate,$edate);
	}
	
	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.miscellaneous_non_gst_report',compact('projs','data','sdate','edate','messg'));
  }	


public function viewMiscellaneousNonGstReport($request,$sdate=null,$edate=null) //view data
  {

		$pro_id=$request->flt_project_id;
		
		/*$sdate="";$edate="";
		
		$edate=$request->flt_end_date;

		if(Session::get('admin_role_id')==1)
		{
			$thu_date=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
			$sdate=$request->flt_start_date??Carbon::createFromDate($thu_date)->subDays(6)->toDateString();	
		}
		else
		{
			$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
		}*/
						
		$lbrs=MiscSiteExpense::select('misc_site_expenses.*','projects.project_name')
		->leftJoin('projects','misc_site_expenses.project_id','=','projects.id')
		->where('project_id',$pro_id)->whereBetween('invoice_date',[$sdate,$edate])
		->where('payment_type_id',1)->orderBy('invoice_date','ASC')->get();
		
		$data = array();
		$uData = array();

		if(!$lbrs->isEmpty())
		{
			$tamt=0;
			
			foreach($lbrs as $key=>$r)
			{
				if($r->payment_type_id==1){ $ptype="CASH/SITE";} else { $ptype="";}
				
				$uData['no'] = ++$key;
				$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['inv_no'] =$r->invoice_no;
				$uData['item'] =$r->item_name;
				$uData['desc'] =$r->description;
				$uData['ptype'] =$ptype;
				$uData['amt'] =number_format($r->amount,2,'.',',');
				$tamt=$tamt+$r->amount;
				$data[] = $uData;
			}
			
			$data[0]['netpay']=number_format($tamt,2,'.',',');
			$data[0]['project']=$lbrs[0]->project_name;
		}
		return $data;
	}


//=====================MISCELLANEOUS (GST) SITE REPORT =======================================

public function miscellaneous_gst_report(Request $request)
  {
	
	$projs=(new Project())->getProjects();

	$proid=$request->flt_project_id??"";
			
	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
	
	$data=[];
	if($sdate!="" && $edate!="" && $proid!="")
	{
		$data=$this->viewMiscellaneousGstReport($request,$sdate,$edate);
	}
	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.miscellaneous_gst_report',compact('projs','data','sdate','edate','messg'));
  }	


public function viewMiscellaneousGstReport($request,$sdate=null,$edate=null) //view data
  {

		$pro_id=$request->flt_project_id;
					
		$mwrks=MiscWork::select('misc_works.*','misc_vendors.name as vendor_name','projects.project_name')
		->leftJoin('projects','misc_works.project_id','=','projects.id')
		->leftJoin('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
		->where('project_id',$pro_id)->whereBetween('invoice_date',[$sdate,$edate])
		->where('payment_type_id',1)->orderBy('invoice_date','ASC')->get();
		
		$data = array();
		$uData = array();

		if(!$mwrks->isEmpty())
		{
			$tamt=0;
			$gamt=0;
			foreach($mwrks as $key=>$r)
			{
				if($r->payment_type_id==1){ $ptype="CASH/SITE";} else { $ptype="";}
				 
				$uData['no'] = ++$key;
				$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['inv_no'] =$r->invoice_no;
				$uData['vname'] =$r->vendor_name;
				$uData['desc'] =$r->description;
				$uData['ptype'] =$ptype;
				$uData['gst_amt'] =number_format($r->gst_amount,2,'.',',');
				$uData['amt'] =number_format($r->total_amount,2,'.',',');
				$tamt=$tamt+$r->total_amount;
				$gamt=$gamt+$r->gst_amount;
				$data[] = $uData;
			}
			$data[0]['project']=$mwrks[0]->project_name;
			$data[0]['total_gst']=number_format($gamt,2,'.',',');
			$data[0]['total_amount']=number_format($tamt,2,'.',',');
		}
		return $data;
	}


//=====================MISCELLANEOUS (NON-GST) OFFICE PAYMENT REPORT =======================================


public function misc_non_gst_office_payment(Request $request)
  {
	
	$projs=(new Project())->getProjects();
	
	$proid=$request->flt_project_id??"";
	
	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}

	$data=[];
	$vndat=[];
	if($sdate!="" && $edate!="" && $proid!="")
	{
		$data=$this->viewMiscellaneousNonGstOfficePaymentReport($request,$vndat,$sdate,$edate);
	}
	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.miscellaneous_non_gst_office_payment_report',compact('projs','data','sdate','edate','messg'));
  }	


public function viewMiscellaneousNonGstOfficePaymentReport($request,$vndat,$sdate=null,$edate=null) //view data
  {

		$pro_id=$request->flt_project_id;
		
		$msexp=MiscSiteExpense::select('misc_site_expenses.*','projects.project_name')
			->leftJoin('projects','misc_site_expenses.project_id','=','projects.id')
			->where('project_id',$pro_id)->whereIn('payment_type_id',[2,3])
			->whereBetween('invoice_date',[$sdate,$edate])
			->orderBy('invoice_date','ASC')->get();

	  $data = array();
	  $uData = array();
		
	  if(!$msexp->isEmpty())
	  {
		  $tamt=0;
		foreach($msexp as $key=>$r)
		{

		   if($r->payment_type_id==2){ $ptype="CASH";} else { $ptype="CHEQUE";}
		  
			$uData['no'] = ++$key;
			$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
			$uData['inv_no'] =$r->invoice_no;
			$uData['item'] =$r->item_name;
			$uData['desc'] =$r->description;
			$uData['ptype'] =$ptype;
			$uData['amt'] =$r->amount;
			$tamt+=$r->amount;
			$data[]= $uData;
		}
		
		$data[0]['total']=number_format($tamt,2,'.',',');
		$data[0]['project']=$msexp[0]->project_name;
		
	  }

	return $data;
	
  }


//=====================MISCELLANEOUS (GST) OFFICE PAYMENT REPORT =======================================

public function misc_gst_office_payment(Request $request)
  {
	
	$projs=(new Project())->getProjects();

	$proid=$request->flt_project_id??"";
	
	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
	
	$data=[];
	if($sdate!="" && $edate!="" && $proid!="")
	{
		$data=$this->viewMiscellaneousGstOfficePayment($request,$sdate,$edate);
	}
	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.miscellaneous_gst_office_payment_report',compact('projs','data','sdate','edate','messg'));
  }	


/*public function get_misc_vendors($proid,$sdate,$edate)
{
	 $vndrs=MiscWorks::select('misc_works.project_id','misc_works.payment_type_id','misc_works.misc_vendor_id')
		->leftJoin('projects','misc_works.project_id','=','projects.id')
		->groupBy('misc_works.project_id','misc_works.payment_type_id','misc_works.misc_vendor_id')
		->where('project_id',$proid)->whereIn('payment_type_id',[2,3])->get();
	
	return $vndrs;
}*/

public function viewMiscellaneousGstOfficePayment($request,$sdate=null,$edate=null) //view data
  {

		$pro_id=$request->flt_project_id;
				
		$mwrks=MiscWork::select('misc_works.*','misc_vendors.id as vendor_id','misc_vendors.name as vendor_name','projects.project_name','payment_types.payment_type')
		->leftJoin('projects','misc_works.project_id','=','projects.id')
		->leftJoin('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
		->leftJoin('payment_types','misc_works.payment_type_id','=','payment_types.id')
		->where('project_id',$pro_id)->whereIn('payment_type_id',[2,3])
		->whereBetween('invoice_date',[$sdate,$edate])->orderBy('vendor_id','ASC')->get();
		
		$data = array();
		$uData = array();

		if(!$mwrks->isEmpty())
		{
			$tamt=0;
			$gamt=0;
			foreach($mwrks as $key=>$r)
			{
				if($r->payment_type_id==2){ $ptype="CASH";} else { $ptype="CHEQUE";}
				
				$uData['no'] = ++$key;
				$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['inv_no'] =$r->invoice_no;
				$uData['vname'] =$r->vendor_name;
				$uData['desc'] =$r->description;
				$uData['ptype'] =$ptype;
				$uData['gst_amt'] =number_format($r->gst_amount,2,'.',',');
				$uData['amt'] =number_format($r->total_amount,2,'.',',');
				$tamt=$tamt+$r->total_amount;
				$gamt=$gamt+$r->gst_amount;
				$data[] = $uData;
			}
			$data[0]['project']=$mwrks[0]->project_name;
			$data[0]['total_gst']=number_format($gamt,2,'.',',');
			$data[0]['total_amount']=number_format($tamt,2,'.',',');
		}
		return $data;
	}


//=====================SUB-CONTRACTOR'S WORK REPORT =======================================

public function subcontractor_work_report(Request $request)
  {
	$projs=(new Project())->getProjects();
		
	$proid=$request->flt_project_id??"";
	
	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
	
	$pro_name=Project::where('id',$proid)->pluck('project_name');
	
	$data=[];
	$scon=[];
	$sworks=[];
	if($sdate!="" && $edate!="" && $proid!="")
	{
	  //$data=$this->viewMiscellaneousGstReport($request);
	  $scon=$this->get_subcontractors($proid);
      $sworks=$this->get_subcontractors_works($proid,$sdate,$edate);
    }

	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.subcontractor_works_report',compact('projs','pro_name','scon','sworks','messg','sdate','edate'));
  }	
  
  
  public function get_subcontractors($pro_id)
  {
	  
	$subcon=SubcontractorRate::select('subcontractor_rates.subcontractor_id','subcontractors.name')
	  ->leftJoin('subcontractors','subcontractor_rates.subcontractor_id','=','subcontractors.id')
	  ->groupBy('subcontractor_rates.subcontractor_id','subcontractors.name')
	  ->where('project_id',$pro_id)->get();
	  
	return $subcon;
  }

  
public function get_subcontractors_works($pro_id,$sdate,$edate) //view data
  {
	  $subcon=$this->get_subcontractors($pro_id);
	 
		$uData=[];
		$data=[];
			
	  if(!$subcon->isEmpty())
		{
			foreach($subcon as $r)
			{
				$sid=$r->subcontractor_id;
				
				$swrks=SubcontractorWork::select('subcontractor_works.*','subcontractors.name as subco_name','floor_nos.floor_no','main_cost_items.main_item','material_units.unit_name')
				->leftJoin('subcontractors','subcontractor_works.subcontractor_id','=','subcontractors.id')
				->leftJoin('floor_nos','subcontractor_works.floor_no_id','=','floor_nos.id')
				->leftJoin('main_cost_center','subcontractor_works.main_cost_center_id','=','main_cost_center.id')
				->leftJoin('main_cost_items','main_cost_center.main_cost_item_id','=','main_cost_items.id')
				->leftJoin('material_units','subcontractor_works.material_unit_id','=','material_units.id')
				->where('subcontractor_works.subcontractor_id',$sid)->where('subcontractor_works.project_id',$pro_id)
				->whereBetween('subcontractor_works.entry_date',[$sdate,$edate])
				->orderBy('subcontractor_works.item_rate','ASC')->get();
				
				//dd($swrks);
		
				
				if(!$swrks->isEmpty())
				{
					$tot=0;	
					foreach($swrks as $key=>$r1)
					{
						
						$uData['subco_name'] =$r1->subco_name;
						$uData['no'] = ++$key;
						$uData['inv_date'] =date_create($r1->entry_date)->format('d-m-Y');
						$uData['fno'] =$r1->floor_no;
						$uData['cost_center'] =$r1->main_item;
						$uData['desc'] =$r1->description;
						$uData['nos'] =$r1->nos;
						$uData['length'] =$r1->length;
						$uData['bredth'] =$r1->bredth;
						$uData['width'] =$r1->width;
						$uData['qty'] =$r1->quantity;
						$uData['unit'] =$r1->unit_name;
						$uData['rate'] =$r1->item_rate;
						$uData['amount'] =$r1->amount;
						$data["sw-".$sid][]= $uData;
					}
				}
			}
		}

		return $data;
  }

/*
public function viewSubcontractors($request) //view data
  {
		
		$mwrks=SubcontractorWork::select('subcontractor_works.*','misc_vendors.name as vendor_name','projects.project_name')
		->leftJoin('subcontractors','misc_works.project_id','=','projects.id')
		->leftJoin('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
		->where('project_id',$pro_id)->whereBetween('invoice_date',[$sdate,$edate])
		->get();
		
		$data = array();
		$uData = array();

		if(!$mwrks->isEmpty())
		{
			$tamt=0;
			$gamt=0;
			foreach($mwrks as $key=>$r)
			{
				$uData['no'] = ++$key;
				$uData['inv_date'] =date_create($r->invoice_date)->format('d-m-Y');
				$uData['inv_no'] =$r->invoice_no;
				$uData['vname'] =$r->vendor_name;
				$uData['desc'] =$r->description;
				$uData['gst_amt'] =number_format($r->gst_amount,2,'.',',');
				$uData['amt'] =number_format($r->total_amount,2,'.',',');
				$tamt=$tamt+$r->total_amount;
				$gamt=$gamt+$r->gst_amount;
				$data[] = $uData;
			}
			$data[0]['project']=$mwrks[0]->project_name;
			$data[0]['total_gst']=number_format($gamt,2,'.',',');
			$data[0]['total_amount']=number_format($tamt,2,'.',',');
		}
		return $data;
	}


*/


public function material_gst_office_payment(Request $request)
  {
	$projs=(new Project())->getProjects();
	
	$proid=$request->flt_project_id??"";
	
	$edate=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$sdate=$request->flt_start_date??Carbon::createFromDate($edate)->subDays(6)->toDateString();	
	}
	else
	{
		$sdate=Carbon::createFromDate($edate)->subDays(6)->toDateString();
	}
	
	$pro_name=Project::where('id',$proid)->pluck('project_name');
	
	$data=[];

	if($sdate!="" && $edate!="" && $proid!="")
	{
      $data=$this->viewMaterialGstOfficePayment($proid,$sdate,$edate);
    }

	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.materials_gst_office_payment_report',compact('projs','pro_name','data','messg','sdate','edate'));
  }	
   
 
 
public function viewMaterialGstOfficePayment($pro_id,$sdate,$edate) //view data
  {

	 $madat=MaterialSupply::select('material_supply.*','projects.project_name','suppliers.supplier_name','material_types.material_type_name','material_sub_types.sub_type_name')
			->leftJoin('projects','material_supply.project_id','=','projects.id')
			->leftJoin('suppliers','material_supply.supplier_id','=','suppliers.id')
			->leftJoin('material_types','material_supply.material_type_id','=','material_types.id')
			->leftJoin('material_sub_types','material_supply.material_sub_type_id','=','material_sub_types.id')
			->where('material_supply.project_id',$pro_id)->whereBetween('material_supply.supply_date',[$sdate,$edate])
			->orderBy('material_supply.payment_type_id','ASC')->get();
	
	$data=[];
	$uData=[];
	if(!$madat->isEmpty())
	{
		
		$tamt=0;
		
		foreach($madat as $key=>$r)
		{
			if($r->payment_type_id==2){ $ptype="CASH";} else { $ptype="CHEQUE";}
			
			$pt="pt-".$r->payment_type_id;
			
			$uData['no'] = ++$key;
			$uData['inv_date'] =date_create($r->supply_date)->format('d-m-Y');
			$uData['pro_name'] =$r->project_name;
			$uData['inv_no'] =$r->invoice_no;
			$uData['supp'] =$r->supplier_name;
			$uData['mat'] =$r->material_type_name."-".$r->sub_type_name;
			$uData['ptype'] =$ptype;
			$uData['qty'] =$r->quantity;
			$uData['unit'] =$r->material_unit;
			$uData['rate'] =$r->price;
			$uData['gst_amt'] =$r->gst_amount;
			$uData['amt'] =$r->amount;
			$tamt+=$r->amount;
			$data[$pt][]= $uData;
		}
	}

	return $data;
  }

//===================== STAFF SALARY REPORT =======================================

public function staff_salary_report(Request $request)
  {
	
	$projs=(new Project())->getProjects();
		
	$proid=$request->flt_project_id??"";
	$mon=$request->flt_month??"";
	$yr=$request->flt_year??"";
	
	$mdate='';
	$data=[];
	if($proid!="" and $mon!="" and $yr!="")
	{
		$mdate=$yr."-".$mon."-01";
		$data=$this->viewStaffSalaryReport($request);
	}
	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.staff_salary_report',compact('projs','data','mdate','messg'));
  }	
    
	
public function viewStaffSalaryReport($request) //view data
  {

		$proid=$request->flt_project_id;
		$mon=$request->flt_month;
		$yr=$request->flt_year;
		
		$ssal=[];
		
		if($request->flt_month!="" and $request->flt_year!="")
		{
		$ssal=StaffSalary::select('staff_salary.*','projects.project_name','staffs.name as staff_name')
		->leftJoin('projects','staff_salary.project_id','=','projects.id')
		->leftJoin('staffs','staff_salary.staff_id','=','staffs.id')
		->where('project_id',$proid)->where('month',$mon)->where('year',$yr)
		->orderBy('staff_salary.id','ASC')->get();
		}

		$data = array();
		$uData = array();

		if(!$ssal->isEmpty())
		{
			$t_sal=0;
			$tn_amt=0;
			$ts_amt=0;
			$gt_amt=0;
			
			foreach($ssal as $key=>$r)
			{
				$uData['no'] = ++$key;
				$uData['sname'] =$r->staff_name;
				$uData['sal'] =number_format($r->salary,2,'.',',');
				$uData['myr'] =$r->month."/".$r->year;
				$uData['n_ot'] =$r->normal_ot;
				$uData['s_ot'] =$r->sunday_ot;
				$uData['nrate'] =number_format($r->normal_rate,2,'.',',');
				$uData['srate'] =number_format($r->sunday_rate,2,'.',',');
				$uData['n_amt'] =number_format($r->normal_amt,2,'.',',');
				$uData['s_amt'] =number_format($r->sunday_amt,2,'.',',');
				$uData['nsal'] =number_format($r->net_salary,2,'.',',');
				
				$t_sal+=$r->salary;
				$tn_amt+=$r->normal_amt;
				$ts_amt+=$r->sunday_amt;
				$gt_amt+=$r->net_salary;

				$data[] = $uData;
			}
			
			$data[0]['project']=$ssal[0]->project_name;
			$data[0]['total_sal']=number_format($t_sal,2,'.',',');
			$data[0]['total_namt']=number_format($tn_amt,2,'.',',');
			$data[0]['total_samt']=number_format($ts_amt,2,'.',',');
			$data[0]['total_salary']=number_format($gt_amt,2,'.',',');
		}
		
		return $data;
	}

// project SUMMATION report ----------------------------------------------------------------

public function project_summation_report(Request $request)
  {

	$projs=(new Project())->getProjects();
	
	$proid=$request->flt_project_id??"";
	
	$edt=$request->flt_end_date??Carbon::parse('this thursday')->toDateString(); 
		
	if(Session::get('admin_role_id')==1)
	{
		//$edate=Carbon::parse('this thursday')->toDateString();  //next and current thursday date
		$fdt=$request->flt_start_date??Carbon::createFromDate($edt)->subDays(6)->toDateString();	
	}
	else
	{
		$fdt=Carbon::createFromDate($edt)->subDays(6)->toDateString();
	}
	

	$data=[];
	$data['start_date']="";
	$data['end_date']="";
	$data['project_name']="";
	$data['site_exp']=[];
	$data['site_total']=0;
	//site revenue
	$data['rev_bal']=0;   
	$data['rev_demand']=0;
	$data['rev_total']=0;
	$data['site_balance']=0;
	//office expenses
	$data['office_exp']=[];
	$data['office_total']=0;
		
	$data['rev_cash']=0;
	$data['rev_cheque']=0;
	$data['rev_off_total']=0;
	$data['rev_off_balance']=0;
	
	$start_date=$fdt;
	$thu_date=$edt;

	if($proid!="" and $fdt!="" and $edt!="")
	{
		$pro=Project::findorfail($proid);
		if(!empty($pro)){ $data['project_name']=$pro->project_name;}
				
		$fdt=date_create($fdt)->format('Y-m-d');
		$edt=date_create($edt)->format('Y-m-d');
		
		$data['start_date']=date_create($fdt)->format('l, d F Y');
		$data['end_date']=date_create($edt)->format('l, d F Y');	


		//site expenses
		$ldw_sum=LabourDailyWage::whereBetween('entry_date',[$fdt,$edt])->where('project_id',$proid)->sum('total_wage');
		$mse_ng_sum=MiscSiteExpense::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',1)->sum('amount');
		$mse_g_sum=MiscWork::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',1)->sum('total_amount');
		$scw_sum=SubcontractorWork::whereBetween('entry_date',[$fdt,$edt])->where('project_id',$proid)->sum('amount');
		$sta_sal=StaffSalary::whereBetween('entry_date',[$fdt,$edt])->where('project_id',$proid)->sum('net_salary');
		
		//office expenses
		$off_mat_sum=MaterialSupply::whereBetween('supply_date',[$fdt,$edt])->where('project_id',$proid)->sum('amount');
		$off_mng_sum=MiscSiteExpense::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->whereIn('payment_type_id',[2,3])->sum('amount');
		$off_mg_sum=MiscWork::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->whereIn('payment_type_id',[2,3])->sum('total_amount');
		
		$rev_balance=Revenue::where('revenue_type',"RETURN")->whereBetween('voucher_date',[$fdt,$edt])->where('project_id',$proid)->sum('expense');
		$rev_demand=Revenue::where('revenue_type',"GET")->whereBetween('voucher_date',[$fdt,$edt])->where('project_id',$proid)->sum('income');
		
		//office site expense
		$rev_cash1=MiscSiteExpense::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',2)->sum('amount');
		$rev_cash2=MiscWork::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',2)->sum('total_amount');
		$rev_cash3=MaterialSupply::whereBetween('supply_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',2)->sum('amount');
		$rev_cash_total=($rev_cash1+$rev_cash2+$rev_cash3);
		
		$rev_cheque1=MiscSiteExpense::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',3)->sum('amount');
		$rev_cheque2=MiscWork::whereBetween('invoice_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',3)->sum('total_amount');
		$rev_cheque3=MaterialSupply::whereBetween('supply_date',[$fdt,$edt])->where('project_id',$proid)->where('payment_type_id',3)->sum('amount');
		$rev_cheque_total=($rev_cheque1+$rev_cheque2+$rev_cheque3);
				
		//site expenses
		$data['site_exp']['l_wage']=$ldw_sum;
		$data['site_exp']['mng_site']=$mse_ng_sum;
		$data['site_exp']['mg_site']=$mse_g_sum;
		$data['site_exp']['sc_works']=$scw_sum;
		$data['site_exp']['st_sal']=$sta_sal;
		
		$data['site_total']=($ldw_sum+$mse_ng_sum+$mse_g_sum+$scw_sum+$sta_sal);
		
		//site revenue
		$data['rev_bal']=$rev_balance;   
		$data['rev_demand']=$rev_demand;
		$data['rev_total']=($rev_balance+$rev_demand);

		$data['site_balance']=$data['rev_total']-$data['site_total'];
				
		//office expenses
		$data['office_exp']['material']=$off_mat_sum;
		$data['office_exp']['mng_off']=$off_mng_sum;
		$data['office_exp']['mg_off']=$off_mg_sum;
		
		$data['office_total']=($off_mat_sum+$off_mng_sum+$off_mg_sum);
		
		$data['rev_cash']=$rev_cash_total;
		$data['rev_cheque']=$rev_cheque_total;
		$data['rev_off_total']=($data['rev_cash']+$data['rev_cheque']);
		$data['rev_off_balance']=($data['rev_off_total']-$data['office_total']);
	}
	
	$data_head=['l_wage'=>"LABOUR WAGES",'mng_site'=>"MISCELLANEOUS NON-GST SITE",'mg_site'=>"MISCELLANEOUS GST SITE",
			'sc_works'=>"SUB-CONTRACTOR WORKS",'st_sal'=>"STAFF SALARY",'material'=>"MATERIALS",
			'mng_off'=>"MISCELLANEOUS NON-GST OFFICE",'mg_off'=>"MISCELLANEOUS GST OFFICE"
	];

	if(empty($data)){$messg="No data were found.!";}else{$messg="";}
	
	return view('admin.reports.project_summation_report',compact('projs','data','data_head','start_date','thu_date','messg'));
	
  }	

}
