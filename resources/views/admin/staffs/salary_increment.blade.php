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
						<h4 class="text-black fs-20">Salary Increment</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btnAdd btn btn-secondary btn-size" data-toggle="modal" ><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			<div class="row mt-2" style="background:#bfcedd;padding:3px 5px;">
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" >Staff</label>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<select class="form-control" name="flt_staff_id" id="flt_staff_id">
				<option value="">--select--</option>
				@foreach($staffs as $r)
				   <option value="{{$r->id}}">{{$r->name}}</option>
				@endforeach
				</select>
				</div>
				<div class="col-lg-1 col-xl-1 col-xxl-1 text-right" >
				<button id="btnAll" class="btn btn-secondary btn-size">Get All</button>
				</div>
			</div>
			
				<div class="d-flex py-3 align-items-center"> 
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Date</th>
									<th width="120px">Name</th>
									<th>Role</th>
									<th>Old_Salary</th>
									<th width="70px">Salary</th>
									<th width="50px">(%)</th>
									<th>Increment</th>
									<th>OT_Rate</th>
									<th>Sunday_Rate</th>
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
					<h5 class="modal-title">Add Increment</h5>
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
	
$("#flt_staff_id").select2();

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

$("#btnAll").click(function()
{
	$("#flt_staff_id").val('');
	table.draw();
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
			url:"view-salary-increments",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchByStaff = $('#flt_staff_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"70px","targets":2},
				  {"width":"200px","targets":3},
 
				],
	
        columns: [
            {"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "sdt" },
			{"data": "name" },
			{"data": "role" },
			{"data": "old_sal", class:"text-right"},
			{"data": "salary", class:"text-right" },
			{"data": "per", class:"text-right" },
			{"data": "inc", class:"text-right" },
			{"data": "otr", class:"text-right" },
			{"data": "srate", class:"text-right" },
			{"data": "addedby"},
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
	$("#flt_staff_id").change(function()
	{
		table.draw();
	});
	
	
    $('.btnAdd').click(function ()
    {
	
		var Result=$("#basicModal-1 .modal-body");
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "add-salary-increment",
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-salary-increment"+"/"+cid,
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
			var staff_id=$(this).attr('data-val');
				jQuery.ajax({
				type: "GET",
				url: "delete-salary-incrment"+"/"+cid+"/"+staff_id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Salary Increment successfully removed.");
				   }
				}
			});
		}
		
  });
  
  
   $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var cid=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "client_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Client successfully Activated."); }
					  else{	alert("Client successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
