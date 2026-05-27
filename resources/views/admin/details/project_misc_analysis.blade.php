@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
table.dataTable thead th, table.dataTable tfoot th {
    font-size: 13px !important;
    font-weight: 600 !important;
}
.dataTables_scroll
{
	padding:0rem !important;
}
.dataTables_wrapper .dataTables_length {
    margin-bottom: 5px;
}

.paginate_button {
    min-width: 50px;
	min-height: 35px !important;
}	
.dataTables_wrapper .dataTables_paginate .paginate_button.previous, 
.dataTables_wrapper .dataTables_paginate .paginate_button.next {
    background: transparent !important;
    color: #3695eb !important;
    padding: 7px 20px;
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
						<h4 class="text-black fs-20">Project Misc-Expense Analysis</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btn btn-secondary btn-size pr-3 pl-3" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>

			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->

			<form method="post" action="{{ url('project-misc-analysis')}}">
			@csrf
			<div class="row mt-1 pt-2 pb-2 filter-box">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label text-right">Select Project</label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="project_id" name="project_id" required>
				<option value="">--select--</option>
				@foreach($projs as $r)
				    <option value="{{$r->id}}">{{$r->project_name}}</option>
				@endforeach
				</select>
				</div>
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Date</label>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
					<input type="date" class="form-control"  name="start_date" value="{{date('d-m-Y')}}">
				</div>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
					<input type="date" class="form-control" name="end_date" value="{{date('d-m-Y')}}">
				</div>
				
				<div class="col-lg-1 col-xl-1 col-xxl-1 pt-1">
				<button type="submit" class="btn btn-secondary btn-size" >Get</button> 
				</div>

			</div>
			</form>
	
				
			<div class="row mt-2">
				<div class="col-xl-12 col-xxl-12 col-lg-12 text-right">
				<!--<button type="button" id="btnPrint" class="btn btn-info pl-3 pr-3"><i class="fas fa-file-export"></i>&nbsp;&nbsp;Export To Excel</button>-->
				<button type="button" id="btnPrint" class="btn btn-info btn-size"><i class="fas fa-print"></i>&nbsp;&nbsp;Print </button>
				</div>
			</div>
	
	<div id="printArea">
	
			<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				
				<style>
				.st-td{
					border:1px solid #727272;
					padding-left:10px;
					padding-right:7px;
				} 
				</style>
				
					
					<div class="table-responsive">
					<table border=0 style="border:none;width:100%;font-weight:500;">
						<tbody>
						
						</tbody>
					</table>
					
					
						<table class="display" cellspacing=0 cellpadding=0 border=0 style="border:none;width:100%;font-size:13px;font-weight:500;">
							<thead>
							
							  <tr>
								@if(!empty($mdata))
									<td class="st-td" colspan=7 align="left" style="font-size:14px;">
										<label style="padding-top:10px;">Project:&nbsp;&nbsp;&nbsp;<b>{{$mdata[0]->project_name??""}}</b></label>
										@if($sdate!="" and $edate!="")
										<p style="margin-top:0px;margin-bottom:5px;"><span>Start Date:&nbsp;&nbsp;<b>{{ $sdate}}</b></span>
										<span style="margin-left:50px;">End Date:&nbsp;&nbsp;&nbsp;<b>{{ $edate }}</b><span></p>
										@endif
									</td>
								@else
									<td class="st-td" colspan=10 align="left">
										<p class="mb-0 pt-2" >Project: ...</p>
										<p><span>Start Date: ...</span>
										<span style="margin-left:50px;">End Date: ...<span></p>
									</td>
								@endif
							  </tr>
														
								<tr style="line-height:30px;">
									<th class="st-td">NO</th>
									<th class="st-td">CATERGORY_NAME</th>
									<th class="st-td">DATE</th>
									<th class="st-td">BILL_NO</th>
									<th class="st-td">ITEM/DESCRIPTION</th>
									<th class="st-td" style="text-align:right">TOTAL_AMOUNT</th>
								</tr>
							</thead>
							<tbody>
							
							@php $tot_amt=0; @endphp							
							
							@if(!empty($mdata))
							   @foreach($mdata as $key=>$r)
						   
								@php
								$tot_amt+=$r->amount;
								@endphp
						   
								<tr style="height:25px;">
									<td class="st-td">{{++$key}}</td>
									<td class="st-td">{{$r->category_name}}</td>
									<td class="st-td">{{date_create($r->invoice_date)->format('d-m-Y')}}</td>
									<td class="st-td">{{$r->invoice_no}}</td>
									<td class="st-td">{{$r->item_name}}</td>
									<td class="st-td" align="right">{{number_format($r->amount,2,'.','')}}</td>
								</tr>

							   @endforeach
							@endif
							
							</tbody>
							<tfoot>
							<tr style="font-size:15px;font-weight:600;height:25px;">
									<td colspan=5 class="st-td" align="right">Total</td>
									<td class="st-td" align="right">{{number_format($tot_amt,2,'.','')}}</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				</div>
			
			</div> <!--- end print area --->
			
			</div>
		</div>
	</div>
			 
</div>


@push('scripts')

<script>

$("#project_id").select2();

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
