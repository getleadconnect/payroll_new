<label style="color:red;font-size:12px;" class="mb-2" >All fields are mandatory</label>

<form method="POST" action="{{url('update-misc-vendor')}}" enctype="multi-part/form-data">
	@csrf
	
	<input type="hidden" name="ed_vendor_id" value="{{$mv->id}}">
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Name</label>
	  <div class="col-lg-8 col-xl-8 col-xxl-8">
		<input type="text" class="form-control" name="ed_name" value="{{$mv->name}}" required>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">GST No</label>
	  <div class="col-lg-8 col-xl-8 col-xxl-8">
		<input type="text" class="form-control" name="ed_gst_no" value="{{$mv->gst_no}}" required>
	</div>
	</div>
	</div>
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">PAN No</label>
	  <div class="col-lg-6 col-xl-6 col-xxl-6">
		<input type="text" class="form-control" name="ed_pan_no" value="{{$mv->pan_no}}">
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bank Name</label>
	  <div class="col-lg-8 col-xl-8 col-xxl-8">
		 <input type="text" class="form-control" name="ed_bank_name" value="{{$mv->bank_name}}" required>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bank Ifsc</label>
	  <div class="col-lg-6 col-xl-6 col-xxl-6">
		 <input type="text" class="form-control" name="ed_bank_ifsc" value="{{$mv->bank_ifsc}}" required>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Account No</label>
	  <div class="col-lg-8 col-xl-8 col-xxl-8">
		 <input type="text" class="form-control" name="ed_bank_account_no" value="{{$mv->bank_account_no}}" required>
	</div>
	</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
	   <button type="submit" class="btn btn-secondary btn-size">Update</button>
	</div>
	
	</form>