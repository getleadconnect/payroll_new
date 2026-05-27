<form method="POST" action="{{url('update-client')}}" enctype="multipart/form-data">
@csrf
	
	<input type="hidden" class="form-control"  name="ed_client_id" value="{{$cl->id}}">
	
	<div class="form-group">
	<label>Company Name</label>
	   <input type="text" class="form-control input-default"  name="ed_client_name" value="{{$cl->client_name}}" required>
	</div>
	
	<div class="form-group">
	<label>Contact Person</label>
	   <input type="text" class="form-control input-default "  name="ed_contact_person" value="{{$cl->contact_person}}" required>
	</div>
	
	<div class="form-group">
	<label>Mobile</label>
	   <input type="number" class="form-control input-default "  name="ed_mobile" value="{{$cl->mobile}}" required>
	</div>
	
	<div class="form-group">
	<label>Address</label>
	   <textarea class="form-control" name="ed_address" required>{{$cl->address}}</textarea>
	</div>
	
	<div class="form-group">
	<label>Gst Number</label>
	   <input type="text" class="form-control input-default " name="ed_gst_no" value="{{$cl->gst_no}}" required>
	</div>
	
	
	<div class="form-group">
	<label>Others</label>
	   <textarea class="form-control" name="ed_others" >{{$cl->others}}</textarea>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
</form>


<script>


</script>

