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
						<h4 class="text-black fs-20">Sub-Contractor Item Rates</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="row mt-1 pt-2 pb-2 filter-box">
				
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Project </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_project_id" name="flt_project_id" required>
					<option value="">--select--</option>
					@foreach($projs as $r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
					@endforeach
					</select>
					</div>
					
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label text-right">Sub-contactor</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_subcontractor_id" name="flt_subcontractor_id" required>
						<option value="">--select--</option>
						@foreach($scon as $r)
							<option value="{{$r->id}}">{{$r->name}}</option>
						@endforeach
					</select>
					</div>
					
					<div class="col-lg-1 col-xl-1 col-xxl-1">
						<button type="button" id="btnFilter" class="btn btn-secondary btn-size">Get</button>
					</div>
			    </div>


				<div class="row mt-3">
				  <div class="col-lg-12 col-xl-12 col-xxl-12">


					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Project</th>
									<th>Sub_contractor</th>
									<th>Item_name</th>
									<th>Date</th>
									<th>Unit</th>
									<th>Rate</th>
									<th>Added_By</th>
									<th>Action</th>
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
					<h5 class="modal-title">Add Rates</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<form method="POST" action="{{url('save-subcontractor-rate')}}" enctype="multipart/form-data">
				@csrf
				

				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					  <select class="form-control input-default " id="project_id" name="project_id" required>
						<option value="">--select--</option>
						@foreach($projs as $r)
							<option value="{{$r->id}}">{{$r->project_name}}</option>
						@endforeach
					  </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Contractor</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					 <select class="form-control input-default " id="subcontractor_id" name="subcontractor_id" required>
						<option value="">--select--</option>
						@foreach($scon as $r)
						  <option value="{{$r->id}}">{{ $r->name }}</option>
						@endforeach
					 </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					  <select class="form-control input-default " id="item_id"  name="item_id" required>
						<option value="">--select--</option>
						@foreach($sitems as $r)
						  <option value="{{$r->id}}">{{ $r->item_name }}</option>
						@endforeach
					 </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Unit</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					  <input type="text" class="form-control input-default " id="unit_name" name="unit_name" readonly>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <input type="date" class="form-control input-default " name="item_date" required>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Rate</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <input type="number" class="form-control input-default " step="any" name="item_rate" required>
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

$("#flt_subcontractor_id").select2();
$("#flt_project_id").select2();

$("#subcontractor_id").select2();
$("#project_id").select2();
$("#item_id").select2();


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
			url:"view-subcontractor-rates",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.project_id = $('#flt_project_id').val();
			   data.subcon_id = $('#flt_subcontractor_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"70px","targets":8},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "pname" },
			{"data": "scon" },
			{"data": "item" },
			{"data": "idate" },
			{"data": "unit" },
			{"data": "irate" },
			{"data": "addedby" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#btnFilter").click(function()
{
	table.draw();
});
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-subcontractor-rate"+"/"+cid,
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
				url: "delete-subcontractor-rate"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Item rate successfully removed.");
				   }
				}
			});
		}
		
  });


$("#item_id").change(function()
{
	var scid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-subcontractor-item-unit-name"+"/"+scid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#unit_name").val(res);
			}
		});
});

  
</script>

@endpush

@endsection
