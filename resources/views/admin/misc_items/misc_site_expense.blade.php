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
						<h4 class="text-black fs-20">Site Misc-Expenses</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="row p-2 filter-box" >
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Select Project</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					 <select class="form-control input-default " id="flt_project_id" name="flt_project_id" required>
						<option value="">--select--</option>
						@foreach($projs as $r)
						  <option value="{{$r->id}}">{{ $r->project_name }}</option>
						@endforeach
					 </select>
					</div>

					<div class="col-lg-1 col-xl-1 col-xxl-1">
					<button type="button" class="btn btn-secondary btn-size" style="margin-top:2px;" id="btnFilter">Get</button>
					</div>
					
				</div>
				
					<div class="table-responsive mt-3">
						<table id="datatable" class="display" style="width:120%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Project</th>
									<th>Category</th>
									<th>Item Name</th>
									<th>Description</th>
									<th>Payment</th>
									<th>Invoice_Date</th>
									<th>Invoice_No</th>
									<th >Amount</th>
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

	<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Project</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<form method="POST" action="{{url('save-misc-site-expense')}}" enctype="multipart/form-data">
				@csrf
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project</label>
					<div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" id="project_id"  name="project_id" required>
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
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Category</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					    <select class="form-control form-control-lg" id="category_id"  name="category_id" required>
					   <option value="">--select--</option>
					   @foreach($mcat as $r)
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
					     <input type="text" class="form-control input-default "  name="item_name" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					     <textarea class="form-control input-default "  name="description" required></textarea>
					  </div>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Payment Type</label>
					  <div class="col-lg-9 col-xl-9 col-xxl-9">
					   <select class="form-control form-control-lg" id="payment_type"  name="payment_type" required>
						   <option value="">--select--</option>
						   @foreach($ptype as $r)
							<option value="{{$r->id}}">{{$r->payment_type}}</option>
						   @endforeach
					   </select>
					  </div>
					</div>
				</div>
				
				@php
					$thu_date= \Carbon\Carbon::parse('this thursday');  //next and current thursday date
					$start_date=\Carbon\Carbon::createFromDate($thu_date)->subDays(6);
				@endphp

				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice Date</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="date" class="form-control input-default "  name="invoice_date" value="{{date('Y-m-d')}}"
							@if(Session::get('admin_role_id')!=1)
								min="<?=date('Y-m-d',strtotime($start_date));?>"  max="<?=date('Y-m-d',strtotime($thu_date));?>" 
							@endif
						  required>
					  </div>
					</div>
				</div>
				
								
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Invoice No</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="text" class="form-control input-default"  name="invoice_no" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
					  <div class="col-lg-4 col-xl-4 col-xxl-4">
					      <input type="number" class="form-control input-default"  step="any"  name="amount" required>
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

$("#flt_project_id").select2();

$("#project_id").select2();
$("#category_id").select2();

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
			url:"view-misc-site-expenses",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchProjectId = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"150px","targets":[2,3]},
				  {"width":"100px","targets":[6,7]},
				  {"width":"70px","targets":[8,9]},

				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "mcat" },
			{"data": "iname" },
			{"data": "desc" },
			{"data": "ptype" },
			{"data": "ivdate" },
			{"data": "ivno" ,class:"text-right"},
			{"data": "amt",class:"text-right"},
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
	
	
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-misc-site-expense"+"/"+cid,
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
				url: "delete-misc-site-expense"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Expense successfully removed.");
				   }
				}
			});
		}
		
  });
    
   
</script>

@endpush

@endsection
