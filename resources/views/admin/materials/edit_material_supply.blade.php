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
						<h4 class="text-black fs-20">Edit Materials<small>(Supply)</small></h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('material-supply')}}" class="btn btn-secondary btn-size" ><i class="fas fa-file"></i> View Material Supply </a>
				</div>
			</div>
			
			<div class="card-body pl-5 pb-4 pt-0" >

				<form method="POST" action="{{url('update-material-supply')}}" enctype="multipart/form-data">
				@csrf

				<input type="hidden"  id="material_supply_id" name="material_supply_id" value="{{$ms->id}}">
				<input type="hidden"  id="material_price_id" name="material_price_id" value="{{$ms->material_price_id}}">
				<input type="hidden"  id="material_gst_id" name="material_gst_id" value="{{$ms->material_gst_id}}">

				<label style="font-size:11px;color:red;" class="mt-3 mb-2">(All fields are mandatory)</label>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Project</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					   <select class="form-control form-control-lg" id="project_id" name="project_id" required>
					   <option value="">--select--</option>
					    @foreach($proj as $r)
						   <option value="{{$r->id}}" @if($r->id==$ms->project_id){{__('selected')}}@endif>{{$r->project_name}}</option>
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
						  @foreach($supp as $r)
						   <option value="{{$r->id}}"@if($r->id==$ms->supplier_id){{__('selected')}}@endif>{{$r->supplier_name}}</option>
						@endforeach
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
					  @foreach($mtype as $r)
						   <option value="{{$r->id}}" @if($r->id==$ms->material_type_id){{__('selected')}}@endif>{{$r->material_type_name}}</option>
						@endforeach
					   
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
						@foreach($mstype as $r)
						   <option value="{{$r->id}}" @if($r->id==$ms->material_sub_type_id){{__('selected')}}@endif>{{$r->sub_type_name}}</option>
						@endforeach
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Material GST</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					   <input type="number" class="form-control input-default " step="any" id="material_gst" name="material_gst"  value="{{$ms->material_gst}}" required>
					</div>
					</div>
				</div>
	
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Supply Date</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="date" class="form-control input-default " id="supply_date" name="supply_date"  value="{{$ms->supply_date}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Supply Time</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="time" class="form-control input-default " id="supply_time" name="supply_time" value="{{$ms->supply_time}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Lorry No</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					   <input type="text" class="form-control input-default" id="lorry_no" name="lorry_no" value="{{$ms->lorry_no}}" required>
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
							<option value="{{$r->unit_name}}" @if($r->unit_name==$ms->material_unit){{__('selected')}}@endif>{{$r->unit_name}}</option>
						@endforeach
					  </select>
						
					</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Price</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="price" name="price" value="{{$ms->price}}" required readonly>
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
							<option value="{{$r->id}}" @if($r->id==$ms->payment_type_id){{__('selected')}}@endif>{{$r->payment_type}}</option>
						@endforeach
					   </select>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Quantity</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="quantity" name="quantity" value="{{$ms->quantity}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Gst Amount</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control" step="any" id="gst_amount" name="gst_amount" value="{{$ms->gst_amount}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Round Off</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control input-default" step="any" id="round_off" name="round_off" value="{{$ms->round_off}}" required >
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Amount</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="number" class="form-control" step="any" id="amount" name="amount" value="{{$ms->amount}}" required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					  <label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Invoice No</label>
					  <div class="col-lg-3 col-xl-3 col-xxl-3">
					     <input type="text" class="form-control " name="invoice_no" value="{{$ms->invoice_no}}" required>
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


@push('scripts')

<script>

$("#project_id").change(function()
{
	var pro_id=$("#project_id").val();
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
});

$("#supplier_id").change(function()
{
	var supp_id=$(this).val();
	var pro_id=$("#project_id").val();
	
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
});

$("#material_type").change(function()
{
	var mt_id=$(this).val();
	
  		jQuery.ajax({
			type: "GET",
			url: "get-material-sub-types"+"/"+mt_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#material_sub_type").html(res);
			}
		});
});

$("#material_sub_type").change(function()
{
	var mst_id=$(this).val();
	var pro_id=$("#project_id").val();
	var sup_id=$("#supplier_id").val();

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
