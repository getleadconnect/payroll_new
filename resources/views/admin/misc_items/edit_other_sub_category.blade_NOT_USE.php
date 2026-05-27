<form method="POST" action="{{url('update-other-sub-category')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" id="ed_other_subcat_id" name="ed_other_subcat_id" value="{{$sc->id}}">
	
	<div class="modal-body" style="padding-bottom:.5rem;">
		<div class="form-group">
		<label>Category Name</label>
		   <select class="form-control"  name="ed_other_category_id" required>
		   <option value="">--select--</option>
		   @foreach($cats as $r)
		   <option value="{{$r->id}}" @if($r->id==$sc->other_category_id){{__('selected')}}@endif>{{$r->other_category_name}}</option>
		   @endforeach
		   </select>
		</div>
		
		<div class="form-group">
		<label>Sub-Category Name</label>
		   <input type="text" class="form-control input-default"  name="ed_sub_category_name" value="{{$sc->sub_category_name}}" required>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size">Update changes</button>
	   </div>
	</div>
	</form>