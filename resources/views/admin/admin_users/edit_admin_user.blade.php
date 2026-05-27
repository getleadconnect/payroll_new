<style>
.required{
	color:red;
	font-size:12px;
}
</style>

<form method="POST" action="{{url('update-admin-user')}}" enctype="multipart/form-data">
@csrf
	<label> <span class="required">*: fields are mandatory</span></label>

			<input type="hidden" class="form-control"  name="ed_admin_id" value="{{$au->id}}">
			<input type="hidden" class="form-control"  name="ed_old_email" value="{{$au->email}}">
	
			<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Name<span class="required">*</span></label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                   <input type="text" class="form-control input-default "  name="ed_name" value="{{$au->name}}" required>
				</div>
				</div>
                </div>
				
				<div class="form-group">
				
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Mobile<span class="required">*</span></label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <input type="number" class="form-control input-default "  name="ed_mobile" value="{{$au->mobile}}" required>
				   </div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Email<span class="required">*</span></label> 
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <input type="email" class="form-control input-default "  name="ed_email" value="{{$au->email}}" required>
				   @if($errors->has('email'))
						 <label class="lbl-error">{{$errors->first('email')}}</label>
				   @endif
				   </div>
				</div>
                   
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Role<span class="required">*</span></label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <select name="ed_staff_role" class="form-control" required>
					<option value="">--select--</option>
					@foreach($roles as $r)
					<option value="{{$r->id}}" @if($r->id==$au->staff_role_id){{__('selected')}}@endif>{{$r->role_name}}</option>
					@endforeach
					
					</select>
				   </div>
				</div>
								
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Password</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                 <input type="text" class="form-control input-default " name="ed_password">
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

