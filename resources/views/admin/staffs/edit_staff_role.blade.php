
	<form method="POST" action="{{url('update-staff-role')}}" enctype="multipart/form-data">
	@csrf
	
	<input type="hidden" id="st_role_id" name="st_role_id" value="{{$sr->id}}">
	
	<div class="modal-body" style="padding-bottom:.5rem;">
		<div class="form-group">
		<label>Staff Role Name</label>
		   <input type="text" class="form-control input-default"  id="ed_role_name" name="ed_role_name" value="{{$sr->role_name}}" required>
		</div>
		
		<div class="form-group">
		<label>Role</label>
		   <select class="form-control" id="ed_role_id" name="ed_role_id" required>
		   <option value="">--select--</option>
		   @foreach($role as $r)
		   <option value="{{$r->id}}" @if($sr->role_id==$r->id){{__('selected')}}@endif>{{$r->role}}</option>
		   @endforeach
		   </select>
		  
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-secondary btn-size" >Save changes</button>
	   </div>
	</div>
	</form>
