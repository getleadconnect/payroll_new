@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')

<style>
table.dataTable thead th, table.dataTable tfoot th {
    font-size: 12px !important;
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
	min-height: 25px !important;
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
					<div class="mr-auto pr-2">
						<h4 class="text-black fs-20">Add Materials<small>(Supply)</small></h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('material-supply')}}" class="btn btn-secondary btn-size" ><i class="fas fa-file"></i> View Material Supply </a>
				</div>
			</div>
			
			<div class="card-body pl-5 pb-4 pt-0" >

				<form method="POST" action="{{url('save-material-supply')}}" enctype="multipart/form-data" autocomplete=off >
				@csrf

				<input type="hidden" class="form-control" id="material_price_id" name="material_price_id">
				<input type="hidden" class="form-control" id="material_gst_id" name="material_gst_id">

				<label style="font-size:11px;color:red;" class="mt-3 mb-2">(All fields are mandatory)</label>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Project</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
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
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Supplier</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					   <select class="form-control form-control-lg" id="supplier_id" name="supplier_id" required>
					   <option value="">--select--</option>
						  
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Material Type</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					  <select class="form-control form-control-lg" id="material_type" name="material_type" required>
					   <option value="">--select--</option>
					  
					   
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Material Sub Type</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					   <select class="form-control form-control-lg" id="material_sub_type" name="material_sub_type" required>
					   <option value="">--select--</option>

					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Material GST</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					   <input type="number" class="form-control input-default " step="any" id="material_gst" name="material_gst" required>
					</div>
					</div>
				</div>
				
				@php
					$thu_date= \Carbon\Carbon::parse('this thursday');  //next and current thursday date
					$start_date=\Carbon\Carbon::createFromDate($thu_date)->subDays(6);
				@endphp
	
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Supply Date</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="date" class="form-control input-default " id="supply_date" name="supply_date" value="{{date('Y-m-d')}}"
						  @if(Session::get('admin_role_id')!=1)
								min="<?=date('Y-m-d',strtotime($start_date));?>"  max="<?=date('Y-m-d',strtotime($thu_date));?>" 
						  @endif
						  required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Supply Time</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="time" class="form-control input-default " id="supply_time" name="supply_time" required>
					  </div>
					</div>
				</div>
				
								
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Lorry No</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					   <input type="text" class="form-control input-default" id="lorry_no" name="lorry_no" required>
					</div>
					</div>
				</div>
				
				
				
								
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Unit</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
						<!--<input type="text" class="form-control input-default" name="material_unit" id="material_unit">-->
					  <select class="form-control form-control-lg" id="material_unit" name="material_unit" required>
					  <option value="">--select--</option>
						@foreach($munit as $r)
							<option value="{{$r->unit_name}}">{{$r->unit_name}}</option>
						@endforeach
					  </select>
						
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Price</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="price" name="price" required readonly>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Payment Type</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					  <select class="form-control form-control-lg" id="payment_type_id" name="payment_type_id" required>
					   <option value="">--select--</option>
						@foreach($ptype as $r)
							<option value="{{$r->id}}">{{$r->payment_type}}</option>
						@endforeach
					   </select>
					</div>
					</div>
				</div>

								
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Quantity</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="quantity" name="quantity" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Gst Amount</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any"  name="gst_amount" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Round Off</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="round_off" name="round_off"  value=0 required >
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Total Amount</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="amount" name="amount" required>
					  </div>
					</div>
				</div>
	
				<div class="form-group">
					<div class="row">
					  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Invoice No</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="text" class="form-control input-default" name="invoice_no" required>
					  </div>
					</div>
				</div>
				  <hr>
					<div class="row mb-5">
					  
					  <div class="col-lg-7 col-xl-7 col-xxl-7 offset-lg-2">
					  	<button type="submit" class="btn btn-secondary btn-size">Save changes</button>
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
			url:"view-material-prices",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
					
				  {"width":"70px","targets":0},
				  {"width":"50px","targets":1},
				],
	
        columns: [
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
            {"data": "id" },
			{"data": "project" },
			{"data": "supplier" },
			{"data": "mtype" },
			{"data": "mstype" },
			{"data": "pdate" },
			{"data": "unit" },
			{"data": "price",className: "text-right" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#project_id").change(function()
{
	$("#material_type").html('<option value="">--select--</option>')
	$("#supplier_id").html('<option value="">--select--</option>')
	
	var pro_id=$("#project_id").val();
	if(pro_id!="")
	{
  		jQuery.ajax({
			type: "GET",
			url: "get-material-suppliers"+"/"+pro_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#supplier_id").html(res);
			}
		});
	}
});

$("#supplier_id").change(function()
{
	$("#material_type").html('<option value="">--select--</option>')
	
	var supp_id=$(this).val();
	var pro_id=$("#project_id").val();
	
	if(supp_id!="")
	{
  		jQuery.ajax({
			type: "GET",
			url: "get-material-types"+"/"+supp_id+"/"+pro_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#material_type").html(res);
			}
		});
	}
});

$("#material_type").change(function()
{
	var mt_id=$(this).val();
	
	if(mt_id!="")
	{
  		jQuery.ajax({
			type: "GET",
			url: "get-supply-material-sub-types"+"/"+mt_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#material_sub_type").html(res);
			}
		});
	}
});

$("#material_sub_type").change(function()
{
	var mst_id=$(this).val();
	var pro_id=$("#project_id").val();
	var sup_id=$("#supplier_id").val();

if(mst_id!="")
 {
	jQuery.ajax({
		type: "GET",
		url: "get-material-price-details"+"/"+mst_id+"/"+pro_id+"/"+sup_id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			var dt=$.parseJSON(res);
			  $("#material_gst").val(dt.gst);
			  $("#material_unit").val(dt.unit);
			  $("#price").val(dt.price);
			  $("#material_price_id").val(dt.price_id);
			  $("#material_gst_id").val(dt.gst_id);
		}
	});
  }

});



$("#quantity").keyup(function()
{
	calculate();
});

$("#round_off").keyup(function()
{
	var roff=$("#round_off").val();
	if(roff!="")
	{
		calculate();
		var amt=parseFloat($("#amount").val());
		var amt1=amt-(parseFloat(roff));
		$("#amount").val(amt1.toFixed(2));
	}
	else
	{
		calculate();
	}
});

$("#price").keyup(function()
{
	calculate();
});

$("#amount").focus(function()
{
	calculate();
});


function calculate()
{
	var qty=$("#quantity").val();
	var price=$("#price").val();
	var roff=$("#round_off").val();
	if(roff==""){roff=0;}
	var amt=(parseFloat(qty)*parseFloat(price));
	$("#amount").val(amt.toFixed(2));
}

  
</script>

@endpush

@endsection
