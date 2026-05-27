<form method="POST" action="{{url('update-company')}}" enctype="multipart/form-data">
@csrf
	
	<input type="hidden" class="form-control"  name="ed_company_id" value="{{$cm->id}}">
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Company Name</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <input type="text" class="form-control input-default"  name="ed_company_name" value="{{$cm->company_name}}" required>
	</div>
	</div>  
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Address</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <textarea class="form-control" name="ed_address" required>{{$cm->address}}</textarea>
	</div>
	</div>  
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Email</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <input type="email" class="form-control input-default " name="ed_email" value="{{$cm->email}}" required>
	</div>
	</div>  
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Contact No</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <input type="text" class="form-control input-default " name="ed_mobile"  value="{{$cm->mobile}}" required>
	</div>
	</div>  
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">GST No</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <input type="text" class="form-control input-default " name="ed_gst_no" value="{{$cm->gst_no}}" required>
	</div>
	</div>  
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">PAN No</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <input type="text" class="form-control input-default " name="ed_pan_no" value="{{$cm->pan_no}}" required>
	</div>
	</div>  
	</div>

	<div class="form-group">
	<div class="row">
	<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Others</label>
	<div class="col-lg-8 col-xl-8 col-xxl-8">
	   <textarea class="form-control" name="ed_others" >{{$cm->others}}</textarea>
	</div>
	</div>  
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal" >Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
</form>



<script>


</script>


