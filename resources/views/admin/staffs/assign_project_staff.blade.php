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
						<h4 class="text-black fs-20">Assign Project Staffs</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!-- <a href="#" id="btnAdd" class="btn btn-secondary btn-size"><i class="fas fa-plus"></i> Add </a> -->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				
				<label class="mt-2" style="font-size:13px;"> <b><u>Assign staff</u></b></label>
				
				<form method="POST" action="{{url('assign-project-staff')}}" enctype="multi-part/form-data">
				@csrf
				
				<div class="row pt-2 pb-2">
				  	  <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right" >Project</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <select class="form-control input-default "  id="project_id" name="project_id" required>
						 <option value="">--select--</option>
						 @foreach($projs as $r)
						    <option value="{{$r->id}}" >{{$r->project_name}}</option>
						 @endforeach
						 </select>
					  </div>
					  
					  <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right" >Staff</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <select class="form-control input-default "  id="staff_id" name="staff_id" required>
						 <option value="">--select--</option>
						 @foreach($stfs as $r)
						    <option value="{{$r->id}}" >{{$r->name}}</option>
						 @endforeach
						 </select>
					  </div>
					  
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <button type="submit" class="btn btn-secondary  btn-size">Assign</button>
					  </div>
				</div>
				</form>
				
				
				
				 <label style="position:relative;z-index:999999;top:12px;"><b><u>Filter</u></b></label>
					<div class="row  pt-2 pb-2 filter-box">
						<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right" >Project</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <select class="form-control input-default "  id="flt_project_id" name="flt_project_id" required>
						 <option value="">--select--</option>
						 @foreach($projs as $r)
						    <option value="{{$r->id}}" >{{$r->project_name}}</option>
						 @endforeach
						 </select>
					  </div>
					</div>
				
					<div class="row mt-3">
						<div class="col-lg-12 col-xl-12 col-xxl-12" >
							<div class="table-responsive">
								<table id="datatable" class="display" style="width:100%">
									<thead>
										<tr>

											<th>No</th>
											<th>Action</th>
											<th>Project</th>
											<th>Staff-Name</th>
											<th>Period_From</th>
											<th>Period_To</th>
											<th>Status</th>
											<th>Added_By</th>
											
										</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
							</div>
				  </div>
				</div>
				<!--</div> d-flex end ------->
				
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

$("#staff_id").select2();
$("#project_id").select2();
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
			url:"view-project-staffs",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.project_id = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"40px","targets":0},
				  {"width":"80px","targets":1},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "sname" },
			{"data": "sdate" },
			{"data": "edate" },
			{"data": "status" },
			{"data": "addedby" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#flt_project_id").change(function()
{
	table.draw();
});


$('#datatable tbody').on( 'click', '.btnRelease', function ()
  {
	var id=$(this).attr('id');
	if(id!="")
	{
		if(confirm("Are you sure, Release staff from this project."))
		{			
			jQuery.ajax({
			  type: "GET",
				url: "release-staff"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res!=0)
				   {
					   alert("Staff successfully released.");
					   table.draw();
				   }
				   else
				   {
					   alert("Something wrong, Try again.");
				   }
				}
			});
		}
	}
	else
	{
		alert("Something worng, try again.")
	}
  });

$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-project-staff"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Staff details successfully removed.");
				   }
				}
			});
		}
		
  });
    
   
</script>

@endpush

@endsection
