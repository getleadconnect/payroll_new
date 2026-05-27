<form method="POST" action="{{url('update-staff-salary')}}" enctype="multipart/form-data">
@csrf

<input type="hidden" id="ed_salary_id" name="ed_salary_id" value="{{$ss->id}}">
<input type="hidden" id="ed_nrate" name="ed_nrate" value="{{$sinc->ot_rate}}">
<input type="hidden" id="ed_srate" name="ed_srate" value="{{$sinc->sunday_rate}}">
<input type="hidden" id="ed_sal_inc_id" name="ed_sal_inc_id" value="{{$sinc->id}}">


	<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Project</label>
		  <div class="col-lg-8 col-xl-8 col-xxl-8">
			 <select class="form-control input-default "  id="ed_project_id" name="ed_project_id" required>
			 <option value="">--select--</option>
			 @foreach($projs as $r)
				<option value="{{$r->id}}" @if($r->id==$ss->project_id){{__('selected')}}@endif>{{$r->project_name}}</option>
			 @endforeach
			 </select>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff Name</label>
		  <div class="col-lg-8 col-xl-8 col-xxl-8">
			<select class="form-control input-default " id="ed_staff_id"  name="ed_staff_id" required>
			 <option value="">--select--</option>
			 @foreach($pst as $r)
				<option value="{{$r->id}}" @if($r->id==$ss->staff_id){{__('selected')}}@endif>{{$r->name}}</option>
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
		  <select class="form-control input-default "  name="ed_month" required>
			 <option value="">--select--</option>
			 @foreach($mon as $key=>$month)
			   <option value="{{++$key}}" @if($key==$ss->month){{__('selected')}}@endif >{{$month}}</option>
			 @endforeach
		  </select>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Year</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
				<input type="number" class="form-control" id="ed_year" name="ed_year" value="{{$ss->year}}" required>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Salary</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			 <input type="number" class="form-control " step="any" id="ed_salary" name="ed_salary" value="{{$sinc->current_salary}}" required readonly>
		  </div>
		</div>
	</div>
	
	
	{{--<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Nor-OT-Hrs</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control" step="any" id="ed_normal_ot" name="ed_normal_ot" value="{{$ss->normal_ot}}" required>
		  </div>
		</div>
	</div> --}}
		
	
	
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Nor-OT-Amt</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_normal_amt" name="ed_normal_amt"  value="{{$ss->normal_amt}}"required readonly>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sun-OT-Hrs</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control " step="any" id="ed_sunday_ot" name="ed_sunday_ot" value="{{$ss->sunday_ot}}" required>
		  </div>
		  
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sun-OT-Amt</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default" step="any" id="ed_sunday_amt" name="ed_sunday_amt" value="{{$ss->sunday_amt}}" required readonly>
		  </div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">No Of Leave</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default" step="any" id="ed_leave_no" name="ed_leave_no" value="{{$ss->leave_no}}" required>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Leave Amt</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			   <input type="number" class="form-control input-default" step="any" id="ed_leave_amt" name="ed_leave_amt" value="{{$ss->leave_amt}}" required readonly>
		  </div>
		  
		  <div class="col-lg-1 col-xl-1 col-xxl-1">
			  <button type="button" id="btnCalc" class="btn btn-secondary btn-xs btn-sm" >Calc</button>
		  </div>
		  
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Net Salary</label>
		  <div class="col-lg-6 col-xl-6 col-xxl-6">
			 <input type="number" class="form-control input-default" step="any" id="ed_net_salary" name="ed_net_salary" value="{{$ss->net_salary}}" required readonly>
		  </div>
		</div>
	</div>

	<div class="modal-footer">
	  <button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
	  <button type="submit" id="btnSubmit" class=" btn btn-secondary btn-size" disabled>Save changes</button>
	</div>

	</form>
	
<script>

$("#btnSubmit").prop('disabled',true);

$("#ed_project_id").change(function()
{
	var pid=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-project-staffs"+"/"+pid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#ed_staff_id").html(res);
		}
	});
	
});

$("#ed_staff_id").change(function()
{
	
	var sid=$(this).val();
		
	if(sid!="")
	{
		jQuery.ajax({
			type: "get",
			url: "get-staff-salary"+"/"+sid,
			dataType: 'html',
			//data: {staff_id:sid,month:mon,year:yr},
			success: function(res)
			{
				$("#ed_salary").val(parseFloat(res).toFixed(2));
			}
		});
	}
	else
	{
		$("#salary").val('0');
	}
	
});

$("#btnCalc").click(function()
{
   get_net_salary();
   $("#btnSubmit").prop('disabled',false);
});


function get_net_salary()
{
	var sal=$("#ed_salary").val();
    var s_ot=$("#ed_sunday_ot").val();
    var nrate=$("#ed_nrate").val();
    var srate=$("#ed_srate").val();
    var lno=$("#ed_leave_no").val();
	var namt=$("#ed_normal_amt").val();
   
	if(sal!="" && s_ot!="" && lno!="" && namt!="")
	{
	  var namt=parseFloat($("#ed_normal_amt").val());
	  var samt=parseFloat(s_ot)*parseFloat(srate);
	  var lamt=(parseFloat(sal)/30)*parseFloat(lno);
	  var nsal=(parseFloat(sal)+parseFloat(namt)+parseFloat(samt))- parseFloat(lamt);

	  $("#ed_normal_amt").val(namt.toFixed(2));
	  $("#ed_sunday_amt").val(samt.toFixed(2));
	  $("#ed_leave_amt").val(lamt.toFixed(2));
	  $("#ed_net_salary").val(nsal.toFixed(2));
	}
	else
	{
		alert("Required details missing, try again.");
	}
}


$("#ed_net_salary").click(function()
{
   get_net_salary();
	
});



</script>