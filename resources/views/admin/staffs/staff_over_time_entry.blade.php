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
.div-filter{ display:none; }
.div-show{	display:block; }
.div-hide{ display:none;}

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
						<h4 class="text-black fs-20">Staff Over Time Entries</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btnAdd btn btn-secondary btn-size" data-toggle="modal" ><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			<label class="mt-2 fs-13" ><b><u>Add OT details</u></b></label>
			
			<form id="myOverTime" method="POST" >  <!-- action="{{url('save-over-time')}}" -->
			@csrf
			 
			 <div class="row mt-2 mr-3"> 
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project</label>
				<div class="col-lg-4 colxl-4 col-xxl-4">
					  <select class="form-control" id="project_id" name="project_id" id="project_id">
						<option value="">--select--</option>
						@foreach($projs as $r)
						   <option value="{{$r->id}}">{{$r->project_name}}</option>
						@endforeach
					 </select>
				</div>
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Staff</label>
				<div class="col-lg-3 colxl-3 col-xxl-3">
				
					<select class="form-control" id="staff_id" name="staff_id" id="staff_id">
					  <option value="">--select--</option>
						
					  </select>
				</div>
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Date</label>
				<div class="col-lg-2 colxl-2 col-xxl-2">
						<input type="date" class="form-control" style="width:160px;" id="ot_date" name="ot_date" value="{{date('Y-m-d')}}"   required>
				    </div>

			</div>
			
			<div class="row mt-2 mr-3"> 

				<label class="col-lg-1 col-xl-1 col-xxl-1 pr-0 col-form-label text-right">Start Time</label>
				<div class="col-lg-2 colxl-2 col-xxl-2">
					<input type="time" class="form-control" id="start_time" name="start_time" >
				</div>
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 pr-0 col-form-label">End Time</label>
				<div class="col-lg-2 colxl-2 col-xxl-2">
					<input type="time" step="any" class="form-control" id="end_time" name="end_time">
				</div>
			 
				<label class="col-lg-2 col-xl-2 col-xxl-2 pr-0 col-form-label"><input type="checkbox" id="sunday_check" name="sunday_check"><span class="pl-3">Sunday Over Time<span></label>
				<div class="col-lg-2 colxl-2 col-xxl-2">
					<input type="number" class="form-control" step="any" id="sunday_ot" name="sunday_ot" style="margin-left:25px;width:100px" >
				</div>

				<div class="col-lg-2 col-xl-2 col-xxl-2 pt-1">
				<button type="submit" class="btn btn-secondary  btn-size"> Submit</button>
				</div>

			</div>
			
			</form>
			
			
		<!---- Filter --------------------------->
		<hr>
		<button id="btnFilter" class="btn btn-secondary btn-xs btn-sm" style="padding:2px 15px;">Filter</button>
			
			<div class="div-filter">
			   <div class="row mt-2 pt-2" style="background:#bfcedd;padding:3px 5px;">
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Staff</label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select class="form-control" name="flt_staff_id" id="flt_staff_id">
				<option value="">--select--</option>
				@foreach($staffs as $r)
				   <option value="{{$r->id}}">{{$r->name}}</option>
				@endforeach
				</select>
				</div>
				
				@php
					$mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
				@endphp
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Month</label>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
				<select class="form-control" name="flt_month" id="flt_month">
				<option value="">--select--</option>
				@foreach($mon as $key=>$r)
				   <option value="{{++$key}}">{{$r}}</option>
				@endforeach
				</select>
				</div>
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Year</label>
				<div class="col-lg-1 col-xl-1 col-xxl-1">
				<input type="number" class="form-control" name="flt_year" id="flt_year" value="{{date('Y')}}">
				</div>
				
				<div class="col-lg-2 col-xl-2 col-xxl-2 " >
				<button id="btnGet" class="btn btn-secondary btn-xs mt-1">Get</button>
				</div>
			</div>
			</div>

		<!----------------------------------------->

			<div class="row mt-3"> 
			<div class="col-lg-12 colxl-12 col-xxl-12">
				
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Project</th>
									<th>Staff</th>
									<th>Date</th>
									<th>Start_Time</th>
									<th>End_Time</th>
									<th>N_OT hrs</th>
									<th>Sun_OT</th>
									<th>N_OT Amt</th>
									<th>S_OT Amt</th>
									<th>Added_By</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
							<tfoot style="border-bottom:1px solid #000;">
								<tr>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th>&nbsp;</th>
									<th style="padding-right:8px;">&nbsp;</th>
									<th style="padding-right:8px;">&nbsp;</th>
									<th>&nbsp;</th>
								</tr>
							</tfoot>
							
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
	<div class="modal-dialog " role="document">
	  <div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title">Edit</h5>
		<button type="button" class="close" data-dismiss="modal"><span>×</span></button>
		</div>
	<div class="modal-body" style="padding-bottom:.5rem;">
			
			
	</div>
	
	</div>
	</div>
</div>
</div>

@push('scripts')

<script>

$("#project_id").select2();
$("#staff_id").select2();
$("#flt_staff_id").select2();

$("#btnFilter").click(function()
{
	$("div .div-filter").toggle()
});


$(document).ready(function()
{
	
	$("#sunday_ot").prop('disabled',true);

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


$("#sunday_check").click(function()
{
	if($(this).is(':checked'))
	{
		$("#sunday_ot").prop('disabled',false);
		$("#sunday_ot").prop('required',true);
		$("#start_time").prop('required',false);
		$("#end_time").prop('required',false);
		$("#start_time").val('');
		$("#end_time").val('');
	}
	else
	{
		$("#sunday_ot").prop('disabled',true);
		$("#sunday_ot").prop('required',false);
		$("#start_time").prop('required',true);
		$("#end_time").prop('required',true);
	}
	
});

$("#btnGet").click(function()
{
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
			url:"view-staff-over-times",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.byStaff_id = $('#flt_staff_id').val();
			   data.byMonth = $('#flt_month').val();
			   data.byYear = $('#flt_year').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"170px","targets":[2,3]},
				  {"width":"90px","targets":4},
				  ],
	
        columns: [
            {"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "sname" },
			{"data": "odate",},
			{"data": "stime",},
			{"data": "etime",},
			{"data": "n_ot_hrs",class:"text-right"},
			{"data": "s_ot_hrs",class:"text-right"},
			{"data": "n_ot_amt", class:"text-right" },
			{"data": "s_ot_amt", class:"text-right" },
			{"data": "addedby"},
        ],
		
		"footerCallback": function (row, data, start, end, display) {                

			var api = this.api(), data;
				
               var nTotal = api.column(9).data().reduce( function (a, b) {
                    return parseFloat(a) + parseFloat(b); }, 0 );
				
			   var sTotal = api.column(10).data().reduce( function (a, b) {
                    return parseFloat(a) + parseFloat(b); }, 0 );
				
				$( api.column(8).footer()).html('Total');
				$( api.column(9).footer()).html(nTotal.toFixed(2));
				$( api.column(10).footer()).html(sTotal.toFixed(2));
			},

		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
    });
	
	$("#project_id").change(function()
	{
		var pid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-project-staffs"+"/"+pid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#staff_id").html(res);
			}
		});
	});
	
$("form#myOverTime").submit(function(e)
{
	e.preventDefault();    
	
	  var formData = new FormData(this);
		
       $.ajax({
          url: "save-over-time",
          type: 'post',
          data: formData,
          success: function (res) 
		  {
			if(res==1)
			{
			    toastr.success("Over time details Successfully added");
				$("#project_id").val('');
				$("#staff_id").val('');
				$("#normal_ot").val(0);
				$("#sunday_ot").val(0);
				$("#ot_date").val("{{date('Y-m-d')}}");
				$("#start_time").val('');
				$("#end_time").val('');
				table.draw();
			}
			else if(res==2)
			{
				toastr.error("Staff overtime already added.");
			}
			else
			{
				toastr.error("somthing wrong, try again.");
			}
          },
		cache: false,
		contentType: false,
		processData: false
	 });
});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-staff-over-time"+"/"+cid,
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
			var sot_id=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-staff-over-time"+"/"+sot_id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Staff over time details removed.");
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
