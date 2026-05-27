@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
table.dataTable thead th, table.dataTable tfoot th {
    font-size: 12px !important;
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
						<h4 class="text-black fs-20">Labour's working reports - Weekly </h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!-- buttons here/data --------------->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				
				<div class="row mt-3 p-2 filter-box">
				  <label class="col-xl-1 col-xxl-1 col-lg-1 col-form-label" >Project</label>
				  <div class="col-xl-3 col-xxl-3 col-lg-3">
					   <select class="form-control form-control-lg" id="flt_project_id" name="flt_project_id" required>
					   <option value="">--select--</option>
						@foreach($projs as $key=>$r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
						@endforeach
				    </select>
				</div>

				
				<label class="col-xl-2 col-xxl-2 col-lg-2 col-form-label" >Date (Saturday)</label>
				<div class="col-xl-2 col-xxl-2 col-lg-2">
					<input type="date" class="form-control" id="flt_end_date"  name="flt_end_date" value="{{$sat_date}}" required>
				</div>
				
				<div class="col-xl-1 col-xxl-1 col-lg-1">
					<button  type="button" id="btnGet" class="btn btn-secondary btn-size"> Get </button>
				</div>
				
				</div>
				
				<div class="row mt-3">
				<div class="col-xl-12 col-xxl-12 col-lg-12">
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:150%">
							<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>Labour</th>
									<th>Basic Rate</th>
									<th>H/W Rate</th>
									<th>N_OT</th>
									<th>C_OT</th>
									<th>Days(N)</th>
									<th>Days (H/W)</th>
									<th>(N)OT Hrs</th>
									<th>H/W Hrs</th>
									<th>Total Wage</th>
									<th>Total OT</th>
									<th>Net Pay</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
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


var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :100,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,

        ajax:
		{
			url:"view-weekly-labour-work-reports",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.end_date = $('#flt_end_date').val();
			   data.project_id = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"70px","targets":1},
				],
	
        columns: [
			{"data": "id" },
			{"data": "edate" },
			{"data": "lbr" },
			{"data": "basic_rate" },
			{"data": "h_w_rate" },
			{"data": "normal_ot" },
			{"data": "concrete_ot" },
			{"data": "days_n" },
			{"data": "days_c" },
			
			{"data": "otn_hrs" },
			{"data": "otc_hrs" },
			
			{"data": "twage" },
			{"data": "ot_wage" },
			{"data": "gtwage" },
        ],
	
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#btnGet").click(function()
{
	if($('#project_id').val()!="")
	{
	   table.draw();
	}
});

	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-project"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });
  
$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-project"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Project successfully removed.");
				   }
				}
			});
		}
		
  });
    
  $('#datatable tbody').on( 'click', '.change-status', function ()
  {
		alert("ok");
			var cid=$(this).attr('id');
			var op=$(this).attr('data-id');
				jQuery.ajax({
				type: "GET",
				url: "change_project_status"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
					alert(res);
				   if(res==1)
				   {
					  table.draw();
				   }
				}
			});
	
  });
  
  
   $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var cid=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "project_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Project successfully Activated."); }
					  else{	alert("Project successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
