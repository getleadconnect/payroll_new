		<form method="POST" action="{{url('update-subcontractor-item')}}" enctype="multipart/form-data">
		@csrf

	    <input type="hidden" class="form-control"  name="ed_subcon_item_id" value="{{$sc->id}}">
	
			<div class="form-group">
			<label>Item Name</label>
			   <input type="text" class="form-control input-default"  name="ed_item_name"  value="{{$sc->item_name}}" required>
			</div>
			
			<div class="form-group">
			<label >Units</label>
			   <select class="form-control form-control-lg"  name="ed_unit_id" required>
			   <option value="">--select--</option>
			   @foreach($units as $r)
				<option value="{{$r->id}}" @if($r->id==$sc->material_unit_id){{__('selected')}}@endif >{{$r->unit_name}}</option>
			   @endforeach
			   </select>
			</div>
	
				
			<div class="modal-footer">
				<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
			</div>
		</form>


<script>
  
</script>



