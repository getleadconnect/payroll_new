<form method="POST" action="{{url('update-labour-wage')}}" enctype="multipart/form-data">
  @csrf
	
	
	<ul> 
		<li style="color:red;">1. To increase/deacrese labour Wages.</li>
		<li style="color:red;">2. You should change wage values on <b>Fridays</b> only.</li>
		<li style="color:red;">3. Not Change in normal days</li>
	</ul>
			
	<input type="hidden" class="form-control"  name="ed_labour_wage_id" value="{{$lw->id}}">
	
	<div class="form-group mt-2">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Name</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <input type="text" class="form-control input-default"  name="ed_name" value="{{$lw->name}}" readonly>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Wage Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		   <input type="date" class="form-control input-default" id="ed_wage_date" name="ed_wage_date" value="{{$lw->wage_date}}"  required>
		</div>
		</div>
	</div>
	
	@php
	$friday = \Carbon\Carbon::parse('this friday')->toDateString();
	@endphp
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Normal</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="number" class="form-control input-default" id="ed_wage_normal" name="ed_wage_normal" value="{{$lw->wage_normal}}" @if($friday!=date('Y-m-d')){{__('readonly')}} @endif required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Concrete</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="number" class="form-control input-default" id="ed_wage_concrete" name="ed_wage_concrete" value="{{$lw->wage_concrete}}" @if($friday!=date('Y-m-d')){{__('readonly')}} @endif required>
		</div>
		
	   </div>
	</div>

	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Over Time</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<select class="form-control input-default"  id="ed_wage_ot" name="ed_wage_ot" required>
			   <option value="">--select--</option>
			   <option value="1" @if($lw->wage_ot==1){{__('selected')}}@endif>1</option>
			   <option value="1.25" @if($lw->wage_ot==1.25){{__('selected')}}@endif>1.25</option>
			   <option value="1.5" @if($lw->wage_ot==1.5){{__('selected')}}@endif>1.5</option>
		   </select>
		</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size"  @if($friday!=date('Y-m-d')){{__('disabled')}} @endif >Save changes</button>
	</div>
</form>

<script>


</script>

