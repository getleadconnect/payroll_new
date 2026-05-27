<form method="POST" action="{{url('save-item-to-project')}}" enctype="multipart/form-data">
	@csrf

	<input type="hidden" name="ass_item_id" value="{{ $ai->id}}" required>

		
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		 
		 <select class="form-control form-control-lg" id="ass_project_id" name="ass_project_id" required>
		   <option value="">--select--</option>
		   @foreach($pros as $r)
				<option value="{{$r->id}}" >{{$r->project_name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			 <input type="text" class="form-control input-default"  name="ass_item_name" value="{{ $ai->item_name }}" required readonly>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Available Qty</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			 <input type="text" class="form-control" id="ass_available_quantity" name="ass_available_quantity"  value="{{ $ai->available_quantity }}" required readonly></textarea>
		  </div>
		</div>
	</div>
		
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Quantity</label>
		  <div class="col-lg-3 col-xl-3 col-xxl-3">
			  <input type="number" class="form-control input-default" id="ass_quantity" name="ass_quantity"  required>
			  
		  </div>
		  <div class="col-lg-6 col-xl-6 col-xxl-6 col-form-label">
		  <label id="lblerr" style="color:red;font-size:11px;"></label>
		  </div>
		</div>
	</div>
	

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light  btn-size pr-3 pl-3" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size pr-3 pl-3">Assign to Project</button>
	</div>
				
</form>


<script>

$("#ass_project_id").select2();

$("#ass_company_id").change(function()
{
	var cid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-projects-by-company-id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#ass_project_id").html(res);
			}
		});
});

$("#ass_quantity").keyup(function()
{
	var aqty=parseInt($("#ass_available_quantity").val());
	var qty=parseInt($(this).val());
	if(qty>aqty)
	{
		$("#lblerr").html("Insuffient Quantity.");
	}
	else if(qty<aqty)
	{
		$("#lblerr").html("Invalid Quantity.");
	}
	else
	{
		$("#lblerr").html("");
	}
});

$("#ass_quantity").change(function()
{
	var aqty=parseInt($("#ass_available_quantity").val());
	var qty=parseInt($(this).val());
	if(qty>aqty)
	{
		$("#lblerr").html("Insuffient Quantity.");
	}
	else if(qty<aqty)
	{
		$("#lblerr").html("Invalid Quantity.");
	}
	else
	{
		$("#lblerr").html("");
	}
});
</script>

