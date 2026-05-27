<style>

.st_radio
{
	width:25px;
	height:25px;
}
</style>

<form  method="POST" action="{{url('update-revenue')}}" enctype="multipart/form-data">
@csrf

  <input type="hidden" name="ed_revenue_id" value="{{$rv->id}}" required>
	
   <label class="mt-2" style="font-size:13px;"><b><u>Add Revenue</u></b></label>
	
		<div class="form-group mt-2">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label" >Revenue Type </label>
			<div class="col-lg-6 col-xl-6 col-xxl-6" style="display:flex;align-items:center;" >
				<input type="radio" name="ed_revenue_type" class="st_radio" value="GET" @if($rv->revenue_type=="GET"){{__('checked')}}@endif  required ><span class="pt-1 pr-3">&nbsp;&nbsp;GET</span> 
				<input type="radio" name="ed_revenue_type" class="st_radio" value="RETURN" @if($rv->revenue_type=="RETURN"){{__('checked')}}@endif required><span class="pt-1">&nbsp;&nbsp;RETURN</span> 
			</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date </label>
			<div class="col-lg-5 col-xl-5 col-xxl-5">
			<input type="date" class="form-control" name="ed_entry_date" value="{{$rv->entry_date}}" required>
			</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project </label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<select type="text" class="form-control" id="ed_roject_id" name="ed_project_id" required>
			<option value="">--select--</option>
			@foreach($projs as $r)
			  <option value="{{$r->id}}" @if($r->id==$rv->project_id){{ __('selected')}}@endif >{{ $r->project_name }}</option>
			@endforeach
			</select>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Staff </label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<select type="text" class="form-control" id="ed_staff_id" name="ed_staff_id" required>
			<option value="">--select--</option>
			@foreach($stf as $r)
			  <option value="{{$r->id}}" @if($r->id==$rv->staff_id){{__('selected')}}@endif>{{ $r->name }}</option>
			@endforeach
			</select>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Transfer </label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<select type="text" class="form-control" id="ed_cash_cheque" name="ed_cash_cheque" required>
			<option value="">--select--</option>
			 <option value="CASH" @if($rv->cash_cheque=="CASH"){{__('selected')}}@endif>CASH</option>
			  <option value="CHEQUE" @if($rv->cash_cheque=="CHEQUE"){{__('selected')}}@endif>CHEQUE</option>
			</select>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Voucher No </label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<input type="number" step="any" class="form-control" name="ed_voucher_no"  value="{{$rv->voucher_no}}" required>
			</div>
		</div>
		</div>
		
		
		<div class="form-group">
		  <div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Voucher Date </label>
			<div class="col-lg-5 col-xl-5 col-xxl-5">
			<input type="date" class="form-control" name="ed_voucher_date" value="{{$rv->voucher_date}}" required>
			</div>
		  </div>
		</div>
		
		<div class="form-group">
		  <div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
			<div class="col-lg-5 col-xl-5 col-xxl-5">
			
			@php
			if($rv->revenue_type=="GET"){$amt=$rv->income;}else{$amt=$rv->expense;}
			@endphp			
			
			<input type="number" step="any"  class="form-control" name="ed_amount" value="{{$amt}}" required>
					
			
			</div>
		  </div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description </label>
			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<textarea class="form-control" name="ed_description" required>{{$rv->description}}</textarea>
			</div>
		</div>
		</div>
								
		<div class="modal-footer">
		<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-secondary btn-size" >Update Changes</button>
		</div>

    </form>

<script>

$("#ed_project_id").change(function()
{
	var id=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get-project-staffs"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#ed_staff_id").html(res);
		}
	});
});



</script>