<form method="POST" action="{{url('update-subcontractor-rate')}}" enctype="multipart/form-data">
				@csrf
				
			<input type="hidden" class="form-control"  name="ed_subcon_rate_id" value="{{$sr->id}}">	
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					  <select class="form-control input-default " id="ed_project_id" name="ed_project_id" required>
						<option value="">--select--</option>
						@foreach($proj as $r)
						  <option value="{{$r->id}}" @if($r->id==$sr->project_id){{__('selected')}}@endif>{{ $r->project_name }}</option>
						@endforeach
					  </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Contractor</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					 <select class="form-control input-default " id="ed_subcontractor_id" name="ed_subcontractor_id" required>
						<option value="">--select--</option>
						@foreach($scon as $r)
						  <option value="{{$r->id}}" @if($r->id==$sr->subcontractor_id){{__('selected')}}@endif>{{ $r->name }}</option>
						@endforeach
					 </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					  <select class="form-control input-default " id="ed_item_id"  name="ed_item_id" required>
						<option value="">--select--</option>
						@foreach($scitems as $r)
						  <option value="{{$r->id}}" @if($r->id==$sr->subcontractor_item_id){{__('selected')}}@endif>{{ $r->item_name }}</option>
						@endforeach
					 </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Unit Name</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <input type="text" class="form-control input-default " id="ed_unit_name" name="ed_unit_name" value="{{$item_unit}}" readonly>
					</div>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <input type="date" class="form-control input-default " name="ed_item_date" value="{{$sr->item_date}}" required>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Rate</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <input type="number" class="form-control input-default " step="any" name="ed_item_rate" value="{{$sr->item_rate}}" required>
					</div>
					</div>
				</div>

				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
				</div>
				</form>


<script>


$("#ed_item_id").change(function()
{
	var scid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-subcontractor-item-unit-name"+"/"+scid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#ed_unit_name").val(res);
			}
		});
});
</script>

