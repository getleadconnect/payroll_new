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
						<h4 class="text-black fs-20">Projects</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="d-flex py-3 align-items-center">

					<div class="table-responsive">
						<table id="datatable" class="display" style="width:120%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Status</th>
									<th>Project Status</th>
									<!--<th>Company</th>-->
									<th>Client</th>
									<th>Project</th>
									<th>Address</th>
									<th>Description</th>
									<th>Cost</th>
									<th>Dates</th>
									<th>Added_By</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div><!-- d-flex end ------->
				
			</div>
		</div>
	</div>
			 
</div>

	<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Project</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<form method="POST" action="{{url('save-project')}}" enctype="multipart/form-data">
				@csrf
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				  <input type="hidden" name="company_id" value="{{$comp->id}}" required>
					   
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Client</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					 
					 <select class="form-control form-control-lg" name="client_id" required>
					   <option value="">--select--</option>
					   @foreach($client as $r)
					    <option value="{{$r->id}}">{{$r->client_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Type</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" name="project_type_id" required>
					   <option value="">--select--</option>
					   @foreach($ptype as $r)
					    <option value="{{$r->id}}">{{$r->project_type}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Name</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <input type="text" class="form-control input-default "  name="project_name" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Address</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control" name="address"  required></textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control" name="description"  required></textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Cost</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="number" class="form-control input-default "  name="cost" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Start Date</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="date" class="form-control input-default "  name="start_date" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Finish Date</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="date" class="form-control input-default "  name="finish_date" required>
					  </div>
					</div>
				</div>
	
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
				</div>
				</form>
				
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
			url:"view-projects",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				   {"width":"80px","targets":1},
				  {"width":"80px","targets":[3,9]},
				  {"width":"120px","targets":[4,5]},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
			{"data": "pstatus" },
			//{"data": "comp" },
			{"data": "client" },
			{"data": "proj" },
			{"data": "add" },
			{"data": "desc" },
			{"data": "cost" },
			{"data": "sdate" },
			{"data": "addedby" },

        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
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
			var cid=$(this).attr('id');
			var op=$(this).attr('data-id');
			
			jQuery.ajax({
				type: "GET",
				url: "change_project_status"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					alert("Project status successfully changed!");
				   	table.draw();
				   }
				}
			});
	
  });
  
  
  $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this project?"))
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
