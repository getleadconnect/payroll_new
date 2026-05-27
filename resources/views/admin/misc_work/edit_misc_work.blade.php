<form method="POST" action="{{url('update-misc-work')}}" enctype="multi-part/form-data">
	@csrf
	
	<input type="hidden" name="ed_work_id" value="{{$mv->id}}">
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Projects</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			<select class="form-control" id="ed_project_id" name="ed_project_id" required>
			<option value="">--select--</option>
			@foreach($proj as $r)
			<option value="{{$r->id}}" @if($r->id==$mv->project_id){{__('selected')}}@endif>{{$r->project_name}}</option>
			@endforeach
			</select>
		</div>
	    </div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Misc-Category</label>
	  <div class="col-lg-9 col-xl-9 col-xxl-9">
		<select class="form-control" name="ed_misc_category_id" required>
		<option value="">--select--</option>
		@foreach($mcat as $r)
		<option value="{{$r->id}}" @if($r->id==$mv->misc_category_id){{__('selected')}}@endif>{{$r->category_name}}</option>
		@endforeach
		</select>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Misc-Vendor</label>
	  <div class="col-lg-9 col-xl-9 col-xxl-9">
	   <select class="form-control" name="ed_misc_vendor_id" required>
		<option value="">--select--</option>
		@foreach($mven as $r)
		<option value="{{$r->id}}" @if($r->id==$mv->misc_vendor_id){{__('selected')}}@endif>{{$r->name}}</option>
		@endforeach
		</select>
	</div>
	</div>
	</div>
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
	  <div class="col-lg-9 col-xl-9 col-xxl-9">
		<textarea class="form-control" name="ed_description" required>{{$mv->description}}</textarea>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Payment Type</label>
	  <div class="col-lg-6 col-xl-6 col-xxl-6">
	  <select class="form-control" name="ed_payment_type" required>
	  <option value="">--select--</option>
	  @foreach($ptype as $r)
	  <option value="{{$r->id}}" @if($r->id==$mv->payment_type_id){{__('selected')}}@endif>{{$r->payment_type}}</option>
	  @endforeach
	  </select>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice Date</label>
	  <div class="col-lg-6 col-xl-6 col-xxl-6">
		 <input type="date" class="form-control" name="ed_invoice_date" value="{{$mv->invoice_date}}" required>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice No</label>
	  <div class="col-lg-6 col-xl-6 col-xxl-6">
		 <input type="text" class="form-control" name="ed_invoice_no" value="{{$mv->invoice_no}}" required>
	</div>
	</div>
	</div>

	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Gst Amount</label>
	  <div class="col-lg-4 col-xl-4 col-xxl-4">
		 <input type="number" class="form-control" step="any" id="ed_gst_amount" name="ed_gst_amount" value="{{$mv->gst_amount}}" required >
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Total Amount</label>
	  <div class="col-lg-4 col-xl-4 col-xxl-4">
		 <input type="number" class="form-control" step="any" id="ed_total_amount" name="ed_total_amount" value="{{$mv->total_amount}}" required >
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