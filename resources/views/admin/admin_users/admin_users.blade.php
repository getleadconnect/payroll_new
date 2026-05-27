@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
table.dataTable thead th, table.dataTable tfoot th {
    font-size: 13px !important;
    font-weight: 600 !important;
}
.dataTables_scroll
{
	padding:0rem !important;
}
.dataTables_wrapper .dataTables_length {
    margin-bottom: 5px;
}

.paginate_button {
    min-width: 50px;
	min-height: 35px !important;
}	
.dataTables_wrapper .dataTables_paginate .paginate_button.previous, 
.dataTables_wrapper .dataTables_paginate .paginate_button.next {
    background: transparent !important;
    color: #3695eb !important;
    padding: 7px 20px;
}
</style>

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
						<h4 class="text-black fs-20">Admin Users</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="d-flex py-3 align-items-center">


					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Staff_ID</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>Role</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div><!-- d-flex end ------->
				
			</div>
		</div>
	</div>
			 
</div>

	<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add User</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<form method="POST" action="{{url('save-admin-user')}}" enctype="multipart/form-data">
				@csrf
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Staff</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <select class="form-control" id="staff_id"  name="staff_id" required>
				   <option value="">--select--</option>
				   @foreach($staffs as $r)
					  <option value="{{$r->id}}">{{$r->name }}</option>
				   @endforeach
				   </select>
				   </div>
				</div>
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Name</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                   <input type="text" class="form-control input-default " id="name"  name="name" required>
				</div>
				</div>
                </div>
				
				<div class="form-group">
				
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Mobile</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <input type="number" class="form-control input-default " id="mobile"  name="mobile" required>
				   </div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Email</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <input type="email" class="form-control input-default " id= "email" name="email" required>
				   @if($errors->has('email'))
						 <label class="lbl-error">{{$errors->first('email')}}</label>
				   @endif
				   </div>
				</div>
                   
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Staff Role</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                  <select name="staff_role" class="form-control" required>
					<option value="">--select--</option>
					@foreach($stroles as $r)
					<option value="{{$r->id}}">{{$r->role_name}}</option>
					@endforeach
					</select>
				   </div>
				</div>
								
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Password</label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
                 <input type="text" class="form-control input-default "  name="password" required>
				</div>
				</div>
                   
                </div>
				
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
				</div>
				</form>
				
			</div>
		</div>
	</div>

<div class="modal fade" id="basicModal-2" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="basicModal-3" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Change Password</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body pb-2">
				<form method="POST"  id="changePassword" enctype="multipart/form-data">
				@csrf
				
				<input type="hidden" id="admin_user_id" name="admin_user_id" required>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">New Password</label>
				<div class="col-lg-7 col-xl-7 col-xxl-7">
                 <input type="text" class="form-control input-default " id="new_password" name="new_password" required>
				</div>
				</div>
                   
                </div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Confirm Password</label>
				<div class="col-lg-7 col-xl-7 col-xxl-7">
                 <input type="text" class="form-control input-default" id="conf_password" name="conf_password" required>
				</div>
				</div>
					<label class="mt-2" id="cp_mes" style="width:100%;font-size:12px;text-align:center;"> </label>
                </div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-secondary btn-size">Submit</button>
				</div>
				</form>
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
			url:"view-admin-users",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"70px","targets":2},
				  {"width":"110px","targets":7},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "stf_id" },
			{"data": "name" },
			{"data": "mobile" },
			{"data": "email" },
			{"data": "role" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$('#staff_id').change(function ()
  {
	var sid=$(this).val();

		jQuery.ajax({
			type: "GET",
			url: "get-staff"+"/"+sid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  var dt=$.parseJSON(res);
			  $("#name").val(dt.name);
			  $("#mobile").val(dt.mobile);
			  $("#email").val(dt.email);
			}
		});
  });
  
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-admin-user"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });
  
  $('#datatable tbody').on( 'click', '.changePass', function ()
  {
		var id=$(this).attr('id');
		$("#admin_user_id").val(id);
		
		$("#new_password").val('');
		$("#conf_password").val('');
		$("#cp_mes").html('');
		
		var Result=$("#basicModal-3 .modal-body");
		$(this).attr('data-target','#basicModal-3');
  });
  
  
$("form#changePassword").submit(function(e)
{
   e.preventDefault();    

	if($("#new_password").val()!='' && $("#conf_password").val()!='')
	{

	  if($("#new_password").val()!= $("#conf_password").val())
	  {
		 $("#cp_mes").html('<span style="color:red;">Password not matching.</span>'); 
	  }
	  else
	  {
		  var formData = new FormData(this);
			
		   $.ajax({
			  url: "{{url('update-admin-password')}}",
			  type: 'post',
			  data: formData,
			  success: function (res) 
			  {
				if(res==1)
				{
					$("#cp_mes").html('<span style="color:green;">Password successfully changed.</span>');
				}
				else
				{
					$("#cp_mes").html('<span style="color:green;">Password not maching/missing, try again.</span>');
					
				}
			  },
				cache: false,
				contentType: false,
				processData: false
			});
	  }
	}
	else
	{
		alert("New password data missing.");
	}

});
  
  
  
$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-client"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Client successfully removed.");
				   }
				}
			});
		}
		
  });
  
  
   $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this user?"))
		{
			var cid=$(this).attr('id');
			
				jQuery.ajax({
				type: "GET",
				url: "admin-activate-deactivate"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Client successfully Activated."); }
					  else{	alert("Client successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
