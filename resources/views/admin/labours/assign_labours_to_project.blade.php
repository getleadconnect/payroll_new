<form method="POST" action="{{url('save-labours-to-project')}}" enctype="multipart/form-data">
@csrf
	
	<input type="hidden" class="form-control"  name="labour_id" value="{{$lbrids}}">
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Selected Labours</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		   <input type="text" class="form-control" value="{{$lbrcnt}}" readonly >
		</div>
	   </div>
	</div>
	
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Select Project</label>
		<div class="col-lg-7 col-xl-7 col-xxl-7">
		   <select class="form-control input-default "  id="project_id" name="project_id" required>
			   <option value="">--select--</option>
			@foreach($pros as $r)
			   <option value="{{$r->id}}">{{$r->project_name}}</option>
			 @endforeach
		   </select>
		</div>
	   </div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Start Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		   <input type="date" class="form-control" name="start_date" required>
		</div>
	   </div>
	</div>
	
	<div class="form-group">
		<div class="row">
		<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">End Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		  <input type="date" class="form-control" name="end_date" required> 
		</div>
	   </div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
	</div>
</form>


<script>

$("#project_id").select2();

$("#wage_concrete").change(function()
{
	var normal=parseInt($("#wage_normal").val());
	var con=normal+parseInt($(this).val());
	$("#wage_con").val(con);
	
	var val1=((normal*1)/8).toFixed(2);
	var val2=((normal*1.25)/8).toFixed(2);
	var val3=((normal*1.5)/8).toFixed(2);
	
	var opt="<option value=''>--select--</option><option value='"+val1+"'>"+val1+"</option>";
		opt+="<option value='"+val2+"'>"+val2+"</option>";
		opt+="<option value='"+val3+"'>"+val3+"</option>";
	
	$("#wage_ot").empty();
	$("#wage_ot").append(opt);
	
});

</script>

