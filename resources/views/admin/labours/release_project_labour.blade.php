<form method="POST" action="{{url('release-assigned-labour')}}" enctype="multipart/form-data">
  @csrf
	
	<input type="hidden" class="form-control"  name="rel_labour_id" value="{{$pl->id}}">
	
	<div class="form-group">
		<label style="font-size:18px;">Are you sure,You want to complete labour works!</label>
	</div>
	
	<div class="form-group mt-2">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Set end date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		   <input type="date" class="form-control"  name="rel_end_date" required>
		</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Update changes</button>
	</div>
</form>


<script>


</script>

