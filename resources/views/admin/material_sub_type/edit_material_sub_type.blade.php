		<form method="POST" action="{{url('update-material-sub-type')}}" enctype="multipart/form-data">
		@csrf

	    <input type="hidden" class="form-control"  name="ed_sub_type_id" value="{{$mst->id}}">

			<div class="form-group">
			<label >Material Type</label>
			   <select class="form-control form-control-lg"  name="ed_material_type_id" required>
			   <option value="">--select--</option>
			   @foreach($mtypes as $r)
				<option value="{{$r->id}}" @if($r->id==$mst->material_type_id){{__('selected')}}@endif >{{$r->material_type_name}}</option>
			   @endforeach
			   </select>
			</div>
			
			<div class="form-group">
			<label>Material Sub-Type Name</label>
			   <input type="text" class="form-control input-default"  name="ed_sub_type_name"  value="{{$mst->sub_type_name}}" required>
			</div>
				
			<div class="modal-footer">
				<button type="button" class="btn btn-danger light pr-3 pl-3" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-secondary pr-3 pl-3">Save changes</button>
			</div>
		</form>


<script>
  
</script>



