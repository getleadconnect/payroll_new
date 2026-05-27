<form method="POST" action="{{url('update-bonus')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" name="ed_bonus_id" value="{{$sb->id}}">

		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Staff</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		   <select class="form-control" name="ed_staff_id" required>
			   <option value="">--select--</option>
			   @foreach($stfs as $r)
			   <option value="{{$r->id}}" @if($r->id==$sb->staff_id){{__('selected')}}@endif>{{$r->name}}</option>
			   @endforeach
		   </select>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2">Bonus Date</label>
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		    <input type="date" class="form-control input-default" style="width:150px;" name="ed_bonus_date" value="{{date('Y-m-d')}}" required>
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Title</label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
		    <input type="text" class="form-control input-default" name="ed_title" value="{{$sb->title}}" required>
		</div>
		</div>
		</div>

		<div class="form-group">
		<div class="row">
		<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Amount</label>
		<div class="col-lg-4 col-xl-4 col-xxl-4">
		    <input type="text" class="form-control input-default" style="width:150px;"  name="ed_amount"  value="{{$sb->amount}}" required>
		</div>
		</div>
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size" >Update changes</button>
	   </div>
	   
	</form>
	
	<script>
	
	</script>