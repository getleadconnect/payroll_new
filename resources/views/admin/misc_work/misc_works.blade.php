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
						<h4 class="text-black fs-20">Misc-Works</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="#" id="btnAdd" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
		
					<div class="row mt-2 pt-2 pb-2 filter-box" >
					    
						<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project:&nbsp;</label>
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<select class="form-control" id="flt_project_id" name="flt_project_id"  style="width:200px;" required>
							<option value="">--select--</option>
							@foreach($proj as $r)
							<option value="{{$r->id}}">{{$r->project_name}}</option>
							@endforeach
							</select>
						</div>
					
						
						<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Vendor:&nbsp;</label>
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<select class="form-control" id="flt_vendor_id" name="flt_vendor_id" style="width:250px;" required>
							<option value="">--select--</option>
							@foreach($mven as $r)
							<option value="{{$r->id}}">{{$r->name}}</option>
							@endforeach
							</select>
						</div>
						
						
						<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Payment:&nbsp;</label>
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						 <select class="form-control" id="flt_payment_type" name="flt_payment_type" required>
						  <option value="">--select--</option>
						  @foreach($ptype as $r)
						  <option value="{{$r->id}}">{{$r->payment_type}}</option>
						  @endforeach
						  </select>
						</div>

						<div class="col-lg-1 col-xl-1 col-xxl-1">
							&nbsp;&nbsp;<button type="submit" id="btnGet" class="btn btn-secondary btn-size">Get</button>
						</div>
					</div>
		
<!-- ------------------------------------------------------------- -->
		
					<div class="row mt-3">
						<div class="col-lg-12 col-xl-12 col-xxl-12" >
							<div class="table-responsive">
								<table id="datatable" class="display" style="width:130%">
									<thead>
										<tr>

											<th>No</th>
											<th>Action</th>
											<th >Project</th>
											<th >Category</th>
											<th>Vendor</th>
											<th>Description</th>
											<th>Invoice_Date</th>
											<th>Invoice_No</th>
											<th width="60px">Gst</th>
											<th width="80px">Total</th>
											<th>Payment</th>
											<th>Added_By</th>

										</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
							</div>
				  </div>
				</div>
				<!--</div> d-flex end ------->
				
			</div>
		</div>
	</div>
			 
</div>

<div class="modal fade" id="basicModal-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add </h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;">
				<label style="color:red;font-size:12px;" class="mb-2" >All fields are mandatory</label>
				
				<form method="POST" action="{{url('save-misc-work')}}" enctype="multi-part/form-data">
				@csrf
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Projects</label>
				  <div class="col-lg-9 col-xl-9 col-xxl-9">
					<select class="form-control" id="project_id" name="project_id" required>
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
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Misc-Category</label>
				  <div class="col-lg-9 col-xl-9 col-xxl-9">
					<select class="form-control" id="misc_category_id" name="misc_category_id" required>
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
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Misc-Vendor</label>
				  <div class="col-lg-9 col-xl-9 col-xxl-9">
				   <select class="form-control" id="misc_vendor_id" name="misc_vendor_id" required>
					<option value="">--select--</option>
					@foreach($mven as $r)
					<option value="{{$r->id}}">{{$r->name}}</option>
					@endforeach
					</select>
				</div>
				</div>
				</div>
				<div class="form-group">
				<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Description</label>
				  <div class="col-lg-9 col-xl-9 col-xxl-9">
				    <textarea class="form-control" name="description" required></textarea>
				</div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Payment Type</label>
				  <div class="col-lg-6 col-xl-6 col-xxl-6">
				  <select class="form-control" name="payment_type" required>
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
				  <div class="col-lg-6 col-xl-6 col-xxl-6">
				  <input type="date" class="form-control" id="invoiceDate" name="invoice_date" value="{{date('Y-m-d')}}" 
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
				  <div class="col-lg-6 col-xl-6 col-xxl-6">
				     <input type="text" class="form-control" name="invoice_no" required>
				</div>
				</div>
				</div>
				
				<div class="form-group">
				<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Gst Amount</label>
				  <div class="col-lg-5 col-xl-5 col-xxl-5">
				     <input type="number" class="form-control" step="any" id="gst_amount" name="gst_amount" required>
				</div>
				</div>
				</div>
				
								
				<div class="form-group">
				<div class="row">
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Total Amount</label>
				  <div class="col-lg-5 col-xl-5 col-xxl-5">
				     <input type="number" class="form-control" step="any" id="total_amount" name="total_amount" required >
				</div>
				</div>
				</div>
				
				
								
				
			    <div class="modal-footer">
					<button type="button" class="btn btn-danger btn-size" data-dismiss="modal">Close</button>
				   <button type="submit" class="btn btn-secondary btn-size">Submit</button>
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
$("#flt_vendor_id").select2();


$("#project_id").select2();
$("#misc_category_id").select2();
$("#misc_vendor_id").select2();


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
	
	$("#invoiceDate").min="2023-10-5";
	
	
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
			url:"view-misc-works",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchPro = $('#flt_project_id').val();
			   data.searchVendor = $('#flt_vendor_id').val();
			   data.searchPay = $('#flt_payment_type').val();
		    },
        },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"150px","targets":2},
				  {"width":"120px","targets":[3,4]},
				  {"width":"200px","targets":5},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "mcat" },
			{"data": "vname" },
			{"data": "desc" },
			{"data": "inv_date" },
			{"data": "inv_no" },
			{"data": "gamt",class:"text-right"},
			{"data": "tamt",class:"text-right" },
			{"data": "paid_id" },
			{"data": "addedby" },
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
   });


$("#btnGet").click(function()
{
	table.draw();
});


function total_values(gst,rate,qty)
{
	var amt=rate*qty;
	gstamt=amt*(gst/100);
	tamt=amt+gstamt;
	
	$("#amount").val(amt.toFixed(2));
	$("#gst_amount").val(gstamt.toFixed(2));
	$("#total_amount").val(tamt.toFixed(2));
}


$("#amount").focus(function()
{
	var gst=parseFloat($("#gst").val());
	var rate=parseFloat($("#rate").val());
	var qty=parseFloat($("#quantity").val());
	
	total_values(gst,rate,qty);
});



$("#quantity").keyup(function()
{
	var gst=parseFloat($("#gst").val());
	var rate=parseFloat($("#rate").val());
	var qty=parseFloat($(this).val());
	
	total_values(gst,rate,qty);
});

$("#rate").keyup(function()
{
	var gst=parseFloat($("#gst").val());
	var rate=parseFloat($(this).val());
	var qty=parseFloat($("#quantity").val());
	
	total_values(gst,rate,qty);
});

$("#gst").keyup(function()
{
	var gst=parseFloat($(this).val());
	var rate=parseFloat($("#rate").val());
	var qty=parseFloat($("#quantity").val());
	
	total_values(gst,rate,qty);
});


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-misc-work"+"/"+cid,
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
				url: "delete-misc-work"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Work details successfully removed.");
				   }
				}
			});
		}
		
  });
    
   
</script>

@endpush

@endsection
