<form method="POST" action="{{url('update-return-project-asset')}}" enctype="multipart/form-data">
	@csrf

	<input type="hidden" name="pro_item_id" value="{{ $pa->id}}">
	<input type="hidden" name="asset_item_id" value="{{ $pa->asset_item_id}}">

	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <input type="text" class="form-control input-default" name="item_name" value="{{ $aitem->item_name}}" readonly required>
		  </div>
		</div>
	</div>
		
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Return Qty</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			  <input type="number" class="form-control input-default" id="ret_quantity" name="ret_quantity" required>
		  </div>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
		  @php
			if($pa->return_quantity==0) { $qty=$pa->quantity;  } else { $qty=$pa->quantity-$pa->return_quantity;  }
		  @endphp
	  
			  <input type="number" class="form-control" id="current_qty" name="current_qty" value="{{$qty}}" readonly>
		  </div>
		  <div class="offset-lg-3 col-lg-12 col-xl-12 col-xxl-12 col-form-label">
		  <label id="lblerr" style="color:red;font-size:11px;"></label>
		  </div>
		</div>
	</div>
	

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light  btn-size " data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size "> Update </button>
	</div>
				
</form>


<script>

$("#ret_quantity").keyup(function()
{
	var aqty=parseInt($("#current_qty").val());
	var qty=parseInt($(this).val());
	if(qty>aqty)
	{
		$("#lblerr").html("Quantity Invalid.");
	}
	else
	{
		$("#lblerr").html("");
	}
});

</script>

