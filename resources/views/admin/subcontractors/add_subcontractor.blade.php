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
.lbl-error
{
	font-size:11px;
	color:red;
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
						<h4 class="text-black fs-20">Add Sub-contractors</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('sub-contractors')}}" class="btn btn-secondary btn-size" ><i class="fas fa-file"></i> View Sub-contractors </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<form method="POST" action="{{url('save-subcontractor')}}" enctype="multipart/form-data">
				@csrf

					<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
					
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Name</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
							 <input type="text" class="form-control input-default "  name="name" value="{{old('name')}}" required>
						  </div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">GST Number</label>
						  <div class="col-lg-4 col-xl-4 col-xxl-4">
							 <input type="text" class="form-control input-default "  name="gst_no" value="{{old('gst_no')}}" required>
							 @if($errors->has('gst_no'))
							 <label class="lbl-error">{{ $errors->first('gst_no')}}</label>
							 @endif
						  </div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">PAN Number</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
							 <input type="text" class="form-control input-default "  name="pan_no" value="{{old('pan_no')}}" required>
							 @if($errors->has('pan_no'))
							 <label class="lbl-error">{{ $errors->first('pan_no')}}</label>
							 @endif
						  </div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label" style="padding-right:0px;">Contact Person</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
							 <input type="text" class="form-control input-default "  name="contact_person" value="{{old('contact_person')}}" required>
						  </div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Mobile</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
							 <input type="number" class="form-control input-default"  name="mobile" value="{{old('mobile')}}" required>
							 @if($errors->has('mobile'))
							 <label class="lbl-error">{{ $errors->first('mobile')}}</label>
							 @endif
						  </div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Address</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
							 <textarea class="form-control" name="address"  required>{{old('address')}}</textarea>
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
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">IFSC Code</label>
						  <div class="col-lg-6 col-xl-6 col-xxl-6">
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
					<h5 class="modal-title">Add Sub-contractor</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
	
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
			url:"view-subcontractors",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"30px","targets":0},
				  {"width":"70px","targets":1},
				  {"width":"50px","targets":2},
				  {"width":"200px","targets":6},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
			{"data": "sname" },
			{"data": "gst" },
			{"data": "cperson" },
			{"data": "add" },
			{"data": "bank" },
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
				url: "edit-subcontractor"+"/"+cid,
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
				url: "delete-subcontractor"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Sub-contractor details successfully removed.");
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
				url: "subcontractor_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Sub-contractor successfully Activated."); }
					  else{	alert("Sub-contractor successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
