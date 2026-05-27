	<form  method="POST" action="{{url('update-staff-over-time')}}"> 
			@csrf
			
			<input type="hidden" name="ed_sot_id" value="{{$sot->id}}">
			
				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<select class="form-control" name="ed_project_id" id="ed_project_id">
						<option value="">--select--</option>
						@foreach($projs as $r)
						   <option value="{{$r->id}}" @if($r->id==$sot->project_id){{_('selected')}} @endif>{{$r->project_name}}</option>
						@endforeach
						</select>
						</div>
					</div>
				</div>
				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff</label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<select class="form-control" name="ed_staff_id" id="ed_staff_id">
						<option value="">--select--</option>
						@foreach($staffs as $r)
						   <option value="{{$r->id}}" @if($r->id==$sot->staff_id){{_('selected')}} @endif>{{$r->name}}</option>
						@endforeach
						</select>
						</div>
					</div>
				</div>

				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
						<div class="col-lg-8 col-xl-8 col-xxl-8">
						<input type="date" class="form-control" style="width:160px;" id="ed_ot_date" name="ed_ot_date" value="{{$sot->ot_date}}" required>
						</div>
					</div>
				</div>

				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Start Time</label>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<input type="time" class="form-control" id="ed_start_time" name="ed_start_time" value="{{$sot->time_in}}">
						</div>
					</div>
				</div>
				
				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">End Time</label>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<input type="time" class="form-control" id="ed_end_time" name="ed_end_time" value="{{$sot->time_out}}">
						</div>
					</div>
				</div>
				

				<div class="form-group"> 
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Sunday-Ot</label>
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<input type="number" step="any" class="form-control" id="ed_sunday_ot" name="ed_sunday_ot" value="{{$sot->sunday_ot}}" required>
						</div>
					</div>
				</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger light btn-xs btn-sm btn-size" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-secondary btn-xs btn-sm btn-size" >Update changes</button>
			</div>

	</form>
	
	<script>
	
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

	
	
	</script>