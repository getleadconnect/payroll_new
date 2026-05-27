<form method="POST" action="{{url('save-labour-wage')}}" enctype="multipart/form-data">
@csrf
	
	<input type="hidden" class="form-control"  name="labour_id" value="{{$lbr->id}}">
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Name</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">
		   <input type="text" class="form-control input-default"  name="name" value="{{$lbr->name}}" required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Wage Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		   <input type="date" class="form-control input-default " id="wage_date" name="wage_date"  value="{{date('Y-m-d')}}" required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Normal</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="number" class="form-control input-default "  id="wage_normal" name="wage_normal" required>
		</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Concrete</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="number" class="form-control" id="wage_concrete" name="wage_concrete" required>
		</div>
	   </div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Over Time</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
			<select class="form-control input-default "  id="wage_ot" name="wage_ot" required>
			   <option value="">--select--</option>
			   <option value="1" selected>1</option>
			   <option value="1.25">1.25</option>
			   <option value="1.5">1.5</option>
		   </select>
		   
		</div>
		</div>
	</div>
	
	
	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
</form>

<script>

</script>

