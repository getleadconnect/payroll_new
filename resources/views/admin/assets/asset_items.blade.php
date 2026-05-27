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
						<h4 class="text-black fs-20">Asset Items</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size pr-3 pl-3" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
	
			<div class="row mt-1 pt-2 pb-2 filter-box">
				
				<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Select Category </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="flt_category_id" name="flt_category_id" required>
				<option value="">--select--</option>
				@foreach($cats as $r)
				    <option value="{{$r->id}}">{{$r->category_name}}</option>
				@endforeach
				</select>
				</div>

			</div>
	
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
					
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:140%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<!--<th>Company</th>-->
									<th>Category</th>
									<th>Item Name</th>
									<th>Description</th>
									<th>Bill_date</th>
									<th>Bill_No</th>
									<th>U.Price</th>
									<th>Qty</th>
									<th>Amount</th>
									<th title="Available Quantity">Bal.Qty</th>
									<th >Added_By</th>
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
					<h5 class="modal-title">Add Asset Item</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<form method="POST" action="{{url('save-asset-item')}}" enctype="multipart/form-data">
				@csrf
				
				<input type="hidden" id="company_id"  name="company_id"  value="{{$comp->id}}" required>

				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Asset Category</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" name="category_id" required>
					   <option value="">--select--</option>
					   @foreach($cats as $r)
					    <option value="{{$r->id}}">{{$r->category_name}}</option>
					   @endforeach
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Item Name</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <input type="text" class="form-control input-default"  name="item_name" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control" name="description"  required></textarea>
					  </div>
					</div>
				</div>
								
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bill Date & No</label>
					  <div class="col-lg-5 col-xl-5 col-xxl-5">
					      <input type="date" class="form-control input-default "  name="bill_date" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Bill No</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="text" class="form-control input-default " placeholder="bill no"  name="bill_no" required>
					  </div>
					<label class="col-lg-2 col-xl-2 col-xxl-2 pr-0 col-form-label">Unit Price</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="number" class="form-control input-default " id="unit_price"  name="unit_price" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Quantity</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					      <input type="number" class="form-control input-default " id="quantity"  name="quantity" required>
					  </div>
				
					  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Amount</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="number" class="form-control input-default " id="amount"  name="amount" required>
					  </div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger light  btn-size pr-3 pl-3" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-secondary btn-size pr-3 pl-3">Save changes</button>
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
	
	<div class="modal fade" id="basicModal-3" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Assign item to Project</h5>
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

$("#flt_category_id").select2();

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
			url:"view-asset-items",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.category_id = $('#flt_category_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"100px","targets":2},
				  {"width":"150px","targets":3},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			//{"data": "comp" },
			{"data": "cat" },
			{"data": "item" },
			{"data": "desc" },
			{"data": "bdate" },
			{"data": "bno" },
			{"data": "uprice",class:'text-right' },
			{"data": "qty",class:'text-right' },
			{"data": "amt" ,class:'text-right'},
			{"data": "aqty" ,class:'text-right'},
			{"data": "addedby"},
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#flt_category_id").change(function()
{
	table.draw();
});

$("#amount").focus(function()
{
	var up=$("#unit_price").val();
	var qty=$("#quantity").val();
	
	var amt=parseFloat(up)*parseFloat(qty);
	$("#amount").val(amt.toFixed(2));
});



/*$("#company_id").change(function()
{
	var cid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-projects-by-company-id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#project_id").html(res);
			}
		});
});*/


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	  var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
		$(this).attr('data-target','#basicModal-2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit-asset-item"+"/"+cid,
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
			url: "delete-asset-item"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				  table.draw();
				  alert("Asset item successfully removed.");
			   }
			}
		});
	}
		
  });
  
  
  $('#datatable tbody').on( 'click', '.assign_item', function ()
  {
		var id=$(this).attr('id');
		
		var Result=$("#basicModal-3 .modal-body");
		$(this).attr('data-target','#basicModal-3');
		
			jQuery.ajax({
			type: "GET",
			url: "assign-asset-item"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });


  
</script>

@endpush

@endsection
