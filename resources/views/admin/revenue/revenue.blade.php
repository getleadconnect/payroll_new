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
						<h4 class="text-black fs-20">Revenue </h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">

			<div class="row mt-1 pt-2 pb-2 filter-box">
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Select Project </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="flt_project_id" name="flt_project_id" required>
				<option value="">--select--</option>
				@foreach($projs as $r)
				    <option value="{{$r->id}}">{{$r->project_name}}</option>
				@endforeach
				</select>
				</div>

				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Select Staff </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="flt_staff_id" name="flt_staff_id" required>
				<option value="">--select--</option>
				@foreach($staff as $r)
				    <option value="{{$r->id}}">{{$r->name}}</option>
				@endforeach
				</select>
				</div>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
					<button type="button" id="btnFilter" class="btn btn-secondary btn-size">Get</button>&nbsp;&nbsp;
					<button type="button" id="btnAll" class="btn btn-info btn-size">All</button>
				</div>

			</div>
	
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->

				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
			
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:125%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Date</th>
									<th>Project</th>
									<th>Staff</th>
									<th>Voucher_No</th>
									<th>Voucher_Date</th>
									<th>Transfer</th>
									<th>Amount</th>
									<th>Ret_Amount</th>
									<th>Description</th>
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
					<h5 class="modal-title">Add</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>

				<div class="modal-body" style="padding-bottom:.5rem;">
				
	<form  method="POST" action="{{ url('save-revenue')}}" enctype="multipart/form-data">
		@csrf

			<label class="mt-2" style="font-size:13px;"><b><u>Add Revenue</u></b></label>
					
						<div class="form-group mt-2">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Revenue Type </label>
						<div class="col-lg-6 col-xl-6 col-xxl-6" style="display:flex;align-items:center;" >
							<input type="radio" name="revenue_type" style="width:25px;height:25px;" value="GET" required ><span class="pt-1 pr-3">&nbsp;&nbsp;GET</span> 
							<input type="radio" name="revenue_type" style="width:25px;height:25px;" value="RETURN" required><span class="pt-1">&nbsp;&nbsp;RETURN</span> 
						</div>
						</div>
						</div>

						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date </label>
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<input type="date" class="form-control" name="entry_date" required>
						</div>
						</div>
						</div>

						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project </label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<select type="text" class="form-control" id="project_id" name="project_id" required>
						<option value="">--select--</option>
						@foreach($projs as $r)
						  <option value="{{$r->id}}">{{ $r->project_name }}</option>
						@endforeach
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff </label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<select type="text" class="form-control" id="staff_id" name="staff_id" required>
						<option value="">--select--</option>
						@foreach($projs as $r)
						  <option value="{{$r->id}}">{{ $r->project_name }}</option>
						@endforeach
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Transfer </label>
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<select type="text" class="form-control" id="cash_cheque" name="cash_cheque" required>
						<option value="">--select--</option>
						 <option value="CASH">CASH</option>
						  <option value="CHEQUE">CHEQUE</option>
						</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Voucher No </label>
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<input type="number" step="any" class="form-control" name="voucher_no" required>
						</div>
						</div>
						</div>
						
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Voucher Date </label>
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<input type="date" class="form-control" name="voucher_date" required>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
						<div class="col-lg-5 col-xl-5 col-xxl-5">
						<input type="number" step="any"  class="form-control" name="amount" required>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description </label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<textarea class="form-control" name="description" required></textarea>
						</div>
						</div>
						</div>
												
						<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-secondary btn-size" >Save Changes</button>
						</div>

				  </form>
				
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
$("#flt_staff_id").select2();

$("#project_id").select2();
$("#staff_id").select2();

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
			url:"view-revenues",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.projectId = $('#flt_project_id').val();
			   data.staffId = $('#flt_staff_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"70px","targets":2},
				  {"width":"130px","targets":4},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "edate" },
			{"data": "pname" },
			{"data": "stname" },
			{"data": "vno" },
            {"data": "vdate" },
			{"data": "trans" },
			{"data": "inc_amt", class:"text-right"},
			{"data": "ret_amt",class:"text-right" },
			{"data": "desc"},
			{"data": "addedby"},
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });

	$("#btnFilter").click(function(){
		table.draw();
	})

	$("#btnAll").click(function()
	{
		location.reload();
	})


$("#project_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-project-staffs"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#staff_id").html(res);
		}
	});
});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-revenue"+"/"+id,
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
				url: "delete-revenue"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Revenue successfully removed.");
				   }
				}
			});
		}
		
  });
    
  
  
</script>

@endpush

@endsection
