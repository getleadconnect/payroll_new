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

.form--control {
    padding: 0.1rem 0.55rem !important;
    line-height: 1.25 !important;
	height:35px;
	width:100%;
	border:none;
}
.pad-l
{
	font-size:13px !important;
	padding-left:15px;
}

.btn-add-remove
{
	width: 23px !important;
    height: 23px !important;
    padding: 0px !important;
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
						<h4 class="text-black fs-20">Labour Daily Wages </h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btn btn-secondary bt-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			
			<!-- to store dropdown value for remove selected items -------------------------- -->
			<select  style="display:none;" class=" form--control labour_id" id="lbr_temp_id" name="labour_temp_id[]" required>
			<option value="">--select--</option>
			</select>
			<!-- ------------------------------------------------------------------------------ -->
			
			
			<form  method="POST" action="{{ url('save-daily-wage')}}" enctype="multipart/form-data">
				@csrf

			    <label class="mt-2" style="font-size:13px;"><b><u>Add Daily Wages</u></b></label>
					<div class="row mt-2">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Project </label>
						<select type="text" class="form-control" id="project_id" name="project_id" required>
						<option value="">--select--</option>
						@foreach($projs as $r)
						  <option value="{{$r->id}}">{{ $r->project_name }}</option>
						@endforeach
						</select>
						</div>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Floor</label> <!-- main cost Schedule table --->
						<select type="text" class="form-control" id="floor_no"  name="floor_no" required>
						<option value="">--select--</option>
						@foreach($flnos as $r)
						  <option value="{{$r->id}}">{{ $r->floor_no }}</option>
						@endforeach
						</select>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Main Cost Center</label> <!-- main cost Schedule table --->
						<select type="text" class="form-control" id="main_cost_center_id"  name="main_cost_center_id" required >
						<option value="">--select--</option>
						</select>
						</div>
					</div>
		
					<div class="work-entry mt-2">
					
					<table id="daily_work" style="width:100%;" border=1> 
					<!-- heading ----------------- -->
					<tr style="height:30px;"><td class="pad-l" ><b>Labour</b></td>
					<td width="170px;" class="pad-l"><b>Work Type</b></td>
					<td class="pad-l"><b>Working Hrs</b></td>
					<td class="pad-l"><b>Over Time</b></td><td></td>
					<!-- ---------------------------->
					 <tr>
						<td>
							<select  class=" form--control labour_id" id="lbr_id" name="labour_id[]" required>
							<option value="">--select--</option>
							
							</select>
						</td>
						<td>
							<select  class=" form--control work_type" name="work_type[]" required>
							<option value="">--select--</option>
							<option value="1" selected>Normal</option>
							<option value="2">Concreate</option>
							</select>
						</td>
												
						<td width="150px;">
						  <select  class=" form--control working_hrs" name="working_hrs[]" required>
							<option value="">--select--</option>
							<option value="0">Overtime Only</option>
							<option value="8" selected>Full Day(8hrs)</option>
							<option value="4">Half Day(4hrs)</option>
							</select>
						</td>
						<td width="130px;">
						  <input type="number" class="form--control over_time text-right" step="any"  min="0" max="8" name="over_time[]"  value="0" required>
						</td>
						<td width="60px;" align="center">
						  <button type="button" class="btnLbrAdd btn btn-secondary btn-add-remove"><i class="fa fa-plus"></i></button>
						</td>
					  <tr>
					  </table>

					</div>
					
					<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
						<button type="submit" style="margin-top:25px;" class="btn btn-secondary btn-size">Submit</button>
						</div>
					</div>
				</form>
			
			<hr>

			<label><b><u>Today Entries</u></b></label>
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:130%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Date</th>
									<th>Project</th>
									<th>Code</th>
									<th>Labour</th>
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

$("#project_id").select2();
$("#floor_no").select2();
$("#main_cost_center_id").select2();


$(".btnLbrAdd").prop('disabled',true);

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
			url:"view-labour-daily-wages",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"40px","targets":1},
				  {"width":"60px","targets":2},
				  {"width":"150px","targets":5},
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
		   $("#lbr_id").html(res);
		   $("#lbr_temp_id").html(res);
		   $("#labours").val(res);
		   
		}
	});

});


$("#floor_no").change(function()
{

var fid=$(this).val();
var pid=$("#project_id").val();
	
	jQuery.ajax({
		type: "GET",
		url: "get-main-cost-center-by-project-id"+"/"+pid+"/"+fid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#main_cost_center_id").html(res);
		}
	});

});

$(".labour_id").change(function()
{
	if($(this).val()!="")
	{
		$(this).closest('tr').find(".btnLbrAdd").prop('disabled',false);
	}
	else
	{
		$(this).closest('tr').find(".btnLbrAdd").prop('disabled',true);
	}
});


function add_labour()
{
	var lbrs=$("#lbr_temp_id").html();
	
	var dat='<tr><td>'
		+'<select type="text" class="form--control labour_id"  name="labour_id[]" required>'
		+lbrs
		+'</select>'
	    +'</td>'
	    +'<td>'
		+'<select type="text" class="form--control work_type" name="work_type[]" required>'
		+'<option value="">--select--</option>'
		+'<option value="1" selected>Normal</option>'
		+'<option value="2">Concreate</option>'
		+'</select>'
		+'</td>'
		+'<td width="130px;">'
		+'<select  class="form--control working_hrs" name="working_hrs[]" required>'
		+'<option value="">--select--</option>'
		+'<option value="0">Overtime Only</option>'
		+'<option value="8" selected>Full Day(8hrs)</option>'
		+'<option value="4">Half Day(4hrs)</option>'
		+'</select>'
		+'</td>'
		+'<td width="130px;">'
		+'<input type="number" class="form--control text-right over_time" name="over_time[]" min="0" max="8" value="0" required >'
		+'</td>'
		+'<td width="60px;" align="center">'
		+'<button type="button" class="btnLbrAdd btn btn-secondary btn-add-remove"><i class="fa fa-plus"></i></button>'
		+'&nbsp;<button type="button" class="btnLbrDel btn btn-danger btn-add-remove"><i class="fa fa-minus"></i></button>'
		+'</td>'
		+'<tr>';

		return dat;
}

$(document).on('change',".working_hrs",function()
{
	$(this).closest("tr").find('.over_time').val('');
});



$(document).on('click',".btnLbrAdd",function()
{
	var lid=$(this).closest("tr").find('.labour_id').val();
	var wt=$(this).closest("tr").find('.work_type').val();
	var wh=$(this).closest("tr").find('.working_hrs').val();
	var ot=$(this).closest("tr").find('.over_time').val();
	
	if(wh==0 && ot<=0)
	{
		alert("Over time value is invalid!");
		$(this).closest('tr').find(".over_time").val('');
		$(this).closest('tr').find(".over_time").focus();
	}
	else if(parseInt($(this).closest('tr').find(".over_time").val())<0)
	{
		alert("Over time value is invalid!");
		$(this).closest('tr').find(".over_time").val(0);
		$(this).closest('tr').find(".over_time").focus();
	}
	else if(parseInt($(this).closest('tr').find(".over_time").val())>8)
	{
		alert("Over time value is invalid!");
		$(this).closest('tr').find(".over_time").val(0);
		$(this).closest('tr').find(".over_time").focus();
		
	}
	else if(lid!="" && wt!="" && wh!="" && ot!="" )
	{
		
		$(this).closest("tr").find('.labour_id option[value!="'+lid+'"]').remove();

		$('#lbr_temp_id option[value="' + lid + '"]').remove();
		$('#labours').val($('#lbr_temp_id').html());
		
		var lbr_data=add_labour();

		$("#daily_work").append(lbr_data);

		$("daily_work .labour_id").select2();
	}
	else
	{
		alert("Please set all data.!");
	}
});

$(document).on('click',".btnLbrDel",function()
{
	if(confirm("Are you sure, Delete this row?"))
	{
		$(this).closest('tr').remove();
	}
});


/*
$("#work_type").change(function()
{
	$("#working_hour").val('');
	$("#amt_otn").val(0);
	$("#amt_otc").val(0);
	$("#ot_hrs").val(0);
	$("#total_wage").val(0);
	
	if($(this).val()==1)
	{
		$("#amt_oh_ch").val($("#amt_oh").val());
	}
	else
	{
		$("#amt_oh_ch").val($("#amt_ch").val());
	}
});



$("#working_hour").change(function()
{
	var w_hrs=$(this).val();
	var amt=$("#amt_oh_ch").val();
	
	if(w_hrs==8)   //fill day
	{
		n_val=parseFloat($("#amt_oh_ch").val());
		$("#total_wage").val(n_val.toFixed(2));
		$("#ot_hrs").prop('readonly',false);
	}
	else  if(w_hrs==4)  //fill day
	{
		c_val=parseFloat($("#amt_oh_ch").val())/2;
		$("#total_wage").val(c_val.toFixed(2));
		clear_control();
		$("#ot_hrs").prop('readonly',true);
	}
	else //fill day
	{
		c_val=parseFloat($("#amt_oh_ch").val())/2;
		$("#total_wage").val(c_val.toFixed(2));
		clear_control();
		$("#ot_hrs").prop('readonly',true);
	}
});


function clear_control()
{
	$("#amt_otn").val(0);
	$("#amt_otc").val(0);
	$("#ot_hrs").val(0);
}

$("#ot_hrs").keyup(function()
{
	var w_hrs=$("#working_hour").val();
	var wtype=$("#work_type").val();
	var oth=$(this).val();
	var oh_ch_val=$("#amt_oh_ch").val();
	
	if(parseInt(oth)>8)
	{
		alert("Invalid over time, Max-8hrs only")
		$(this).val(0);
	}
	else
	{

		if(wtype==1 && w_hrs==8)
		{
			$("#amt_otc").val(0);
			otn_val=(parseFloat(oh_ch_val)/8)*parseFloat(oth);
			t_wage=parseFloat(oh_ch_val)+parseFloat(otn_val);
			$("#amt_otn").val(parseFloat(otn_val).toFixed(2));
		}
		else if(wtype==2 && w_hrs==8)
		{
			$("#amt_otn").val(0);
			otc_val=(parseFloat(oh_ch_val)/8)*parseFloat(oth);
			t_wage=parseFloat(oh_ch_val)+parseFloat(otc_val);
			$("#amt_otc").val(parseFloat(otc_val).toFixed(2));
		}
		
		
		if($.trim(oth)!="")
		{
			$("#total_wage").val(t_wage.toFixed(2));
		}
		else
		{
			$("#amt_otn").val(0);
			$("#amt_otc").val(0);
			$("#total_wage").val(oh_ch_val);
		}
	}
});

*/


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-daily-wage"+"/"+id,
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
				url: "delete-daily-wage"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  $("#datatable").DataTable().ajax.reload(null,false);
					  //table.draw();
					  alert("Daily wage successfully removed.");
				   }
				}
			});
		}
		
  });
    
  
  
</script>

@endpush

@endsection
