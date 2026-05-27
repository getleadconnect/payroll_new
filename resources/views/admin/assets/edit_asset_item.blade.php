<form method="POST" action="{{url('update-asset-item')}}" enctype="multipart/form-data">
	@csrf

	<input type="hidden" name="ed_asset_item_id" value="{{ $ai->id}}" required>
	<input type="hidden" id="ed_company_id"  name="ed_company_id" value="{{ $ai->company_id}}" required>

	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Asset Category</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg" name="ed_category_id" required>
		   <option value="">--select--</option>
		   @foreach($cats as $r)
			<option value="{{$r->id}}" @if($r->id==$ai->asset_category_id){{__('selected')}}@endif>{{$r->category_name}}</option>
		   @endforeach
		   
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <input type="text" class="form-control input-default"  name="ed_item_name" value="{{ $ai->item_name }}" required>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <textarea class="form-control" name="ed_description"  required>{{ $ai->description }}</textarea>
		  </div>
		</div>
	</div>
		
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bill Date</label>
		  <div class="col-lg-5 col-xl-5 col-xxl-5">
			  <input type="date" class="form-control input-default"  name="ed_bill_date" value="{{ $ai->bill_date }}" required>
		  </div>
		</div>
	</div>

	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bill No</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			  <input type="text" class="form-control input-default" placeholder="bill no"  name="ed_bill_no" value="{{ $ai->bill_no }}" required>
		  </div>
		<label class="col-lg-2 col-xl-2 col-xxl-2 pr-0 col-form-label">Unit Price</label>
		  <div class="col-lg-4 col-xl-4 col-xxl-4">
			  <input type="number" class="form-control input-default"  name="ed_unit_price" value="{{ $ai->unit_price }}" required>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Quantity</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			  <input type="number" class="form-control input-default"  name="ed_quantity" value="{{ $ai->quantity }}" required>
		  </div>
	
		  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Amount</label>
		  <div class="col-lg-4 col-xl-4 col-xxl-4">
			  <input type="number" class="form-control input-default"  name="ed_amount" value="{{ $ai->amount }}" required>
		  </div>
		</div>
	</div>
	

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light  btn-size pr-3 pl-3" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size pr-3 pl-3">Save changes</button>
	</div>
				
</form>


<script>

$("#ed_company_id").change(function()
{
	var cid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-projects-by-company-id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#ed_project_id").html(res);
			}
		});
});





</script>

