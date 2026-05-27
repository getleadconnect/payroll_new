<form method="POST" action="{{url('save-salary-increment')}}" enctype="multipart/form-data">
		@csrf


		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">		
		 <input type="date" class="form-control" id="salary_date" name="salary_date"  required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff Name</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">		
		<select class="form-control" id="staff_id"  name="staff_id" required>
		   <option value="">--select--</option>
		   @foreach($stfs as $r)
			  <option value="{{$r->id}}" data-val="{{$r->current_salary}}">{{$r->name}}</option>
		   @endforeach
		   </select>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Old Salary</label>
		<div class="col-lg-8 col-xl-8 col-xxl-8">		
		 <input type="text" class="form-control input-default " id="old_salary" name="old_salary" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Percentage(%)</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default " id="percentage" name="percentage">
		</div>
		</div>
		</div>
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Increment</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default " id="increment" name="increment" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">OT Rate</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default " id="ot_rate" name="ot_rate" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sunday Rate</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">		
		 <input type="decimal" class="form-control input-default " id="sunday_rate" name="sunday_rate" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Salary</label>
		<div class="col-lg-6 col-xl-6 col-xxl-6">		
		 <input type="text" class="form-control input-default "  id="current_salary" name="current_salary" required>
		</div>
		</div>
		</div>
	
		<div class="modal-footer">
			<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
		</div>
		</form>
		
<script>

$("#staff_id").change(function()
{
	var old_sal=$('option:selected', this).attr('data-val');
	$("#old_salary").val(old_sal);
	
});

$("#percentage").keyup(function()
{
	var per=$(this).val();
	var old_sal=$("#old_salary").val();
	
	var sal_inc=parseFloat(old_sal)*(parseFloat(per)/100);
	$("#increment").val(sal_inc.toFixed(2));
	var cur_sal=parseFloat(old_sal)+parseFloat(sal_inc);
	$("#current_salary").val(cur_sal.toFixed(2));
	
});


$("#increment").keyup(function()
{
	var inc=$(this).val();
	var old_sal=$("#old_salary").val();
	var sal=parseFloat(old_sal)+parseFloat(inc);
	$("#current_salary").val(sal.toFixed(2));
	
});











</script>