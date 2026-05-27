@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>

.tb-list th,tr,td
{
	height:30px;
	padding:7px;
}


</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="row">
					 
	<div class="col-xl-12 col-xxl-12 col-lg-12">
		<div class="card">
		
		    <div class="row card-title-align">
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<div class="card-header d-sm-flex d-block border-0" >
					<div class="mr-auto pr-3">
						<h4 class="text-black fs-20">Summation Report</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" id="btnFilter" class="btn btn-secondary btn-xs btn-sm" style="padding:5px 15px;"><i class="fas fa-filter"></i> Filter</button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
			  <form method="POST" action="{{url('view-summation-report')}}" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group mt-3">
				
				<label style="z-index:99999;position:absolute;margin-top:-10px;"><b>Filter</b></label>
				
				<div class="row" style="background:#b7d3ed;padding:5px 15px;">
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					    <select class="form-control " id="flt_project_id"  name="flt_project_id" required>
						 <option value="">--select--</option>
							@foreach($projs as $key=>$r)
								<option value="{{$r->id}}">{{$r->project_name}}</option>
							@endforeach
						</select>
				   </div>
				   
				    <div class="col-lg-1 col-xl-1 col-xxl-1">
					     <button type="submit" class="btn btn-secondary btn-size" >Get</button>
				   </div>

				</div>
				
				</div>
			</form>
				
			<hr>	

<!--- staff salry list --------------------------------------------->

			<div class="row mt-2">
				<div class="col-xl-12 col-xxl-12 col-lg-12 text-right">
				<!--<button type="button" id="btnPrint" class="btn btn-info pl-3 pr-3"><i class="fas fa-file-export"></i>&nbsp;&nbsp;Export To Excel</button>-->
				<button type="button" id="btnPrint" class="btn btn-info btn-size"><i class="fas fa-print"></i>&nbsp;&nbsp;Print </button>
				</div>
			</div>
			
			<div id="printArea">
					
					<table border=0 style="border:none;width:100%;font-weight:500;">
					<tr><th class="text-center fs-18">{{$data['project_name']??""}}</th></tr>
					<tr><th class="text-center fs-14 mb-2">SUMMATION - WEEKLY</th></tr>

					</table>
			
			@if(!empty($data['site_exp']))
					<div class="row ">
					<div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table class="tb-list" border=0 style="width:100%;font-weight:500;font-size:13px;">

							<tbody>
							
							<!-- ----------- SITE EXPENSES -------------------------------------------- -->
							
							<tr> <!--- black line ---------->
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
								<td colspan=2 style="border-top:1px solid #000;">&nbsp;</td>
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
							</tr>
							  
							<tr>
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
								<td colspan=3 style="border-bottom:none;font-size:14px;font-weight:600;"><u>SITE EXPENSES</u></td>
							  </tr>
							
							@foreach($data['site_exp'] as $key=>$r)
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">{{$data_head[$key]}}</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{ number_format($r,2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							 @endforeach
							 
							  <tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  <tr style="font-size:14px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td align="right" >TOTAL SITE EXPENSES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;;text-align:right;" width="150px;">{{ number_format($data['site_total'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  
							  
							  
							 <!-- ------------------------------------------------------------------------------ --> 
							  
							  <tr>
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
								<td colspan=3 style="border-bottom:none;font-size:14px;font-weight:600;"><u>SITE REVENUE</u></td>
							  </tr>
							  
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">PREVIOUS BALANCE</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{number_format($data['rev_bal'],2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">DEMAND</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{number_format($data['rev_demand'],2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  
							<tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  <tr style="font-size:14px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td align="right" >TOTAL SITE REVENUE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;;text-align:right;" width="150px;">{{ number_format($data['rev_total'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							
							<tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  
							<tr style="font-size:15px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;background:#e4e4e4;" align="right" >SITE BALANCE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;background:#e4e4e4;text-align:right;">{{ number_format($data['site_balance'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  
							  
							<!-- ----------- OFFICE EXPENSES -------------------------------------------- -->
							<tr><td COLSPAN=4 style="border:none">&nbsp;</td></tr>
							
							  <tr>
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
								<td colspan=3 style="border-bottom:none;font-size:14px;font-weight:600;"><u>OFFICE EXPENSES</u></td>
							  </tr>
							
							@foreach($data['office_exp'] as $key=>$r)
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">{{$data_head[$key]}}</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{ number_format($r,2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							 @endforeach

							  
							  <tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  <tr style="font-size:14px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td align="right" >TOTAL OFFICE EXPENSES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;;text-align:right;" width="150px;">{{  number_format($data['office_total'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  
							  <!-- ------------------------------------------------------------------------------ --> 
							  
							  <tr>
								<td style="border-bottom:none;width:30px;">&nbsp;</td>
								<td colspan=3 style="border-bottom:none;font-size:14px;font-weight:600;"><u>OFFICE REVENUE</u></td>
							  </tr>
							  
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">CASH</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{number_format($data['rev_cash'],2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  <tr>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
								<td style="border-bottom:1px solid #e4e4e4;">CHEQUE</td>
								<td style="border-bottom:1px solid #e4e4e4;text-align:right;">{{number_format($data['rev_cheque'],2,'.',',')??''}}</td>
								<td style="border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							  
							<tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  <tr style="font-size:14px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td align="right" >TOTAL OFFICE REVENUE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;;text-align:right;" width="150px;">{{ number_format($data['rev_off_total'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
							
							<tr style="height:15px !important;">
								<td colspan=4 style="height:15px !important;"></td>
							  </tr>
							  
							<tr style="font-size:15px;font-weight:600;">
								<td style="border-top:none;">&nbsp;</td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;background:#e4e4e4;" align="right" >OFFICE BALANCE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								<td style="border-top:1px solid #000;border-bottom:1px solid #000;background:#e4e4e4;text-align:right;">{{ number_format($data['rev_off_balance'],2,'.',',')??''}}</td>
								<td style="border-top:none;border-bottom:none; width:30px;">&nbsp;</td>
							  </tr>
	
							 <!-- ------------------------------------------------------------------------------ --> 
							  
						  </tbody>
						</table>
					</div>
					
					</div>
				</div>	
				
				@endif
				
				
			 </div>				
				
			</div>
		</div>
	</div>
			 
</div>


<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Salary Slip </h5>
			<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
		</div>
		<div class="modal-body" style="padding-bottom:.5rem;padding-left:50px;">
				
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
		</div>
		
		</div>
	</div>
</div>


@push('scripts')

<script>

$("#flt_project_id").select2();

$(document).ready(function()
{
	var mes=$('#view_message').val().split('#');
	if(mes[0]=="success")
	{	
	    toastr.success(mes[1]);
	}
	else if(mes[0]=="danger")
	{
		toastr.error(mes[1]);
	}
});

$("#btnPrint").click(function()
{
	var prtContent = document.getElementById("printArea");
	var WinPrint = window.open('Ashwaniinfra.com', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
});

   
</script>

@endpush

@endsection
