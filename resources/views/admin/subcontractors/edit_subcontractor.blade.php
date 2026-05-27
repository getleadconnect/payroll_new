<form method="POST" action="{{url('update-subcontractor')}}" enctype="multipart/form-data">
		@csrf
				
		<input type="hidden" class="form-control" name="ed_subcon_id" value="{{$sp->id}}">
		
		<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>

		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Name</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <input type="text" class="form-control input-default " name="name"  value="{{$sp->name}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">GST Number</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <input type="text" class="form-control input-default "  name="gst_no" value="{{$sp->gst_no}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">PAN Number</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <input type="text" class="form-control input-default "  name="pan_no" value="{{$sp->pan_no}}" required>
			  </div>
			</div>
		</div>
		
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" style="padding-right:0px;">Contact Person</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <input type="text" class="form-control input-default "  name="contact_person" value="{{$sp->contact_person}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Mobile</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <input type="number" class="form-control input-default "  name="mobile" value="{{$sp->mobile}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Address</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				 <textarea class="form-control" name="address"  required>{{$sp->address}}</textarea>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bank Name</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				  <input type="text" class="form-control input-default "  name="bank_name" value="{{$sp->bank_name}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">IFSC Code</label>
			  <div class="col-lg-6 col-xl-6 col-xxl-6">
				  <input type="text" class="form-control input-default "  name="bank_ifsc" value="{{$sp->bank_ifsc}}" required>
			  </div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bank A/C No</label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				  <input type="text" class="form-control input-default "  name="bank_account_no" value="{{$sp->bank_account_no}}" required>
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
