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
						<h4 class="text-black fs-20">Payment Types</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#basicModal-1" style="padding:8px 20px;"><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			<div class="row">
			{{--<div class="col-lg-4 col-xl-4 col-xxl-4">
						
			<div class="mt-3">
			<label class="mb-3" style="font-size:11px;"><b><u>Add Payment Type</u></b> </label>
				<form method="POST" action="{{url('save-payment-type')}}" enctype="multipart/form-data">
				@csrf

					<div class="form-group">
					<label>Payment Type</label>
					   <input type="text" class="form-control input-default"  name="payment_type" required>
					   @if($errors->has('payment_type'))
						 <label class="lbl-error">{{$errors->first('payment_type')}}</label>
					   @endif
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
					</div>
				</form>
				</div>
			</div> --}}
			
			<div class="col-lg-8 col-xl-8 col-xxl-8">
				<div class="d-flex py-3 align-items-center">
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Payment_Type</th>
									<th>Added_By</th>
									<!--<th>Action</th>-->
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div><!-- d-flex end ------->
				
			</div>
			</div>
			</div><!-- row end ---->
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
				<form method="POST" action="{{url('update-payment-type')}}" enctype="multipart/form-data">
				@csrf
				
				<input type="hidden" id="ed_payment_type_id" name="ed_payment_type_id">
				
				<div class="modal-body" style="padding-bottom:.5rem;">
					<div class="form-group">
					<label>Payment Type</label>
					   <input type="text" class="form-control input-default"  id="ed_payment_type" name="ed_payment_type" required>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger light btn-size" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-secondary btn-size" >Save changes</button>
				   </div>
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
			url:"view-payment-types",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"50px","targets":0},
			  
				],
	
        columns: [
            {"data": "id" },
			{"data": "ptype" },
			{"data": "addedby" },
			//{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	var ptype=$(this).attr('data-val');
	var pmode=$(this).attr('data-mode');
	
	$("#ed_payment_type_id").val(id);
	$("#ed_payment_type").val(ptype);
	$("#ed_payment_mode").val(pmode);
	
	$(this).attr('data-target','#basicModal-1');

  });
  
$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-payment-type"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Payment type successfully removed.");
				   }
				}
			});
		}
		
  });
  
 
  
</script>

@endpush

@endsection
