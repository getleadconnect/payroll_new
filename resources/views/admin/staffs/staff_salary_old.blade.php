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
						<h4 class="text-black fs-20">Staff Salary</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="javascript:void();" id="btnAdd" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-2"><i class="fas fa-plus"></i> Add </a>
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
									<th>Project</th>
									<th>Name</th>
									<th>Date</th>
									<th>Month</th>
									<th>Year</th>
									<th>Salary</th>
									<th>Ad.Sal</th>
									<th>Deduct</th>
									<th>Net_Salary</th>
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
					<h5 class="modal-title">Staff Salary</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<form method="POST" action="{{url('save-staff-salary')}}" enctype="multipart/form-data">
				@csrf

				<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Project</label>
					  <div class="col-lg-8 col-xl-8 col-xxl-8">
					     <select class="form-control input-default "  id="project_id" name="project_id" required>
						 <option value="">--select--</option>
						 @foreach($projs as $r)
						    <option value="{{$r->id}}" >{{$r->project_name}}</option>
						 @endforeach
						 </select>
					  </div>
					</div>
				</div>
				
				@php
				 $mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
				@endphp
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Month</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					  <select class="form-control input-default " id="month"  name="month" required>
						 <option value="">--select--</option>
						 @foreach($mon as $key=>$month)
						<option value="{{++$key}}">{{$month}}</option>
						@endforeach
					  </select>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Year</label>
						<div class="col-lg-6 col-xl-6 col-xxl-6">
						<select class="form-control input-default " id="year" name="year" required>
						 <option value="">--select--</option>
						 @php
						 $y=date('Y');
						 @endphp
						 	<option value="{{$y-1}}">{{$y-1}}</option>
							<option value="{{$y}}">{{$y}}</option>
						</select>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff Name</label>
					  <div class="col-lg-8 col-xl-8 col-xxl-8">
					    <select class="form-control input-default " id="staff_id"  name="staff_id" required>
						 <option value="">--select--</option>
						 
						 </select>
					  </div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Salary</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="number" class="form-control input-default " step="any" id="salary" name="salary" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Allowance</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="number" class="form-control input-default " step="any" id="allowance" name="allowance" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Deduction</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="number" class="form-control input-default " step="any" id="deduction"  name="deduction" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Net Salary</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="number" class="form-control input-default" step="any" id="net_salary" name="net_salary" required>
					  </div>
					</div>
				</div>

				<div class="modal-footer">
				  <button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
			      <button type="submit" class="btn btn-secondary btn-size">Save changes</button>
				</div>

				</form>
				</div>
				
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="basicModal-3" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Salary Slip </h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;padding-left:50px;">
				
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
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
			url:"view-staff-salary",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"40px","targets":0},
				  {"width":"60px","targets":1},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "name" },
			{"data": "sdate" },
			{"data": "month" },
			{"data": "year" },
			{"data": "bpay",class:"text-right" },
			{"data": "addi",class:"text-right" },
			{"data": "dedu",class:"text-right" },
			{"data": "net",class:"text-right" },
			{"data": "addedby"},

        ],
		
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

$("#staff_id").change(function()
{
	
	var sid=$(this).val();
	if(sid!="")
	{
		var mon=$("#month").val();
		var yr=$("#year").val();
		jQuery.ajax({
			type: "get",
			url: "get-staff-salary-allowance"+"/"+sid+"/"+mon+"/"+yr,
			dataType: 'html',
			//data: {staff_id:sid,month:mon,year:yr},
			success: function(res)
			{
				var dt=$.parseJSON(res);
				$("#salary").val(dt.salary.toFixed(2));
				$("#allowance").val(dt.allowance.toFixed(2));
				$("#deduction").val(dt.deduction.toFixed(2));
				$("#net_salary").val(dt.net_salary.toFixed(2));
			}
		});
	}
	else
	{
		$("#salary").val('0');
		$("#allowance").val('0');
		$("#deduction").val('0');
		$("#net_salary").val('0');
	}
	
});

$("#btnAdd").click(function()
{
	$("#project_id").val('');
	$("#staff_id").val('');
	$("#month").val('');
	$("#year").val('');
	$("#salary").val('0');
	$("#allowance").val('0');
	$("#deduction").val('0');
	$("#net_salary").val('0');
});



$('#datatable tbody').on( 'click', '.btnSlip', function ()
  {
	var id=$(this).attr('id');
		
	if(id!="")
	{
		var Result=$("#basicModal-3 .modal-body");
		
			$(this).attr('data-target','#basicModal-3');
		
				jQuery.ajax({
				type: "GET",
				url: "salary-slip"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
	}
	else
	{
		alert("Something worng, try again.")
	}
  });
  
  $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
		$(this).attr('data-target','#basicModal-1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-staff-salary"+"/"+id,
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
				url: "delete-staff-salary"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Salary details successfully removed.");
				   }
				}
			});
		}
		
  });
    
   
</script>

@endpush

@endsection
