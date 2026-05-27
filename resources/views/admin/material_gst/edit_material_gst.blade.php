	<form method="POST" action="{{url('update-material-gst')}}" enctype="multipart/form-data">
		@csrf

				
		<input type="hidden" class="form-control" name="ed_mat_gst_id" value="{{$mg->id}}">

			<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Material Type</label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			   <select class="form-control form-control-lg"  name="ed_material_type_id" required>
			   <option value="">--select--</option>
			   @foreach($mtypes as $r)
				<option value="{{$r->id}}" @if($r->id==$mg->material_type_id){{__('selected')}}@endif >{{$r->material_type_name}}</option>
			   @endforeach
			   </select>
			</div>
			</div>
			</div>
			
			<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Material GST(%)</label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			    <input type="number" class="form-control input-default"  step="any" style="width:150px;" name="ed_gst" value="{{$mg->gst}}" required>
			</div>
			</div>
			</div>
			
			<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">GST Date</label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			    <input type="date" class="form-control input-default" style="width:150px;"  name="ed_gst_date" value="{{$mg->gst_date}}" required>
			</div>
			</div>
			</div>
			
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-secondary btn-size" >Save changes</button>
				</div>
		</form>

<script>
  
  
  
</script>


