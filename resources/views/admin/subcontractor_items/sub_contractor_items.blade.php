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
						<h4 class="text-black fs-20">Sub-contractor Items</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			<label class="mb-2 mt-2" style="font-size:12px;"><b><u>Add Items</u></b> </label>
			
			<div class="row">
			<div class="col-lg-4 col-xl-4 col-xxl-4">
			
			
			<form method="POST" action="{{url('save-subcontractor-item')}}" enctype="multipart/form-data">
				@csrf
			<div class="form-group">
					<label>Item Name</label>
					<input type="text" class="form-control input-default"  name="item_name" required>
			</div>
					
			<div class="form-group">
					<label >Units</label>
					   <select class="form-control form-control-lg" id="unit_id"  name="unit_id" required>
					   <option value="">--select--</option>
					   @foreach($units as $r)
					    <option value="{{$r->id}}">{{$r->unit_name}}</option>
					   @endforeach
					   </select>
			</div>

				<div class="form-group">
						<button type="submit" class="btn btn-secondary btn-size" style="margin-top:23px;">Submit</button>
					</div>
				</form>
			</div>

			<div class="col-lg-8 col-xl-8 col-xxl-8">
			<label style="font-size:12px;"><b><u>Contractor Items</u></b> </label>

				<div class="d-flex py-3 align-items-center">
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Item Name</th>
									<th>Unit</th>
									<th>Added_By</th>
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
	
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				
				</div>
	
			</div>
		</div>
	</div>

	

@push('scripts')

<script>

$("#unit_id").select2();

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
			url:"view-subcontractor-items",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"60px","targets":4},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "item" },
			{"data": "unit" },
			{"data": "addedby" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
  $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-subcontractor-item"+"/"+cid,
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
				url: "delete-subcontractor-item"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Item  successfully removed.");
				   }
				}
			});
		}
		
  });
  
 
  
</script>

@endpush

@endsection
