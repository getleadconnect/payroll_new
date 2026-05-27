<form method="POST" action="{{url('update-misc-site-expense')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="ed_site_exp_id" value="{{$mex->id}}">
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg"  name="ed_project_id" required>
		   <option value="">--select--</option>
		   @foreach($projs as $r)
			<option value="{{$r->id}}" @if($r->id==$mex->project_id){{__('selected')}}@endif >{{$r->project_name}}</option>
		   @endforeach
		   
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Category</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			<select class="form-control form-control-lg" id="ed_category_id"  name="ed_category_id" required>
		   <option value="">--select--</option>
		   @foreach($mcat as $r)
			<option value="{{$r->id}}" @if($r->id==$mex->misc_category_id){{__('selected')}}@endif >{{$r->category_name}}</option>
		   @endforeach
		   
		   </select>
		  </div>
		</div>
	</div>

	

	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <input type="text" class="form-control input-default "  name="ed_item_name"  value="{{$mex->item_name}}" required>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <textarea class="form-control "  name="ed_description" required>{{$mex->description}}</textarea>
		  </div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Payment Type</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			<select class="form-control form-control-lg" id="ed_payment_type"  name="ed_payment_type" required>
		   <option value="">--select--</option>
		   @foreach($ptype as $r)
			<option value="{{$r->id}}" @if($r->id==$mex->payment_type_id){{__('selected')}}@endif >{{$r->payment_type}}</option>
		   @endforeach
		   
		   </select>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice Date</label>
		  <div class="col-lg-4 col-xl-4 col-xxl-4">
			  <input type="date" class="form-control input-default "  name="ed_invoice_date" value="{{$mex->invoice_date}}" required>
		  </div>
		</div>
	</div>
	
					
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice No</label>
		  <div class="col-lg-4 col-xl-4 col-xxl-4">
			  <input type="text" class="form-control input-default"  name="ed_invoice_no" value="{{$mex->invoice_no}}" required>
		  </div>
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
		  <div class="col-lg-4 col-xl-4 col-xxl-4">
			  <input type="number" class="form-control input-default " step="any"  name="ed_amount" value="{{$mex->amount}}" required>
		  </div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Update changes</button>
	</div>
	
	
	</form>