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
						<h4 class="text-black fs-20">Miscellaneous (NON-GST) Site Report</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!-- buttons here/data --------------->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
			<form method="POST" action="miscellaneous-report">
			  @csrf
				<div class="row mt-3 p-2 filter-box" >
				  <label class="col-xl-1 col-xxl-1 col-lg-1 col-form-label" >Project</label>
				  <div class="col-xl-3 col-xxl-3 col-lg-3">
					   <select class="form-control form-control-lg" id="flt_project_id" name="flt_project_id" required>
					   <option value="">--select--</option>
						@foreach($projs as $key=>$r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
						@endforeach
				    </select>
				</div>
				
				<label class="col-xl-1 col-xxl-1 col-lg-1 col-form-label" >Date</label>
				@if(Session::get('admin_role_id')==1)
				<div class="col-xl-2 col-xxl-2 col-lg-2">
					<input type="date" class="form-control" id="flt_start_date"  name="flt_start_date"  value="{{$sdate}}" required>
				</div>
				@endif
				<div class="col-xl-2 col-xxl-2 col-lg-2">
					<input type="date" class="form-control" id="flt_end_date"  name="flt_end_date"  value="{{$edate}}"required>
				</div>
				
				<div class="col-xl-1 col-xxl-1 col-lg-1">
					<button  type="submit"  class="btn btn-secondary btn-size"> Get </button>
				</div>
				
				</div>
			</form>
	
			<div class="row mt-2">
				<div class="col-xl-12 col-xxl-12 col-lg-12 text-right">
				<!--<button type="button" id="btnPrint" class="btn btn-info pl-3 pr-3"><i class="fas fa-file-export"></i>&nbsp;&nbsp;Export To Excel</button>-->
				<button type="button" id="btnPrint" class="btn btn-info btn-size"><i class="fas fa-print"></i>&nbsp;&nbsp;Print </button>
				</div>
			</div>
				
	
		  <div class="row mt-3">
			<div class="col-xl-12 col-xxl-12 col-lg-12">

				@if(!empty($data))
			
					<div class="table-responsive">

					<div id="printArea">
					
					<table border=0 style="border:none;width:100%;font-weight:500;">
					<tr><th class="text-center fs-18">{{$data[0]['project']??""}}</th></tr>
					<tr><th class="text-center fs-14 mb-2">MISCELLANEOUS (NON-GST) SITE</th></tr>
					
					@php
						$period="";
						if($sdate!="" and $edate!="")
						{
							$sd=date_create($sdate)->format('d F Y');
							$ed=date_create($edate)->format('d F Y');
							$period=$sd."&nbsp;&nbsp;To&nbsp;&nbsp;".$ed;
						}
					@endphp
					
					<tr><td class="text-center" align="center">{!! $period !!}</td></tr>
					<tr><td>&nbsp;</td></tr>
					</table>
									
					<table class="tb-list" border=0 style="width:100%;font-weight:500;font-size:12px;">
					<tr >
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;No</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Date</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Bill No</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Item/Particulars</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Description</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272;" align="left">&nbsp;&nbsp;Payment</th>
						<th style="border-top:1px solid #727272;border-bottom:1px solid #727272; text-align:right;" >Amount&nbsp;&nbsp;</th>
					</tr>
					
					<tbody>
					@if(!empty($data))
						@foreach($data as $r)
						<tr>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['no']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['inv_date']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['inv_no']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['item']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['desc']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;">{{$r['ptype']??''}}</td>
							<td style="border-bottom:1px solid #e4e4e4;" align="right">{{$r['amt']??''}}</td>
						</tr>
						@endforeach
					@endif
					</tbody>
					</table>
					<table id="tb-list" border=0 style="width:100%;font-weight:500;font-size:12px;">
					<tr>
						<th style="text-align:right;border-top:1px solid #727272;border-bottom:1px solid #727272;"><span style="margin-right:20px;">Total&nbsp;:&nbsp;</span>
						<span style="width:200px;font-size:16px;text-align:right;margin-right:5px;">{{$data[0]['netpay']??0}}</span></th>
					</tr>
					</table>
					
					</div>
					</div>
				@else
					<label style="color:#ed2b2b;width:100%;text-align:center;">{{$messg}}</label>
				@endif

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
					<h5 class="modal-title">Edit</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>

				<div class="modal-body" style="padding-bottom:.5rem;">

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
