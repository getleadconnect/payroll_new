<form method="POST" action="{{url('update-subcontractor-work')}}" enctype="multipart/form-data">
	@csrf

		<input type="hidden" name="ed_subcon_work_id" value="{{$sc->id}}">

		<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Sub-Contractor</label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
			 <select class="form-control input-default " id="ed_subcontractor_id" name="ed_subcontractor_id" required>
				<option value="">--select--</option>
				@foreach($scon as $r)
				  <option value="{{$r->id}}" @if($r->id==$sc->subcontractor_id){{__('selected')}}@endif>{{ $r->name }}</option>
				@endforeach
			 </select>
			</div>
		</div>
		</div>

		<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Floor No</label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
			  <select class="form-control input-default " id="ed_floor_no"  name="ed_floor_no" required >
				<option value="">--select--</option>

				@foreach($floors as $key=>$r)
				  <option value="{{$r->id}}" @if($r->id==$sc->floor_no_id){{__('selected')}}@endif>{{$r->floor_no}}</option>
				@endforeach
			 </select>
			</div>
			
			</div>
		</div>
				
		<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
			  <select class="form-control input-default " id="ed_item_id"  name="ed_item_id" required >
				<option value="">--select--</option>

				@foreach($sitems as $r)
				  <option value="{{$r->id}}" @if($r->id==$sc->subcontractor_rate_id){{__('selected')}}@endif>{{ $r->item_name }}</option>
				@endforeach
				
			 </select>
			</div>
			
			</div>
		</div>
	
		<div class="form-group">
			<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Unit</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="hidden" class="form-control" id="ed_unit_id" name="ed_unit_id" value="{{$unit->id}}">  <!-- unit id --->
			  <input type="text" class="form-control input-default " id="ed_unit_name" name="ed_unit_name" value="{{$unit->unit_name}}" readonly>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		  <div class="row">	
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label"  >Nos</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_nos" name="ed_nos" value="{{$sc->nos}}" required>
			</div>
		</div>
		</div>	
		
		<div class="form-group">
		  <div class="row">	
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label"  >Length</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_length" name="ed_length" value="{{$sc->length}}" required>
			</div>
		</div>
		</div>	
		
		<div class="form-group">
		  <div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Width</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_width" name="ed_width" value="{{$sc->width}}" required>
			</div>
			</div>
		</div>
		<div class="form-group">
		  <div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Bredth</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_bredth" name="ed_bredth" value="{{$sc->bredth}}" required>
			</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="row">
			
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Rate</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_item_rate" name="ed_item_rate" value="{{$sc->item_rate}}" readonly  required>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		  <div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Quantity</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_quantity" name="ed_quantity"  value="{{$sc->quantity}}"required>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		  <div class="row">	
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Amount</label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			  <input type="number" class="form-control input-default " step="any" id="ed_amount" name="ed_amount"  value="{{$sc->amount}}" required>
			</div>
		  </div>
		</div>
		
		<div class="form-group">
		  <div class="row">	
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Description</label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			  <textarea class="form-control" id="ed_description" name="ed_description">{{$sc->description}}</textarea>
			</div>
		  </div>
		</div>
		
		<div class="modal-footer">
			 <button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-secondary btn-size"> Submit </button>
		</div>
		
		</form>

<script>

var unit=$("#ed_unit_name").val();
/*if(unit=="SQFT" || unit=="SQM" || unit=="SFT" || unit=="CFT")
{
	$("#ed_length").prop('readonly',false);
	$("#ed_width").prop('readonly',false);
	$("#ed_bredth").prop('readonly',false);
	$("#ed_length").prop('required',true);
	$("#ed_width").prop('required',true);
	$("#ed_bredth").prop('required',true);
}
else
{
	$("#ed_length").prop('readonly',true);
	$("#ed_width").prop('readonly',true);
	$("#ed_length").prop('required',false);
	$("#ed_width").prop('required',false);
}
*/
			  
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


$("#ed_subcontractor_id").change(function()
{
	var scid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-items-by-subcontractor-id"+"/"+scid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#ed_item_id").html(res);
			}
		});
});

$("#ed_item_id").change(function()
{
	var rate_id=$(this).val();
	var scid=$("#subcontractor_id").val();
	
		jQuery.ajax({
			type: "GET",
			url: "get-sub-contractor-itemunit-rate"+"/"+rate_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
				var dt=jQuery.parseJSON(res);
				$("#ed_quantity").val('');
				$("#ed_amount").val('');
				
			   $("#ed_unit_name").val(dt.unit);
			   $("#ed_unit_id").val(dt.unit_id);
			   $("#ed_item_rate").val(dt.price);
			   if(dt.unit=="SQFT" || dt.unit=="SQM" || dt.unit=="SFT" || dt.unit=="CFT")
			   {
				   $("#ed_length" ).prop('readonly',false);
				   $("#ed_width").prop('readonly',false);
				   $("#ed_length").prop('required',true);
				   $("#ed_width").prop('required',true);
			   }
			   else
			   {
				  $("#ed_length").prop('readonly',true);
				  $("#ed_width").prop('readonly',true);
				  $("#ed_length").prop('required',false);
				  $("#ed_width").prop('required',false);
			   }
			}
		});
});

$("#ed_quantity").focus(function()
{
	var no=parseFloat($("#ed_nos").val());
	var len=parseFloat($("#ed_length").val());
	var wid=parseFloat($("#ed_width").val());
	var bid=parseFloat($("#ed_bredth").val());
	var rate=parseFloat($("#ed_item_rate").val());
	
	if(len==""){ len=1;}
	if(wid==""){ wid=1;}
	if(bid==""){ bid=1;}
		
	if(len!="" && wid!="" && bid!="" && no!="")
	{
		var qty=len*wid*bid*no;
		
		$("#ed_quantity").val(qty.toFixed(2));
		var amt=(qty*rate).toFixed(2);
		$("#ed_amount").val(amt);
	}
});

$("#ed_amount").focus(function()
{
	var no=parseFloat($("#ed_nos").val());
	var len=parseFloat($("#ed_length").val());
	var wid=parseFloat($("#ed_width").val());
	var bid=parseFloat($("#ed_bredth").val());
	var rate=parseFloat($("#ed_item_rate").val());
	
	if(len==""){ len=1;}
	if(wid==""){ wid=1;}
	if(bid==""){ bid=1;}
		
	if(len!="" && wid!="" && no!="")
	{
		var qty=len*wid*bid*no;

		var amt=qty*rate;
		
		$("#ed_quantity").val(qty.toFixed(2));
		$("#ed_amount").val(amt.toFixed(2));
	}
	
});


$("#ed_length").keyup(function()
{
	$("#ed_quantity").val('');
	$("#ed_amount").val('');
});

$("#ed_bredth").keyup(function()
{
	$("#ed_quantity").val('');
	$("#ed_amount").val('');
});

$("#ed_width").keyup(function()
{
	$("#ed_quantity").val('');
	$("#ed_amount").val('');
});
  
</script>

