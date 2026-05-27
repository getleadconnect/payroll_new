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
						<h4 class="text-black fs-20">Labour Daily Wages(<small>3 months details</small>)</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btn btn-secondary bt-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				
			<div class="row mt-1 pt-2 pb-2 filter-box">
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="flt_project_id" name="flt_project_id" required>
				<option value="">--select--</option>
				@foreach($projs as $r)
				  <option value="{{$r->id}}">{{ $r->project_name }}</option>
				@endforeach
				</select>
				</div>
				
	
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Date</label>			
				<div class="col-lg-2 col-xl-2 col-xxl-2">
				<input type="date" class="form-control ml-0 mr-0" id="flt_start_date" name="flt_start_date" >
				</div>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
				<input type="date" class="form-control ml-0 mr-0" id="flt_end_date" name="flt_end_date" >
				</div>
				
				<div class="col-lg-1 col-xl-1 col-xxl-1">
				<button type="button" id="btnFilter" class="btn btn-secondary btn-size">Get </button>
				</div>
				
			</div>

			<div class="row mt-3">
			   <div class="col-lg-12 col-xl-12 col-xxl-12">
				 <div class="table-responsive">
					<table id="datatable" class="display" style="width:150%">
							<thead>
								<tr>
									<th width="30px">No</th>
									<th width="60px">Action</th>
									<th width="70px">Date</th>
									<th width="120px">Project</th>
									<th >Code</th>
									<th width="150px">Labour</th>
									<th>N/C Wage</th>
									<th>Hrs</th>
									<th>Wage</th>
									<th>OT-N/C Rate</th>
									<th>N-OT</th>
									<th>NOT-AMT</th>
									<th>C-OT</th>
									<th>COT-AMT</th>
									<th>Total</th>
									<th>Added_by</th>
								
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

<div class="modal fade" id="basicModal-2" style="display: none;" aria-hidden="true">
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
        pageLength :50,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,

        ajax:
		{
			url:"view-all-labour-wages",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.projectId = $('#flt_project_id').val();
			   data.startDate = $('#flt_start_date').val();
			   data.endDate = $('#flt_end_date').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"80px","targets":2},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "edate" },
			{"data": "proj" },
			{"data": "lcode" },
			{"data": "lbr" },
			{"data": "nc_wage" },
			{"data": "hrs" },
			{"data": "wage",class:"text-right" },
			{"data": "otnc_rate", class:"text-right"},
			{"data": "otn_hrs", class:"text-right"},
			{"data": "otn_amt",class:"text-right" },
			{"data": "otc_hrs",class:"text-right" },
			{"data": "otc_amt",class:"text-right" },
			{"data": "twage",class:"text-right" },
			{"data": "addedby"},
			
        ],
		
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });


$("#btnFilter").click(function()
{
	table.draw();
});


$("#project_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-labours-by-project-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#labour_id").html(res);
		}
	});
	
	jQuery.ajax({
		type: "GET",
		url: "get-main-cost-center-by-project-id"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#main_cost_schedule_id").html(res);
		}
	});

});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-all-daily-wage"+"/"+id,
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
				url: "delete-all-daily-wage"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  $('#datatable').DataTable().ajax.reload(null,false);
					  alert("Daily wage successfully removed.");
				   }
				}
			});
		}
		
  });
     
  
</script>

@endpush

@endsection
