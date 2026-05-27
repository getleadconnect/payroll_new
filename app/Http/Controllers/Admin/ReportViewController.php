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
use App\Models\Supplier;
use App\Models\MiscVendor;
use App\Models\MiscCategory;
use App\Models\SkillType;
use App\Models\ProjectLabour;

use Validator;
use DataTables;
use Session;
//use MessageBag;
use Carbon\Carbon;


class ReportViewController extends Controller
{
    
  public function __construct()
  {
     $this->middleware('admin');
  }
  
  public function index()
  {
	
  }	
     
// project SUMMATION report ----------------------------------------------------------------

public function view_project_summation(Request $request)
  {

	$projs=(new Project())->getProjects();
	
	$proid=$request->flt_project_id??"";

	$data=[];
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

	if($proid!="")
	{
		$pro=Project::findorfail($proid);
		if(!empty($pro)){ $data['project_name']=$pro->project_name;}

		//site expenses
		$ldw_sum=LabourDailyWage::where('project_id',$proid)->sum('total_wage');
		$mse_ng_sum=MiscSiteExpense::where('project_id',$proid)->where('payment_type_id',1)->sum('amount');
		$mse_g_sum=MiscWork::where('project_id',$proid)->where('payment_type_id',1)->sum('total_amount');
		$scw_sum=SubcontractorWork::where('project_id',$proid)->sum('amount');
		$sta_sal=StaffSalary::where('project_id',$proid)->sum('net_salary');
		
		//office expenses
		$off_mat_sum=MaterialSupply::where('project_id',$proid)->sum('amount');
		$off_mng_sum=MiscSiteExpense::where('project_id',$proid)->whereIn('payment_type_id',[2,3])->sum('amount');
		$off_mg_sum=MiscWork::where('project_id',$proid)->whereIn('payment_type_id',[2,3])->sum('total_amount');
		
		$rev_balance=Revenue::where('revenue_type',"RETURN")->where('project_id',$proid)->sum('expense');
		$rev_demand=Revenue::where('revenue_type',"GET")->where('project_id',$proid)->sum('income');
		
		//office site expense
		$rev_cash1=MiscSiteExpense::where('project_id',$proid)->where('payment_type_id',2)->sum('amount');
		$rev_cash2=MiscWork::where('project_id',$proid)->where('payment_type_id',2)->sum('total_amount');
		$rev_cash3=MaterialSupply::where('project_id',$proid)->where('payment_type_id',2)->sum('amount');
		$rev_cash_total=($rev_cash1+$rev_cash2+$rev_cash3);
		
		$rev_cheque1=MiscSiteExpense::where('project_id',$proid)->where('payment_type_id',3)->sum('amount');
		$rev_cheque2=MiscWork::where('project_id',$proid)->where('payment_type_id',3)->sum('total_amount');
		$rev_cheque3=MaterialSupply::where('project_id',$proid)->where('payment_type_id',3)->sum('amount');
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
	
	return view('admin.details.project_summation_report',compact('projs','data','data_head','messg'));
	
  }	
  
  
 

// ADDITIONAL REPORT VIEWS --------------------------------------------------
 

public function material_supplier_analysis(Request $request)
{
	$supp=(new Supplier())->getSuppliers();
	$mdata=$this->view_material_suppler_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.material_suppler_analysis',compact('supp','mdata','sdate','edate'));
	
}


public function view_material_suppler_data($request)  //view data
	{

		$supp_id=$request->supplier_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		
		
		$datas=[];
		if($supp_id!="")
		{
			$dats=MaterialSupply::query();		
			
			$dats->select('material_supply.*','suppliers.supplier_name','projects.project_name','material_types.material_type_name','material_sub_types.sub_type_name')
			->leftJoin('suppliers','material_supply.supplier_id','=','suppliers.id')
			->leftJoin('projects','material_supply.project_id','=','projects.id')
			->leftJoin('material_types','material_supply.material_type_id','=','material_types.id')
			->leftJoin('material_sub_types','material_supply.material_sub_type_id','=','material_sub_types.id')
			->where('material_supply.supplier_id',$supp_id);
		
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('material_supply.supply_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}

//-----------------------------------------------------------------------------

public function project_supplier_analysis(Request $request)  // PROJECT MATERIAL SUPLIER ANALYSIS
{
	$projs=(new Project())->getProjects();
	$mdata=$this->view_project_material_supplier_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.project_material_suppler_analysis',compact('projs','mdata','sdate','edate'));
	
}


public function view_project_material_supplier_data($request)  //view data
	{

		$pro_id=$request->project_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		$datas=[];
		if($pro_id!="")
		{

			$dats=MaterialSupply::query();			
			
			$dats->select('material_supply.*','suppliers.supplier_name','projects.project_name','material_types.material_type_name','material_sub_types.sub_type_name')
			->Join('projects','material_supply.project_id','=','projects.id')
			->Join('suppliers','material_supply.supplier_id','=','suppliers.id')
			->Join('material_types','material_supply.material_type_id','=','material_types.id')
			->Join('material_sub_types','material_supply.material_sub_type_id','=','material_sub_types.id')
			->where('material_supply.project_id',$pro_id);
			
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('material_supply.supply_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}
	

//--------------------------------------------------------------------------	
	
public function vendor_project_analysis(Request $request)  // VENDER PROJECT ANALYSIS
{
	$vnd=(new MiscVendor())->getMiscVendors();
	$mdata=$this->view_vendor_analysis_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.vendor_project_analysis',compact('vnd','mdata','sdate','edate'));
	
}


public function view_vendor_analysis_data($request)  //view data
	{

		$ven_id=$request->vendor_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		$datas=[];
		if($ven_id!="")
		{

			$dats=MiscWork::query();			
			
			$dats->select('misc_works.*','projects.project_name','misc_vendors.name as vendor_name')
			->Join('projects','misc_works.project_id','=','projects.id')
			->Join('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
			->where('misc_works.misc_vendor_id',$ven_id);
			
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('misc_works.invoice_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}
	
//--------------------------------------------------------------------------	
	
public function project_vendor_analysis(Request $request)  // PROJECT VENDER ANALYSIS
{
	$projs=(new Project())->getProjects();
	$mdata=$this->view_project_vendor_analysis_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.project_vendor_analysis',compact('projs','mdata','sdate','edate'));
	
}


public function view_project_vendor_analysis_data($request)  //view data
	{

		$pro_id=$request->project_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		$datas=[];
		if($pro_id!="")
		{

			$dats=MiscWork::query();			
			
			$dats->select('misc_works.*','projects.project_name','misc_vendors.name as vendor_name')
			->Join('projects','misc_works.project_id','=','projects.id')
			->Join('misc_vendors','misc_works.misc_vendor_id','=','misc_vendors.id')
			->where('misc_works.project_id',$pro_id);
			
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('misc_works.invoice_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}
	
	
//--------------------------------------------------------------------------	
	
public function project_misc_analysis(Request $request)  // PROJECT MISC ANALYSIS
{
	$projs=(new Project())->getProjects();
	$mdata=$this->view_project_misc_analysis_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.project_misc_analysis',compact('projs','mdata','sdate','edate'));
	
}


public function view_project_misc_analysis_data($request)  //view data
	{

		$pro_id=$request->project_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		$datas=[];
		if($pro_id!="")
		{

			$dats=MiscSiteExpense::query();			
			
			$dats->select('misc_site_expenses.*','projects.project_name','misc_category.category_name')
			->Join('projects','misc_site_expenses.project_id','=','projects.id')
			->Join('misc_category','misc_site_expenses.misc_category_id','=','misc_category.id')
			->where('misc_site_expenses.project_id',$pro_id);
			
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('misc_site_expenses.invoice_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}	
	
	
//--------------------------------------------------------------------------	
	
public function category_misc_analysis(Request $request)  // CATEGORY MISC ANALYSIS
{
	$mcat=(new MiscCategory())->getMiscCategory();
	$mdata=$this->view_category_misc_analysis_data($request);
	
	$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.category_misc_analysis',compact('mcat','mdata','sdate','edate'));
	
}


public function view_category_misc_analysis_data($request)  //view data
	{

		$cat_id=$request->category_id;
		
		$sdate="";
		$edate="";
		
		if($request->start_date!="" and $request->end_date!="")
		{
			$sdate=$request->start_date;
			$edate=$request->end_date;
		}
		
		$datas=[];
		if($cat_id!="")
		{

			$dats=MiscSiteExpense::query();			
			
			$dats->select('misc_site_expenses.*','projects.project_name','misc_category.category_name')
			->Join('projects','misc_site_expenses.project_id','=','projects.id')
			->Join('misc_category','misc_site_expenses.misc_category_id','=','misc_category.id')
			->where('misc_site_expenses.misc_category_id',$cat_id);
			
			if($sdate!="" and $edate!="")
			{
			 $dats->whereBetween('misc_site_expenses.invoice_date',[$sdate,$edate]);
			}
			
			$datas=$dats->orderBy('id','ASC')->get();
		}
		return $datas;
	}	
	
//--------------------------------------------------------------------------	
	
public function project_labours_details(Request $request)  // PROJECT LABOURS DETAILS
{
	$projs=(new Project())->getProjects();
	$mdata=$this->view_project_labours_data($request);

	//$sdate=($request->start_date)?date_create($request->start_date)->format('d-m-Y'):"";
	//$edate=($request->end_date)?date_create($request->end_date)->format('d-m-Y'):"";
	
	return view('admin.details.project_labours_details',compact('projs','mdata'));
}

public function view_project_labours_data($request)  //view data
	{

		$pro_id=$request->project_id;

		$datas=[];
		if($pro_id!="")
		{

			$dats=ProjectLabour::query();	
			
			$dats->select('project_labours.*','projects.project_name','labours.code','labours.name as labour_name','labours.aadhar_no','labours.mobile','skill_types.skill_type','labour_wages.wage_normal','labour_wages.wage_concrete','labour_wages.wage_ot')
			->Join('labours','project_labours.labour_id','=','labours.id')
			->Join('skill_types','labours.skill_type_id','=','skill_types.id')
			->Join('labour_wages','project_labours.labour_wage_id','=','labour_wages.labour_id')
			->Join('projects','project_labours.project_id','=','projects.id')
			->where('project_labours.project_id',$pro_id);

			$datas=$dats->orderBy('labours.skill_type_id','ASC')->get();

		}
		return $datas;
	}	
	
	
			
		
	
	
}
