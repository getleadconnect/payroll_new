<form method="POST" action="{{url('update-staff-ta')}}" enctype="multipart/form-data">
	@csrf

		<input type="hidden" name="ed_staff_ta_id" value="{{$sta->id}}">
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2" >Staff</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		
		   <select class="form-control form-control-lg"  name="ed_staff_id" required>
		   <option value="">--select--</option>
		   @foreach($stfs as $r)
			<option value="{{$r->id}}" @if($r->id==$sta->id){{__('selected')}}@endif>{{$r->name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2" >TA</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <input type="number" class="form-control input-default" style="width:150px;"  name="ed_ta_amount"  value="{{$sta->ta_amount}}" required>
		</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2" >Description</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <textarea class="form-control input-default"  name="ed_description" required>{{$sta->description}}</textarea>
		</div>
		</div>
		</div>
		
		<div class="modal-footer">
		    <button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size">Update</button>
		</div>
		
		
	</form>


<script>
  
</script>



