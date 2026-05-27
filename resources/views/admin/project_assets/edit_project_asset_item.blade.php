<form method="POST" action="{{url('update-project-asset')}}" enctype="multipart/form-data">
	@csrf

	<input type="hidden" name="pro_item_id" value="{{ $pa->id}}">
	<input type="hidden" name="asset_item_id" value="{{ $pa->asset_item_id}}">

	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Company</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg" id="company_id"  name="company_id" required>
		   <option value="">--select--</option>
		   @foreach($comp as $r)
			<option value="{{$r->id}}" @if($r->id==$pa->company_id){{__('selected')}}@endif>{{$r->company_name}}</option>
		   @endforeach
		   
		   </select>
		</div>
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		 
		 <select class="form-control form-control-lg" id="project_id" name="project_id" required>
		   <option value="">--select--</option>
		   @foreach($pros as $r)
			<option value="{{$r->id}}" @if($r->id==$pa->project_id){{__('selected')}}@endif>{{$r->project_name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
	</div>
		
		
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
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Available Qty</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			 <input type="text" class="form-control" id="available_quantity" name="available_quantity"  value="{{ $aitem->available_quantity+$pa->quantity }}" required readonly>
		  </div>
		</div>
	</div>
		
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Quantity</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			  <input type="number" class="form-control input-default" id="quantity" name="quantity" value="{{ $pa->quantity }}" required>
			  
		  </div>
		  <div class="col-lg-6 col-xl-6 col-xxl-6 col-form-label">
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

$("#company_id").change(function()
{
	var cid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-projects-by-company-id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#project_id").html(res);
			}
		});
});

$("#quantity").keyup(function()
{
	var aqty=parseInt($("#available_quantity").val());
	var qty=parseInt($(this).val());
	if(qty>aqty)
	{
		$("#lblerr").html("Quantity Insuffient.");
	}
	else
	{
		$("#lblerr").html("");
	}
});

</script>

