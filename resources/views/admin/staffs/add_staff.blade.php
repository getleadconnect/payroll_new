@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')


<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="row">
					 
	<div class="col-xl-12 col-xxl-12 col-lg-12">
		<div class="card">
		
		    <div class="row card-title-align">
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<div class="card-header d-sm-flex d-block border-0" >
					<div class="mr-auto pr-3">
						<h4 class="text-black fs-20">Staff Details</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('staffs')}}" class="btn btn-secondary btn-size" ><i class="fas fa-file"></i> View Staffs </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<form method="POST" action="{{url('save-staff')}}" enctype="multipart/form-data">
				@csrf

				<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
				
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Join Date</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="date" class="form-control input-default "  name="join_date"  value="{{old('join_date')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Name</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="text" class="form-control input-default "  name="name"  value="{{old('name')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Address</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <textarea class="form-control"  name="address" required>{{old('address')}}</textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Gender</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6" style="display:flex;">
					     <input type="radio" class="ml-3"  name="gender" value="MALE" style="width:25px;height:25px;align-items:center;" @if(old('gender')=="MALE"){{__('checked')}}@endif required><span class="mt-1 pl-2">Male</span>
						 <input type="radio"  class="ml-3"  name="gender" value="FEMALE" style="width:25px;height:25px;align-items:center;" @if(old('gender')=="FEMALE"){{__('checked')}}@endif required><span class="mt-1 pl-2">Female</span>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Mobile</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="number" class="form-control input-default "  name="mobile" value="{{old('mobile')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Email</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="email" class="form-control input-default "  name="email" value="{{old('email')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Qualification</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="text" class="form-control input-default "  name="qualification" value="{{old('qualification')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Experience</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <textarea class="form-control"  name="experience">{{old('experience')}}</textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >Aaadhar No</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="text" class="form-control input-default "  name="aadhar_no" value="{{old('aadhar_no')}}"required>
					  </div>
					</div>
				</div>
				
				<!--<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >PAN No</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					     <input type="text" class="form-control input-default "  name="pan_no" value="{{old('pan_no')}}" required>
					  </div>
					</div>
				</div>-->
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >Staff Role</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					     <select class="form-control input-default "  name="staff_role_id" required>
						 <option value="">--select--</option>
						 @foreach($roles as $r)
						    <option value="{{$r->id}}" @if($r->id==old('staff_role_id')){{__('selected')}}@endif >{{$r->role_name}}</option>
						 @endforeach
						 </select>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >Salary</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					     <input type="number" class="form-control input-default "  name="salary" value="{{old('salary')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >Ot Rate</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="decimal" class="form-control input-default "  name="ot_rate" value="{{old('ot_rate')}}">
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" >Sunday Rate</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="decimal" class="form-control input-default "  name="sunday_rate" value="{{old('sunday_rate')}}">
					  </div>
					</div>
				</div> 
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Bank Name</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="text" class="form-control input-default "  name="bank_name" value="{{old('bank_name')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Bank IFSC</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="text" class="form-control input-default "  name="bank_ifsc" value="{{old('bank_ifsc')}}" required>
					  </div>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Bank A/C No</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="text" class="form-control input-default "  name="bank_account_no" value="{{old('bank_account_no')}}" required>
					  </div>
					</div>
				</div>


				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">State</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="text" class="form-control input-default "  name="state" value="{{old('state')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">District</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					     <input type="text" class="form-control input-default "  name="district" value="{{old('district')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Nationality</label>
					  <div class="col-lg-6 col-xl-6 col-xxl-6">
					      <input type="text" class="form-control input-default "  name="nationality" value="{{old('nationality')}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					  <div class="offset-lg-2 col-lg-6 col-xl-6 col-xxl-6">
					      <button type="submit" class="btn btn-secondary btn-size">Save changes</button>
					  </div>
					</div>
				</div>

				</form>
				
			</div>
		</div>
	</div>
			 
</div>


	<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				
			</div>
		</div>
	</div>



@push('scripts')

<script>

$(document).ready(function()
{
	var mes=$('#view_message').val().split('#');
	if(mes[0]=="success")
	{	
	    toastr.success(mes[1]);
	}
	else if(mes[0]=="danger")
	{
		toastr.error(mes[1]);
	}
});


var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :50,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,

        ajax:
		{
			url:"view-staffs",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"30px","targets":0},
				  {"width":"70px","targets":1},
				  {"width":"50px","targets":2},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
			{"data": "name" },
			{"data": "address" },
			{"data": "mob" },
			{"data": "quali" },
			{"data": "aadhar" },
			{"data": "bank" },
			{"data": "esic" },
			{"data": "role" },
			{"data": "sal" },
			{"data": "state" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-staff"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });
  
$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-staff"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Supplier details successfully removed.");
				   }
				}
			});
		}
		
  });
    
    
  $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var cid=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "staff_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Staff successfully Activated."); }
					  else{	alert("Staff successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
