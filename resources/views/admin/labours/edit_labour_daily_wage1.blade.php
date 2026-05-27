<form  method="POST" action="{{ url('update-daily-wage')}}" enctype="multipart/form-data">
		@csrf
			
			<input type="hidden" name="ed_wage_id" value="{{$ldw->id}}">
			
			<div class="form-group">
			  <div class="row ">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Project </label>
				<select type="text" class="form-control" id="ed_project_id" name="ed_project_id" required>
				<option value="">--select--</option>
				  <option value="{{$projs->id}}" @if($projs->id==$ldw->project_id){{__('selected')}}@endif>{{ $projs->project_name }}</option>
				</select>
				</div>
				
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Labour </label>
				<select type="text" class="form-control" id="ed_labour_id"  name="ed_labour_id" required>
				<option value="">--select--</option>
				<option value="{{$lbr->id}}" @if($lbr->id==$ldw->labour_id){{__('selected')}}@endif>{{ $lbr->name }}</option>
				</select>
				</div>
			   </div>
			</div>
			
			<div class="form-group">
			  <div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Main Cost Center</label> <!-- main cost Schedule table --->
				<select type="text" class="form-control" id="ed_main_cost_center_id"  name="ed_main_cost_center_id" required>
				<option value="">--select--</option>
				@foreach($mcost as $r)
				<option value="{{$r->id}}" @if($r->id==$ldw->main_cost_center_id){{__('selected')}}@endif>{{ $r->main_item }}</option>
				@endforeach
				</select>
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Work Type</label>
				<select type="text" class="form-control" id="ed_work_type" name="ed_work_type" required>
				<option value="">--select--</option>
				<option value="1" @if($ldw->work_type==1){{__('selected')}}@endif>Normal</option>
				<option value="2" @if($ldw->work_type==2){{__('selected')}}@endif>Concreate</option>
				</select>
				</div>
			  </div>
			</div>	
			
			<div class="form-group">
			<div class="row">
								
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>AMT_OH </label>
				<input type="number" class="form-control text-right" step="any" id="ed_amt_oh" name="ed_amt_oh" value="{{$ldw->amt_oh}}" required>
				</div>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>AMT_CH</label>
				<input type="number" class="form-control text-right" step="any" id="ed_amt_ch" name="ed_amt_ch" value="{{$ldw->amt_ch}}" required>
	
				<input type="hidden" class="form-control text-right" id="ed_amt_oh_ch" name="ed_amt_oh_ch" value="{{$ldw->wage}}"> <!-- daily wage -->				
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>Working Hrs </label>
				<select type="text" class="form-control" id="ed_working_hour" name="ed_working_hour" required>
				<option value="">--select--</option>
				<option value="8" @if($ldw->normal_hour==8 || $ldw->concrete_hour==8){{__('selected')}}@endif>Full Day(8Hrs)</option>
				<option value="4" @if($ldw->normal_hour==4 || $ldw->concrete_hour==4){{__('selected')}}@endif>Half Day(4Hrs)</option>
				</select>
				</div>
			</div>
			</div>
			
			@php
			
			  if($ldw->work_type==1) {	$ot_hrs=$ldw->otn_hrs; }else{ $ot_hrs=$ldw->otc_hrs; }

			@endphp
			
			
			<div class="form-group">
			<div class="row">	
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>OT Hrs</label>
				<input type="number" class="form-control text-right" step="any" id="ed_ot_hrs" name="ed_ot_hrs" value="{{$ot_hrs}}" required>
				</div>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>AMT_OTN</label>
				<input type="number" class="form-control text-right" step="any" id="ed_amt_otn" name="ed_amt_otn" value="{{$ldw->amt_otn}}" required>
				</div>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>AMT_OTC</label>
				<input type="number" class="form-control text-right" step="any" id="ed_amt_otc" name="ed_amt_otc" value="{{$ldw->amt_otc}}" required>
				</div>
				
			</div>
			</div>
			
			<div class="form-group">	
			 <div class="row">
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>Total Wage</label>
				<input type="number" class="form-control text-right" step="any" id="ed_total_wage" name="ed_total_wage" value="{{$ldw->total_wage}}" required>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>Date</label>
				<input type="date" class="form-control" id="ed_entry_date"  name="ed_entry_date" value="{{$ldw->entry_date}}" required >
				</div>
			</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-danger btn-size">Close</button>
				<button type="submit" class="btn btn-secondary btn-size">Submit</button>
			</div>
				
			</form>
<script>


$(document).ready(function()
{
	var w_hrs=$(this).val();
	
	if(w_hrs==8)   //fill day
	{
		$("#ed_amt_otn").prop('readonly',false);
		$("#ed_amt_otc").prop('readonly',false);
		$("#ed_ot_hrs").prop('readonly',false);
	}
	else   //half day
	{
		$("#ed_amt_otn").prop('readonly',true);
		$("#ed_amt_otc").prop('readonly',true);
		$("#ed_ot_hrs").prop('readonly',true);
	}
});


$("#ed_work_type").change(function()
{
	$("#ed_working_hour").val('');
	$("#ed_amt_otn").val(0);
	$("#ed_amt_otc").val(0);
	$("#ed_ot_hrs").val(0);
	$("#ed_total_wage").val(0);
	
	if($(this).val()==1)
	{
		$("#ed_amt_oh_ch").val($("#ed_amt_oh").val());
	}
	else
	{
		$("#ed_amt_oh_ch").val($("#ed_amt_ch").val());
	}
});

$("#ed_working_hour").change(function()
{
	var w_hrs=$(this).val();
	var amt=$("#ed_amt_oh_ch").val();
	
	if(w_hrs==8)   //fill day
	{
		n_val=parseFloat($("#ed_amt_oh_ch").val());
		$("#ed_total_wage").val(n_val.toFixed(2));
		$("#ed_amt_otn").prop('readonly',false);
		$("#ed_amt_otc").prop('readonly',false);
		$("#ed_ot_hrs").prop('readonly',false);
	}
	else   //half day
	{
		c_val=parseFloat($("#ed_amt_oh_ch").val())/2;
		$("#ed_total_wage").val(c_val.toFixed(2));
		
		$("#ed_amt_otn").prop('readonly',true);
		$("#ed_amt_otc").prop('readonly',true);
		$("#ed_ot_hrs").prop('readonly',true);
		
	}
});


$("#ed_ot_hrs").keyup(function()
{
	var w_hrs=$("#ed_working_hour").val();
	var wtype=$("#ed_work_type").val();
	var oth=$(this).val();
	var oh_ch_val=$("#ed_amt_oh_ch").val();
	
	if(parseInt(oth)>8)
	{
		alert("Invalid over time, Max-8hrs only")
		$(this).val(0);
	}
	else
	{
		if(wtype==1 && w_hrs==8)
		{
			$("#ed_amt_otc").val(0);
			otn_val=(parseFloat(oh_ch_val)/8)*parseFloat(oth);
			t_wage=parseFloat(oh_ch_val)+parseFloat(otn_val);
			$("#ed_amt_otn").val(parseFloat(otn_val).toFixed(2));
		}
		else if(wtype==2 && w_hrs==8)
		{
			$("#ed_amt_otn").val(0);
			otc_val=(parseFloat(oh_ch_val)/8)*parseFloat(oth);
			t_wage=parseFloat(oh_ch_val)+parseFloat(otc_val);
			$("#ed_amt_otc").val(parseFloat(otc_val).toFixed(2));
		}
		
		
		if($.trim(oth)!="")
		{
			$("#ed_total_wage").val(t_wage.toFixed(2));
		}
		else
		{
			$("#ed_amt_otn").val(0);
			$("#ed_amt_otc").val(0);
			$("#ed_total_wage").val(oh_ch_val);
		}
	}
});



</script>