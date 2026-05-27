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
						<h4 class="text-black fs-20">Staff Salary</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" id="btnFilter" class="btn btn-secondary btn-xs btn-sm" style="padding:5px 15px;"><i class="fas fa-filter"></i> Filter</button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
			  <form method="POST" action="{{url('staff-salary-report')}}" enctype="multipart/form-data">
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
				   
				   <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Month</label>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
					
					@php
						$mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
						@endphp

					  <select class="form-control " id="flt_month"  name="flt_month" required>
						 <option value="">--select--</option>
						 @foreach($mon as $key=>$month)
						<option value="{{++$key}}">{{$month}}</option>
						@endforeach
					  </select>
					</div>

					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Year</label>
				   <div class="col-lg-2 col-xl-2 col-xxl-2">
						<input type="number" class="form-control" id="flt_year" name="flt_year" value="{{date('Y')}}" required>
				   </div>

				    <div class="col-lg-1 col-xl-1 col-xxl-1">
					     <button type="submit" class="btn btn-secondary btn-size" style="margin-top:3px;" >Get</button>
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
					<tr><th class="text-center fs-18">{{$data[0]['project']??""}}</th></tr>
					<tr><th class="text-center fs-14 mb-2">STAFF SALARY REPORT</th></tr>
					
					@php
						$dt="";
						if($mdate!="")
						{
							$dt=date_create($mdate)->format('F - Y');
						}
					@endphp
					
					<tr><td class="text-center" align="center" style="font-size:14px;">Salary Details : {!! $dt !!} </td></tr>
					<tr><td>&nbsp;</td></tr>
					</table>
			
					<div class="row ">
					<div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table class="tb-list" border=0 style="width:100%;font-weight:500;font-size:12px;">
							<thead>

								<tr >
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;No</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Staff Name</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;">&nbsp;&nbsp;Salary</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;">&nbsp;&nbsp;Mon/Year</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;OT/Rate</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;Sun/Rate</th>
									<!--<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;Ot/Hrs</th>-->
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;OT/Amt</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;Sun/Hrs</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;text-align:right;" >&nbsp;&nbsp;Sun/Amt</th>
									<th style="border-top:1px solid #727272;border-bottom:1px solid #727272; text-align:right;" >Total Amt.&nbsp;&nbsp;</th>
								</tr>

						  </thead>
							<tbody>
							@foreach($data as $r)
							  <tr>
								<td style="border-bottom:1px solid #e4e4e4;">{{$r['no']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;">{{$r['sname']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['sal']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['myr']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['nrate']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['srate']??''}}</td>
								{{--<td style="border-bottom:1px solid #e4e4e4;" align="center">{{$r['n_ot']??''}}</td>--}}
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['n_amt']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="center">{{$r['s_ot']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['s_amt']??''}}</td>
								<td style="border-bottom:1px solid #e4e4e4;width:120px;" align="right">{{$r['nsal']??''}}</td>
							  </tr>
							 @endforeach
						  </tbody>
						  
						  <tfoot style="font-size:13px !important;">
						  <tr>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;">&nbsp;</td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;">&nbsp;</td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;" align="right"><b>{{$data[0]['total_sal']??''}}</b></td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;">&nbsp;</td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;" align="right">&nbsp;</td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;" align="right">&nbsp;</td>
								{{--<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;">&nbsp;</td>--}}
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;" align="right"><b>{{$data[0]['total_namt']??''}}</b></td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;">&nbsp;</td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;" align="right"><b>{{$data[0]['total_samt']??''}}</b></td>
								<td style="border-top:1px solid #4a4949;border-bottom:1px solid #4a4949;width:120px;" align="right"><b>{{$data[0]['total_salary']??''}}</b></td>
						  </tr>
						  </tfoot>

						</table>
					</div>
					
					</div>
				</div>	
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
