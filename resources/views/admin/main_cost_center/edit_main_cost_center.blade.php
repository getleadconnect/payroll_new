<form method="POST" action="{{url('update-cost-center')}}" enctype="multipart/form-data">
	@csrf

<input type="hidden" name="ed_schedule_id" value="{{$mcs->id}}">

	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Name</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <select class="form-control" name="ed_project_id" required>
		   <option value="">--select--</option>
			@foreach($proj as $r)
			  <option value="{{$r->id}}" @if($r->id==$mcs->project_id){{__('selected')}}@endif >{{$r->project_name}}</option>
			@endforeach
		   </select>
		</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Main Cost Items</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <select class="form-control" name="ed_main_cost_item_id" required>
		   <option value="">--select--</option>
			 @foreach($mitems as $r)
		  <option value="{{$r->id}}" @if($r->id==$mcs->main_cost_item_id){{__('selected')}}@endif>{{$r->main_item}}</option>
	   @endforeach
		   </select>
		</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Floor Nos</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <select class="form-control" name="ed_floor_no_id" required>
		   <option value="">--select--</option>
			 @foreach($flrnos as $r)
				<option value="{{$r->id}}" @if($r->id==$mcs->floor_no_id){{__('selected')}}@endif>{{$r->floor_no}}</option>
			 @endforeach
		   </select>
		</div>
	</div>
	</div>

	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Schedule Qty</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="text" class="form-control input-default " name="ed_schedule_qty" value="{{$mcs->schedule_qty}}" required>
		</div>
	</div>
	</div>

	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="text" class="form-control input-default " name="ed_schedule_amount" value="{{$mcs->schedule_amount}}"required>
		</div>
	</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
	</form>


<script>


</script>

