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

.lbl-error
{
	font-size:11px;
	color:red;
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
						<h4 class="text-black fs-20">Add Labour</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('labours')}}" class="btn btn-secondary btn-size"><i class="fas fa-file"></i> View Labours </a>
				</div>
			</div>
			
			<div class="card-body pl-5 pb-4 pt-0" >
			
				<form method="POST" action="{{url('save-labour')}}" enctype="multipart/form-data">
				@csrf

				<label style="font-size:11px;color:red;" class="mt-3 mb-2">(All fields are mandatory)</label>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label mt-3">Code</label>
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					   <label style="font-size:11px;color:blue;">3 Character & 4 digits (Eg: ABC1234) </label>
					   <input type="text" class="form-control input-default" pattern="[A-Za-z]{3}\d{4}" maxlength="7" id="code" name="code" value="{{old('code')}}" required>
					   @if($errors->has('code'))
						 <label class="lbl-error">{{$errors->first('code')}}</label>
					   @endif
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Name</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					   <input type="text" class="form-control input-default" id="name" name="name" value="{{old('name')}}" required>
					</div>
					</div>
				</div>
				
				<!-- To get material name and price details from material_price table ----->
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Skill</label>
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					   <select class="form-control form-control-lg" id="skill_type" name="skill_type" required>
					   <option value="">--select--</option>
					  @foreach($skill as $r)
					   <option value="{{$r->id}}" @if($r->id==old('skill_type')){{__('selected')}}@endif>{{$r->skill_type}}</option>
					  @endforeach
				     </select>
					</div>
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Birth Date</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					   <input type="date" class="form-control input-default" id="birth_date" name="birth_date" value="{{old('birth_date')}}">
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Gender</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7" style="display:flex;">
					     <input type="radio" class="ml-3"  name="gender" value="MALE" style="width:25px;height:25px;align-items:center;" @if(old('gender')=="MALE"){{__('checked')}}@endif required><span class="mt-1 pl-2">Male</span>
						 <input type="radio"  class="ml-3"  name="gender" value="FEMALE" style="width:25px;height:25px;align-items:center;" @if(old('gender')=="FEMALE"){{__('checked')}}@endif required><span class="mt-1 pl-2">Female</span>
					  </div>
					</div>
				</div>
					
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Mobile</label>
					<div class="col-lg-7 col-xl-7 col-xxl-7">
					   <input type="number" class="form-control input-default " id="mobile" name="mobile" value="{{old('mobile')}}" required>
					</div>
					</div>
				</div>
					
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Address</label>
					  <div class="col-lg-7 col-xl-7 col-xxl-7">
					     <textarea class="form-control input-default" id="address" name="address" style="height:80px;" required>{{old('address')}}</textarea>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">State</label>
					  <div class="col-lg-5 col-xl-5 col-xxl-5">
					     <input type="text" class="form-control input-default " id="state" name="state" value="{{old('state')}}"required>
					  </div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">District</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
					   <input type="text" class="form-control input-default" id="district" name="district" value="{{old('district')}}" required>
					</div>
					</div>
				</div>
								
				<div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Nationality</label>
					<div class="col-lg-5 col-xl-5 col-xxl-5">
						<input type="text" class="form-control input-default" name="nationality" id="nationality" value="{{old('nationality')}}">
					</div>
					</div>
				</div>
								
				<div class="form-group">
					<div class="row">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Aadhar No</label>
					  <div class="col-lg-5 col-xl-5 col-xxl-5">
					     <input type="text" class="form-control input-default" id="aadhar_no" name="aadhar_no" value="{{old('aadhar_no')}}" required>
					    @if($errors->has('aadhar_no'))
						 <label class="lbl-error">{{$errors->first('aadhar_no')}}</label>
					    @endif
					  </div>
					</div>
				</div>

				  <hr>
					<div class="row mb-5">
					<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">&nbsp;</label>
					  <div class="col-lg-7 col-xl-7 col-xxl-7">
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
	
  		jQuery.ajax({
			type: "GET",
			url: "get-material-price"+"/"+supp_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#material_price_id").html(res);
			}
		});
});


$("#material_price_id").change(function()
{
	var mt_id=$(this).val();
	
  		jQuery.ajax({
			type: "GET",
			url: "get-material-price-details"+"/"+mt_id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#material_sub_type_id").html(res);
			}
		});
});


$("#material_price_id").change(function()
{
	var id=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "get-material-gst-value"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   var mdat=res.split('|');
				
			  $("#material_gst_id").html(mdat[0]);
			  $("#price").val(parseFloat(mdat[1]).toFixed(2));
			  $("#material_unit_id").html(mdat[2]);
			}
		});
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


$("#amount").focus(function()
{
	var qty=$("#quantity").val();
	var price=$("#price").val();
	var amt=parseFloat(qty)*parseFloat(price);
	$("#amount").val(amt.toFixed(2));
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
