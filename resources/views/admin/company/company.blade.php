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
						<h4 class="text-black fs-20">Company</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="row">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				<form method="POST" action="{{url('save-company')}}" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group">
				<label>Company Name</label>
                   <input type="text" class="form-control input-default "  name="company_name" value="{{$cm->company_name}}" required>
                </div>
				
				<div class="form-group">
				<label>Address</label>
                   <textarea class="form-control" name="address"  required>{{$cm->address}}</textarea>
                </div>
				
				<div class="form-group">
				<label>GST Number</label>
                   <input type="text" class="form-control input-default " name="gst_no" value="{{$cm->gst_no}}" required>
                </div>
				
				<div class="form-group">
				<label>PAN Number</label>
                   <input type="text" class="form-control input-default " name="pan_no" value="{{$cm->pan_no}}" required>
                </div>
				
				<div class="form-group">
				<label>Others</label>
                   <textarea class="form-control" name="others" >{{$cm->others}}</textarea>
                </div>
				
				<div class="form-group text-right">
                   <button type="submit" class="btn btn-secondary btn-size">Update changes</button>
                </div>

				</form>
				
				</div>
				</div>
			
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Company Name</th>
									<th>Address</th>
									<th>GST-No</th>
									<th>PAN-No</th>
									<th>Other</th>
									<th>Status</th>
									<th>Added_By</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div>
				</div>
				
			</div>
		</div>
	</div>
			 
</div>

	<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Company</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<form method="POST" action="{{url('save-company')}}" enctype="multipart/form-data">
				@csrf
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<div class="form-group">
				<label>Company Name</label>
                   <input type="text" class="form-control input-default "  name="company_name" required>
                </div>
				
				<div class="form-group">
				<label>Address</label>
                   <textarea class="form-control" name="address"  required></textarea>
                </div>
				
				<div class="form-group">
				<label>Email</label>
                   <input type="email" class="form-control input-default " name="email" required>
                </div>
				
				<div class="form-group">
				<label>Conatact No</label>
                   <input type="text" class="form-control input-default " name="mobile" required>
                </div>
				
				<div class="form-group">
				<label>GST Number</label>
                   <input type="text" class="form-control input-default " name="gst_no" required>
                </div>
				
				<div class="form-group">
				<label>PAN Number</label>
                   <input type="text" class="form-control input-default " name="pan_no" required>
                </div>
				
				<div class="form-group">
				<label>Others</label>
                   <textarea class="form-control" name="others" ></textarea>
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
			url:"view-company",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"50px","targets":0},
				   {"width":"100px","targets":1},
				  {"width":"70px","targets":6},
				 
				],
	
        columns: [
            {"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "cname" },
			{"data": "add" },
			{"data": "gstno" },
			{"data": "panno" },
			{"data": "other" },
			{"data": "status" },
			{"data": "user"},
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
				url: "edit-company"+"/"+cid,
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
				url: "delete-company"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Company successfully removed.");
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
				url: "company_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Company successfully Activated."); }
						else{	alert("Company successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
