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
						<h4 class="text-black fs-20">Material Prices</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="row mt-1 pt-2 pb-2 filter-box" >
				
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Project </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_project_id" name="flt_project_id" required>
					<option value="">--select--</option>
					@foreach($proj as $r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
					@endforeach
					</select>
					</div>
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Supplier</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_supplier_id" name="flt_supplier_id" required>
						<option value="">--select--</option>
						@foreach($supp as $r)
							<option value="{{$r->id}}">{{$r->supplier_name}}</option>
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
						<table id="datatable" class="display" style="width:130%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Status</th>
									<th>Project</th>
									<th>Supplier</th>
									<th>Material_Type</th>
									<th>Sub_Type</th>
									<th>Date</th>
									<th>Unit</th>
									<th>Price</th>
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
					<h5 class="modal-title">Add Material Price</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<form method="POST" action="{{url('save-material-price')}}" enctype="multipart/form-data">
				@csrf
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<label style="font-size:11px;color:red;" class="mb-2">(All fields are mandatory)</label>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" id="project_id" name="project_id" required>
					   <option value="">--select--</option>
					   @foreach($proj as $r)
					    <option value="{{$r->id}}">{{$r->project_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Supplier</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg"  id="supplier_id"  name="supplier_id" required>
					   <option value="">--select--</option>
					   @foreach($supp as $r)
					    <option value="{{$r->id}}">{{$r->supplier_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Material Type</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg"  id="material_type_id" name="material_type_id" required>
					   <option value="">--select--</option>
					   @foreach($mtype as $r)
					    <option value="{{$r->id}}">{{$r->material_type_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Sub Type</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" id="material_sub_type_id" name="material_sub_type_id" required>
					   <option value="">--select--</option>
					  
					   
					   </select>
					</div>
					</div>
				</div>
				
				
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date</label>
					  <div class="col-lg-5 col-xl-5 col-xxl-5">
					     <input type="date" class="form-control input-default "  name="price_date" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Unit</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					   <select class="form-control form-control-lg"  name="material_unit_id" required>
					   <option value="">--select--</option>
					   @foreach($munit as $r)
					    <option value="{{$r->id}}">{{$r->unit_name}}</option>
					   @endforeach
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Price</label>
					  <div class="col-lg-5 col-xl-5 col-xxl-5">
					     <input type="number" class="form-control input-default" step="any" name="price" required>
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

@push('scripts')

<script>

$("#flt_project_id").select2();
$("#flt_supplier_id").select2();

$("#project_id").select2();
$("#supplier_id").select2();

$("#material_type_id").select2();
$("#material_sub_type_id").select2();

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
			url:"view-material-prices",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.project_id = $('#flt_project_id').val();
			   data.supplier_id = $('#flt_supplier_id').val();
		    },
          },
		
		columnDefs:[
					
				  {"width":"30px","targets":0},
				  {"width":"70px","targets":1},
				  {"width":"60px","targets":7},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
			{"data": "project" },
			{"data": "supplier" },
			{"data": "mtype" },
			{"data": "mstype" },
			{"data": "pdate" },
			{"data": "unit" },
			{"data": "price",className: "text-right" },
			{"data": "addedby"},
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });

$("#btnFilter").click(function()
{
	table.draw();
});


$("#material_type_id").change(function()
{
	var id=$(this).val();
  		jQuery.ajax({
				type: "GET",
				url: "get-material-sub-types"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				  $("#material_sub_type_id").html(res);
				}
			});
	
});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-material-price"+"/"+id,
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
			var id=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-material-price"+"/"+id,
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
			var id=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "price_activate_deactivate"+"/"+id+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Material price successfully Activated."); }
						else{	alert("Material price successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
