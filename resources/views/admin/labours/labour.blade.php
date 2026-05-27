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
 
 .col-width
 {
	 min-width:100px !important;
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
						<h4 class="text-black fs-20">Labours</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('add-labour')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> Add </a>
				</div>
			</div>

			
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">

				<div class="row mt-1 pt-2 pb-2 filter-box">
				
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Select State </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_state" name="flt_state" required>
					<option value="">--select--</option>
					@foreach($state as $r)
						<option value="{{$r->state}}">{{$r->state}}</option>
					@endforeach
					</select>
					</div>
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Select District</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_district" name="flt_district" required>
						<option value="">--select--</option>
						
					</select>
					</div>
					
					<div class="col-lg-2 col-xl-2 col-xxl-2">
						<button type="button" id="btnFilter" class="btn btn-secondary btn-size">Get</button>&nbsp;&nbsp;
						<button type="button" id="btnAll" class="btn btn-info btn-size">All</button>
					</div>
			    </div>

				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="d-flex py-3 align-items-center">


					<div class="table-responsive">
						<table id="datatable" class="display" style="width:150%">
							<thead>
								<tr>
									<th>No</th>
									<th width="100px">Action</th>
									<!--<th>Id</th>-->
									<th>Status</th>
									<th>Code</th>
									<th>Name</th>
									<th>Aadhar_No</th>
									<th>Birth_Date</th>
									<th>Gender</th>
									<th>Mobile</th>
									<th>Address</th>
									<th>State</th>
									<th>District</th>
									<th>Nation</th>
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
		<div class="modal-dialog modal-lg" role="document">
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

	$("#flt_state").select2();
	$("#flt_district").select2();


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
			url:"view-labours",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.state=$("#flt_state").val();
			   data.district=$("#flt_district").val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"80px","targets":1},
				  {"width":"60px","targets":2},
				  {"width":"150px","targets":4},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false, class:"col-width" },
			//{"data": "id" },
			{"data": "status" },
			{"data": "code" },
			{"data": "name" },
			{"data": "aadhar" },
			{"data": "dob" },
			{"data": "gender" },
			{"data": "mob" },
			{"data": "add" },
			{"data": "state" },
			{"data": "dist" },
			{"data": "nation" },
			{"data": "addedby" },
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });

$("#btnFilter").click(function()
{
	table.draw();
});

$("#btnAll").click(function()
{
	location.reload();
})

 /*$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-labour"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });*/
  
$('#flt_state').change(function ()
  {
		if($(this).val()!="")
		{
			var sid=$(this).val();
				jQuery.ajax({
				type: "GET",
				url: "get-districts"+"/"+sid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   $("#flt_district").empty();
				   $("#flt_district").append(res);
				}
			});
		}
		
  });


$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var id=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-labour"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Labour successfully removed.");
				   }
				}
			});
		}
		
  });
    
  
  $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var id=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "labour_activate_deactivate"+"/"+id+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Labour successfully Activated."); }
					  else{	alert("Labour successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
