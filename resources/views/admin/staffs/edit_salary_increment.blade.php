<form method="POST" action="{{url('update-salary-increment')}}" enctype="multipart/form-data">
		@csrf

		<input type="hidden" name="ed_salary_id" value="{{$si->id}}">
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">		
		 <input type="date" class="form-control" id="ed_salary_date" name="ed_salary_date" value="{{date('Y-m-d')}}" required>
		</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff Name</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">		
		   <input type="text" class="form-control input-default" id="ed_name" name="ed_name" value="{{$si->name}}" readonly>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Old Salary</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">		
		 <input type="text" class="form-control input-default" id="ed_old_salary" name="ed_old_salary" value="{{$si->old_salary}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Percentage(%)</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default" id="ed_percentage" name="ed_percentage" value="{{$si->percentage}}">
		</div>
		</div>
		</div>
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Increment</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default" id="ed_increment" name="ed_increment" value="{{$si->increment}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">OT Rate</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default" id="ed_ot_rate" name="ed_ot_rate" value="{{$si->ot_rate}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sunday Rate</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default" id="ed_sunday_rate" name="ed_sunday_rate" value="{{$si->sunday_rate}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Salary</label>
		<div class="col-lg-6 col-xl-6 col-xxl-6">		
		 <input type="text" class="form-control input-default" id="ed_current_salary" name="ed_current_salary" value="{{$si->current_salary}}" required>
		</div>
		</div>
		</div>
	
		<div class="modal-footer">
			<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size">Update changes</button>
		</div>
		</form>
		
<script>

$("#ed_staff_id").change(function()
{
	var old_sal=$('option:selected', this).attr('data-val');
	$("#ed_old_salary").val(old_sal);
	
});

$("#ed_percentage").keyup(function()
{
	var per=$(this).val();
	var old_sal=$("#ed_old_salary").val();
	
	var sal_inc=parseFloat(old_sal)*(parseFloat(per)/100);
	$("#ed_increment").val(sal_inc);
	$("#ed_current_salary").val(parseFloat(old_sal)+parseFloat(sal_inc));
	
});


$("#ed_increment").keyup(function()
{
	var inc=$(this).val();
	var old_sal=$("#ed_old_salary").val();
	
	var sal=parseFloat(old_sal)+parseFloat(inc);
	$("#ed_current_salary").val(sal);
	
});











</script>