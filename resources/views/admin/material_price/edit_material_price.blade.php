<form method="POST" action="{{url('update-material-price')}}" enctype="multipart/form-data">
	@csrf

	<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
	
	<input type="hidden" class="form-control" name="ed_mat_price_id" value="{{$mp->id}}">
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg"  name="ed_project_id" required>
		   <option value="">--select--</option>
		   @foreach($proj as $r)
			<option value="{{$r->id}}" @if($r->id==$mp->project_id){{__('selected')}}@endif>{{$r->project_name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Supplier</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg"  name="ed_supplier_id" required>
		   <option value="">--select--</option>
		   @foreach($supp as $r)
			<option value="{{$r->id}}" @if($r->id==$mp->supplier_id){{__('selected')}}@endif>{{$r->supplier_name}}</option>
		   @endforeach
		   
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Material Type</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg"  id="ed_material_type_id" name="ed_material_type_id" required>
		   <option value="">--select--</option>
		   @foreach($mtype as $r)
			<option value="{{$r->id}}" @if($r->id==$mp->material_type_id){{__('selected')}}@endif>{{$r->material_type_name}}</option>
		   @endforeach
		   
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sub Type</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control form-control-lg" id="ed_material_sub_type_id" name="ed_material_sub_type_id" required>
		   <option value="">--select--</option>
		   @foreach($mstype as $r)
			<option value="{{$r->id}}" @if($r->id==$mp->material_sub_type_id){{__('selected')}}@endif>{{$r->sub_type_name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
		  <div class="col-lg-5 col-xl-5 col-xxl-5">
			 <input type="date" class="form-control input-default" name="ed_price_date" value="{{$mp->price_date}}" required>
		  </div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Unit</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		   <select class="form-control form-control-lg"  name="ed_material_unit_id"  required>
		   <option value="">--select--</option>
		   @foreach($munit as $r)
			<option value="{{$r->id}}" @if($r->id==$mp->material_unit_id){{__('selected')}}@endif>{{$r->unit_name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
		</div>
	<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Price</label>
		  <div class="col-lg-5 col-xl-5 col-xxl-5">
			 <input type="number" class="form-control input-default" step="any" name="ed_price" value="{{$mp->price}}" required>
		  </div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
	</form>
				

<script>

$("#ed_material_type_id").change(function()
{
	var id=$(this).val();
  		jQuery.ajax({
				type: "GET",
				url: "get-material-sub-types"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				  $("#ed_material_sub_type_id").html(res);
				}
			});
	
});

</script>

