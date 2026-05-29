@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>

table tr,th,td
{
	height:30px;
	border:1px solid #e4e4e4;
	padding-left:10px;
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
						<h4 class="text-black fs-20">On Going Projects Report</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" id="btnPrint" class="btn btn-info btn-size"><i class="fas fa-print"></i>&nbsp;&nbsp;Print </button>
				</div>
			</div>

			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->

				<div class="lbr-details row mt-3 p-2">
				<div id="printArea" style="width:100%;">
				
				<style>
				@page { size: portrait; }
				table td{font-size:12px;}

				table tr,th,td
				{
					height:30px;
					border:1px solid #e4e4e4;
					padding-left:10px;
				}


				</style>

				<p >
					<b>{{$cm->company_name}}</b></br>
					{{$cm->address }}</br>
					Email:{{$cm->email}}</br>
					Ph: {{$cm->mobile }}</br>
				</p>
				
				<hr>
				
				<label style="margin-top:15px;font-weight:600;"><u>On Going Projects</u></label>
				<br>
				<br>
				
				   <table  cellpadding=0 cellspacing=0 style="width:100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Client</th>
									<th>Project</th>
									<th>Type</th>
									<th>Address</th>
									<th>Start_Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach($projs as $key=>$r)
							<tr>
								<td>{{++$key}}</td>
								<td>{{$r->client_name}}</td>
								<td>{{$r->project_name}}</td>
								<td>{{$r->project_type}}</td>
								<td>{{$r->address}}</td>
								<td>{{date_create($r->start_date)->format('d-m-Y')}}</td>
								@if($r->status==1)
									<td style="color:green;">On Going</td>
								@endif
							</tr>
							@endforeach
							
							</tbody>
				</table>

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

	
$("#btnGet").click(function()
{
	if($('#project_id').val()!="")
	{
	   table.draw();
	}
});

	
 $('#flt_labour_id').change(function ()
  {
	var cid=$(this).val();
		
				jQuery.ajax({
				type: "GET",
				url: "get-labour-detail-report"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   $("#printArea").html(res);
				}
			});
  });


$("#btnPrint").click(function()
{
	var prtContent = document.getElementById("printArea");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
});
 
  
</script>

@endpush

@endsection
