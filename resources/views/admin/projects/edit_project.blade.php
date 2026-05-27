<form method="POST" action="{{url('update-project')}}" enctype="multipart/form-data">
	@csrf
		<input type="hidden" name="ed_project_id" value="{{$pr->id}}">
		<input type="hidden" name="ed_company_id" value="{{$company->id}}">				

				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Client</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					 
					 <select class="form-control form-control-lg" name="ed_client_id" required>
					   <option value="">--select--</option>
					   @foreach($client as $r)
					    <option value="{{$r->id}}" @if($r->id==$pr->client_id){{__('selected')}}@endif>{{$r->client_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Type</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" name="ed_project_type_id" required>
					   <option value="">--select--</option>
					   @foreach($ptype as $r)
					    <option value="{{$r->id}}" @if($r->id==$pr->project_type_id){{__('selected')}}@endif>{{$r->project_type}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Name</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <input type="text" class="form-control input-default" name="ed_project_name" value="{{$pr->project_name}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Address</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control" name="ed_address"  required>{{$pr->address}}</textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control" name="ed_description"  required>{{$pr->description}}</textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Cost</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="number" class="form-control input-default"  name="ed_cost" value="{{$pr->cost}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Start Date</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="date" class="form-control input-default "  name="ed_start_date" value="{{$pr->start_date}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Finish Date</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="date" class="form-control input-default "  name="ed_finish_date" value="{{$pr->finish_date}}" required>
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

