<form  method="POST" action="{{ url('update-daily-wage')}}" enctype="multipart/form-data">
@csrf
		<input type="hidden" name="ed_wage_id" value="{{$ldw->id}}">
		
		   <div class="form-group">
			<label>Project </label>
			<select type="text" class="form-control" id="ed_project_id" name="ed_project_id" required>
			<option value="">--select--</option>
			  <option value="{{$projs->id}}" selected>{{ $projs->project_name }}</option>
			</select>
			</div>
			
			<div class="form-group">
			<label>Floor</label> <!-- main cost Schedule table --->
			<select type="text" class="form-control" id="ed_floor_no"  name="ed_floor_no" required>
			<option value="">--select--</option>
			  <option value="{{$flnos->id}}" selected>{{ $flnos->floor_no }}</option>
			</select>
			</div>
			
		<div class="form-group">
			<label>Main Cost Center</label> <!-- main cost Schedule table --->
			<select type="text" class="form-control" id="ed_main_cost_center_id"  name="ed_main_cost_center_id" required>
			@foreach($mcost as $r)
			<option value="{{$r->id}}" @if($r->id==$ldw->main_cost_center_id){{__('selected')}} @endif >{{$r->main_item}}</option>
			@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<label>Labour</label> <!-- main cost Schedule table --->
			<select type="text" class="form-control" id="ed_labour_id"  name="ed_labour_id" required>
			<option value="{{$ldw->labour_id}}">{{$ldw->name}}</option>
			</select>
		</div>


		<div class="form-group">
		<div class="row">
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<label>Work Type</label> <!-- main cost Schedule table --->
			<select  class=" form-control work_type" id="ed_work_type"  name="ed_work_type" required>
				<option value="">--select--</option>
				<option value="1" @if($ldw->work_type==1){{__('selected')}}@endif >Normal</option>
				<option value="2" @if($ldw->work_type==2){{__('selected')}}@endif >Concreate</option>
			</select>
		</div>
		
		@php
			if($ldw->work_type==1)
			{
				if($ldw->normal_hour==8){$hrs=8;}
				elseif($ldw->normal_hour==4) { $hrs=4;}		
				else { $hrs=0;}
			}
			else
			{
				if($ldw->concrete_hour==8){$hrs=8;}
				elseif($ldw->concrete_hour==4) { $hrs=4;}		
				else { $hrs=0;}
			}
		@endphp
		
		
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<label>Working Hours</label> <!-- main cost Schedule table --->
			 <select  class=" form-control" id="ed_working_hour" name="ed_working_hour" required>
				<option value="">--select--</option>
				<option value="0" @if($hrs==0){{__('selected')}}@endif >Overtime Only</option>
				<option value="8" @if($hrs==8){{__('selected')}}@endif >Full Day(8hrs)</option>
				<option value="4" @if($hrs==4){{__('selected')}}@endif >Half Day(4hrs)</option>
			</select>
		</div>
		
		@php
		if($ldw->otn_hrs!=0){ $ot=$ldw->otn_hrs;}
		else if($ldw->otc_hrs!=0){ $ot=$ldw->otc_hrs;}
		else {$ot=0;}			
		@endphp
		
		
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<label>Over Time</label> <!-- main cost Schedule table --->
			 <input type="number" class="form-control over_time text-right" min="0" max="8"id="ed_over_time"  name="ed_over_time" value="{{$ot}}" required>
		</div>
	</div>
		
		<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn btn-danger btn-size">Close</button>
	<button type="submit" class="btn btn-secondary btn-size">Submit</button>
	</div>

</form>






