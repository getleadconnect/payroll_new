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

#addSalary
{
	display:none;
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
					<!--<a href="javascript:void();" id="btnAdd" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-2"><i class="fas fa-plus"></i> Add </a>-->
					<button type="button" id="btnAdd" class="btn btn-secondary btn-xs btn-sm" style="padding:5px 15px;"><i class="fas fa-plus"></i> Add</button>
					<button type="button" id="btnFilter" class="btn btn-secondary btn-xs btn-sm" style="padding:5px 15px;"><i class="fas fa-filter"></i> Filter</button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
			
			
			<div id="addSalary">
			
				<label class="mt-2 mb-2" style="font-size:12px;"><u><b>Add Staff Salary</b></u> </label>
				
				<form method="POST" action="{{url('save-staff-salary')}}" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group">
				<div class="row">
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<label>Project</label>
					     <select class="form-control input-default "  id="project_id" name="project_id" required>
						 <option value="">--select--</option>
						 @foreach($projs as $r)
						    <option value="{{$r->id}}" >{{$r->project_name}}</option>
						 @endforeach
						 </select>
					</div>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
					
					@php
						$mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
						@endphp
					<label>Month</label>
					  <select class="form-control input-default " id="month"  name="month" required>
						 <option value="">--select--</option>
						 @foreach($mon as $key=>$month)
						<option value="{{++$key}}">{{$month}}</option>
						@endforeach
					  </select>
					</div>

				   <div class="col-lg-2 col-xl-2 col-xxl-2">
						<label >Year</label>
						<input type="number" class="form-control" name="year" id="year" value="{{date('Y')}}" min="{{date('Y')}}" required> 
				   </div>
				   
				   <div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>Staff Name</label>
					    <select class="form-control input-default " id="staff_id"  name="staff_id" required>
						 <option value="">--select--</option>
						 
						 </select>
				   </div>
				    <div class="col-lg-2 col-xl-2 col-xxl-2">
						<label >Salary Date</label>
					     <input type="date" class="form-control input-default " id="entry_date" name="entry_date"  required>
				   </div>

				</div>
				</div>
				
				<div class="row">
				
				 <div class="col-lg-2 col-xl-2 col-xxl-2">
						<label >Salary</label>
					     <input type="number" class="form-control input-default " step="any" id="salary" name="salary"  required>
				 </div>
				
				
				 <div class="col-lg-3 col-xl-3 col-xxl-3">
						<div class="row">
						   <div class="col-lg-6 col-xl-6 col-xxl-6">
								<label >N-OT-Hrs</label>
								<input type="text" class="form-control" id="normal_ot" name="normal_ot" value="0" required>
							</div>
							
							<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label >Nor-OT-Amt</label>
								<input type="number" class="form-control" step="any" id="normal_amt" name="normal_amt" value="0" required>
						   </div>
					   </div>
					 </div>

					<div class="col-lg-7 col-xl-7 col-xxl-7">
					
					 <div class="row"> 
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
							<label >Sun-OT</label>
							<input type="number" class="form-control input-default" step="any" id="sunday_ot" name="sunday_ot" value="0" required>
					   </div>
					   
						<div class="col-lg-2 col-xl-2 col-xxl-2">
							<label >Sun-Amt</label>
							<input type="number" class="form-control input-default pr-0" step="any" id="sunday_amt" name="sunday_amt" value="0" required>
					   </div>
					   
					   <div class="col-lg-2 col-xl-2 col-xxl-2">
							<label >Leave</label>
							<input type="number" class="form-control input-default" step="any" id="leave" name="leave" value="0" required>
					   </div>
					   
						<div class="col-lg-3 col-xl-3 col-xxl-3">
							<label >Leave_Amt</label>
							<input type="number" class="form-control input-default pr-0" step="any" id="leave_amt" name="leave_amt" value="0" required>
					   </div>
					   
					   
					   <div class="col-lg-3 col-xl-3 col-xxl-3">
							<label >Net Salary</label>
							<input type="number" class="form-control input-default" step="any" id="net_salary" name="net_salary"  required>
					   </div>

					</div>

					  <div class="form-group text-right">
							<button type="submit" class="btn btn-secondary btn-size" style="margin-top:23px;">Submit</button>
					   </div>
				
				</div>
				</div>

				</form>
				
				<hr>	
		</div>
		
<!----------------------------FILTER--------------------------------------------------------------->				
			<div id="filterSalary">
			<label class="fs-12"><b><u>Filter:</u></b></label>
								
				<div class="form-group" style="background:#b7d3ed;padding:5px;">
				<div class="row">
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Staff</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					 <select class="form-control input-default " id="flt_staff_id"  name="flt_staff_id" required>
						 <option value="">--select--</option>
						  @foreach($staffs as $key=>$r)
							<option value="{{$r->id}}">{{$r->name}}</option>
						  @endforeach
						 </select>
				   </div>
				   
				   <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Month</label>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
					@php
						$mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
						@endphp
					
					  <select class="form-control input-default " id="flt_month"  name="flt_month" required>
						 <option value="">--select--</option>
						 @foreach($mon as $key=>$month)
						<option value="{{++$key}}">{{$month}}</option>
						@endforeach
					  </select>
					</div>
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right" >Year</label>
				    <div class="col-lg-2 col-xl-2 col-xxl-2">
						<input type="number" class="form-control" id="flt_year" name="flt_year" value="{{date('Y')}}" min="{{date('Y')}}" required> 
				    </div>
				   
					<div class="col-lg-1 col-xl-1 col-xxl-1">
						<button type="button" id="btnGetFilter" class="btn btn-secondary btn-sm btn-xs btn-size mt-1">Get</button>
				   </div>

				</div>
				</div>

				
				<hr>	
		</div>
	<!---------------------------------------------->	

	<!--- staff salry list --------------------------------------------->
			
					<div class="row mt-3">
					<div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table id="datatable" class="display" style="width:150%">
							<thead>
								<tr>
									<th width="30px">No</th>
									<th>Action</th>
									<th>Project</th>
									<th>Name</th>
									<th>Date</th>
									<th>Month</th>
									<th>Year</th>
									<th>Salary</th>
									<th>N_Rate</th>
									<th>S_Rate</th>
									<th>N_OT</th>
									<th>N_Amt</th>
									<th>S_OT</th>
									<th>S_Amt</th>
									<th>leave</th>
									<th>Leave_Amt</th>
									<th>Net_Salary</th>
									<th>Added_By</th>
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

$("#project_id").select2();
$("#flt_staff_id").select2();
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


$("#btnAdd").click(function()
{
	$("#addSalary").toggle();
	$("#filterSalary").hide();
})

$("#btnFilter").click(function()
{
	$("#filterSalary").toggle();
	$("#addSalary").hide();
})

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
			   data.ByStaffId = $('#flt_staff_id').val();
			   data.ByMonth = $('#flt_month').val();
			   data.ByYear = $('#flt_year').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"30px","targets":0},
				  {"width":"90px","targets":1},
				  {"width":"120px","targets":[2,3]},
				  {"width":"70px","targets":4},
				  
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "name" },
			{"data": "sdate" },
			{"data": "month" },
			{"data": "year" },
			{"data": "sal" },
			{"data": "nrate",class:"text-right" },
			{"data": "srate",class:"text-right" },
			{"data": "nhrs",class:"text-right" },
			{"data": "namt",class:"text-right" },
			{"data": "shrs",class:"text-right" },
			{"data": "samt",class:"text-right" },
			{"data": "leave",class:"text-right" },
			{"data": "lamt",class:"text-right" },
			{"data": "net",class:"text-right" },
			{"data": "addedby"},

        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });

$("#btnGetFilter").click(function()
{
	table.draw();
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
	var mon=$("#month").val();
	var yr=$("#year").val();
		
	if(sid!="" && mon!="" && yr!="")
	{
		jQuery.ajax({
			type: "get",
			url: "get-staff-salary"+"/"+sid+"/"+mon+"/"+yr,
			dataType: 'html',
			//data: {staff_id:sid,month:mon,year:yr},
			success: function(res)
			{
				var sdt=JSON.parse(res);
				$("#salary").val(sdt.salary);
				$("#normal_ot").val(sdt.normal_hrs);
				$("#sunday_ot").val(sdt.sunday_ot);
				$("#normal_amt").val(sdt.normal_amt);
				$("#sunday_amt").val(sdt.sunday_amt);
			}
		});
	}
	else
	{
		$("#salary").val('0');
		$("#normal_ot").val('0');
		$("#sunday_ot").val('0');
		$("#normal_amt").val('0');
		$("#sunday_amt").val('0');
		$("#net_salary").val('0');
	}
	
});



function get_net_amount()
{
	var leave=$("#leave").val();
	var sal=$("#salary").val();
    var n_ot=$("#normal_amt").val();
    var s_ot=$("#sunday_amt").val();
	
	if(sal!="" && n_ot!="" && s_ot!="")
	{
		if(leave!=0)
		{
		   lamt=(parseFloat(sal)/30)*parseInt(leave);
		}
		else
		{
			lamt=0;
		}
		
		var nsal=(parseFloat(sal)+parseFloat(n_ot)+parseFloat(s_ot))-lamt;
		$("#net_salary").val(nsal.toFixed(2));
		$("#leave_amt").val(lamt.toFixed(2));
	}
	else
	{
		$("#net_salary").val('0');
	}
}

$("#leave").click(function()
{
	get_net_amount();
});

$("#leave").keyup(function()
{
	get_net_amount();
});

$("#net_salary").click(function()
{
   get_net_amount();
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
