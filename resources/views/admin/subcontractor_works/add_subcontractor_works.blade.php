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

.form--control {
    padding: 0.1rem 0.55rem !important;
    line-height: 1.25 !important;
	height:35px;
	width:100%;
	border:none;
}
.pad-l
{
	font-size:13px !important;
	padding-left:15px;
}

.btn-add-remove
{
	width: 23px !important;
    height: 23px !important;
    padding: 0px !important;
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
						<h4 class="text-black fs-20">Add Subcontractor Works</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('sub-contractor-works')}}" class="btn btn-secondary btn-size"><i class="fas fa-file"></i> View Works Entry </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
			
			<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
		
			<div class="row mt-3">
			  <div class="col-lg-12 col-xl-12 col-xxl-12" >
							
			  <form  method="POST" action="{{ url('save-subcontractor-work')}}" enctype="multipart/form-data">
			   @csrf

				<!--<input type="hidden" name="unitNames" id="unitNames" value="{{$units}}">-->
				
				<input type="hidden" name="unit_name" id="unit_name" >
				<input type="hidden" name="unit_id" id="unit_id" >
				<input type="hidden" name="item_rate" id="item_rate" >
				<input type="hidden" name="rate_id" id="rate_id" >

				<label style="font-size:13px;"><b><u>Add work details</u></b></label>

					<div class="row mt-2">
					
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Project </label>
						<select type="text" class="form-control" id="project_id" name="project_id" required>
						<option value="">--select--</option>
						@foreach($projs as $key=>$r)
						  <option value="{{$r->id}}">{{$r->project_name}}</option>
						@endforeach
						</select>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Sub-contractor</label> 
						<select type="text" class="form-control" id="subcontractor_id"  name="subcontractor_id" required>
						<option value="">--select--</option>
						
						</select>
						</div>
						
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<label>Floor</label> 
						<select type="text" class="form-control" id="floor_no"  name="floor_no" required>
						<option value="">--select--</option>
						@foreach($floors as $key=>$r)
						  <option value="{{$r->id}}">{{$r->floor_no}}</option>
						@endforeach
						</select>
						</div>
						</div>
						
					<div class="row mt-2">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Main Cost Center</label> 
						<select type="text" class="form-control" id="main_cost_center_id"  name="main_cost_center_id" required>
						<option value="">--select--</option>
						
						</select>
						</div>
											
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label>Item Name</label> 
						<select type="text" class="form-control" id="item_name"  name="item_name" required>
						<option value="">--select--</option>
						</select>
						</div>
					</div>
		
					<div class="work-entry mt-2">
					
					<table id="daily_work" style="width:100%;" border=1> 
					<!-- heading ----------------- -->
					<tr style="height:30px;"><td class="pad-l" ><b>Description</b></td>
					<td class="pad-l"><b>No</b></td>
					<td class="pad-l"><b>Length</b></td>
					<td class="pad-l"><b>Bredth</b></td>
					<td class="pad-l"><b>Width</b></td>
					<td class="pad-l"><b>Qty</b></td>
					<td class="pad-l"><b>Unit</b></td>
					<td class="pr-2 text-right"><b>Rate</b></td>
					<td class="pr-2 text-right"><b>Amount</b></td>
					<td align="center">&nbsp;</td>
					<!-- ---------------------------->
					 <tr>
						<td width="200px">
							<input type="text" class="form-control description" name="description[]" required>
						</td>
						<td width="60px">
							<input type="text" class="form--control nos" step="any" name="nos[]">
						</td>
						<td>
							<input type="text" class=" form--control length" step="any" name="length[]" >
						</td>
						<td>
							<input type="text" class=" form--control bredth" step="any" name="bredth[]" >
						</td>
						<td>
							<input type="text" class=" form--control width" step="any" name="width[]" >
						</td>
						<td>
							<input type="text" class=" form--control quantity" step="any" name="quantity[]" required readonly>
						</td>
					
						<td >
						  <input type="text" class=" form--control unit" name="unit" required readonly>
						</td>
						<td >
						  <input type="text" class="form--control text-right rate" name="rate" required readonly>
						</td>
						<td >
						  <input type="number" class="form--control text-right amount" step="any" name="amount[]" required readonly>
						</td>
						<td width="60px;" align="center">
						  <button type="button" class="btnLbrAdd btn btn-secondary btn-add-remove"><i class="fa fa-plus"></i></button>
						</td>
					  <tr>
					  
					  </table>
				</div>
					
					<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
						<button type="submit" style="margin-top:25px;" class="btn btn-secondary btn-size">Submit</button>
						</div>
					</div>
				</form>
	
			</div>
		 </div>
				<!--</div> d-flex end ------->
				
	  </div>
	</div>
  </div>
			 
</div>


@push('scripts')

<script>
	$("#project_id").select2();
	$("#subcontractor_id").select2();
	$("#floor_no").select2();
	$("#main_cost_center_id").select2();
	$("#item_name").select2();

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

//$("#unit").html($("#unitNames").val());


$(document).on('click',".quantity",function()
{
	var n=$(this).closest('tr').find("td:eq(1) input").val();
	var l=$(this).closest('tr').find("td:eq(2) input").val();
	var b=$(this).closest('tr').find("td:eq(3) input").val();
	var w=$(this).closest('tr').find("td:eq(4) input").val();
	var r=$(this).closest('tr').find("td:eq(7) input").val();
	if(l==""){l=1;}
	if(b==""){b=1;}
	if(w==""){w=1;}
	
	if(l!=''&& b!="" && w!='' && n!='')
	{
		qt=(parseFloat(l)*parseFloat(w)*parseFloat(b)*parseFloat(n));
		if(qt!="NaN")
		{
		   $(this).closest('tr').find("td:eq(5) input").val(qt.toFixed(2));
		}
	}
	else if(l!='' && b!='')
	{
		qt=(parseFloat(l)*parseFloat(b)*parseFloat(n));
		$(this).closest('tr').find("td:eq(5) input").val(qt.toFixed(2));
	}
});

$(document).on('click',".amount",function()
{
	var qt=$(this).closest('tr').find("td:eq(5) input").val();
	var r=$(this).closest('tr').find("td:eq(7) input").val();
	
	if(qt!='' && r!='')
	{
		var tot=(parseFloat(qt)*r);
		$(this).closest('tr').find("td:eq(8) input").val(tot.toFixed(2));
	}
});


$("#project_id").change(function()
{
	var id=$(this).val();
	$("#subcontractor_id").val('');
	$("#floor_no").val('');
	$("#main_cost_center_id").val('');
	$("#item_name").html("<option value=''>--select--</option>");
	
	jQuery.ajax({
		type: "GET",
		url: "get-subcontractors-by-project"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#subcontractor_id").html(res);
		}
	});
});

$("#subcontractor_id").change(function()
{
	var scid=$(this).val();
	var pid=$("#project_id").val();
	
		jQuery.ajax({
			type: "GET",
			url: "get-subcontractor-rate-items"+"/"+scid+"/"+pid+"/1",
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#item_name").html(res);
			}
		});
});
   
   
$("#floor_no").change(function()
{
	var fno=$(this).val();
	var pid=$("#project_id").val();
	
		jQuery.ajax({
			type: "GET",
			url: "get-main-cost-center-by-project-floor-id"+"/"+pid+"/"+fno,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#main_cost_center_id").html(res);
			}
		});
});
   
function add_new_row()
{
	//var unit=$("#unitNames").val();
	var unit=$("#unit_name").val();
	var rate=parseFloat($("#item_rate").val());
	
	var dat='<tr><td width="200px">'
			+'<input type="text" class="form-control description" name="description[]" required></td>'
			+'<td width="60px"><input type="number" class="form-control nos" step="any" name="nos[]"></td>'
			+'<td><input type="text" class=" form--control length" step="any" name="length[]" ></td>'
			+'<td><input type="text" class=" form--control bredth" step="any" name="bredth[]" ></td>'
			+'<td><input type="text" class=" form--control width" step="any" name="width[]" ></td>'
			+'<td><input type="text" class=" form--control quantity" step="any" name="quantity[]" required readonly></td>'
			+'<td>'
			+'<input type="text" class=" form--control unit" name="unit[]" value="'+unit+'" required readonly>'
			+'</td>'
			+'<td>'
			+'<input type="text" class=" form--control text-right rate" step="any" name="rate[]" value="'+rate.toFixed(2)+'" required readonly>'
			+'</td>'
			+'<td ><input type="number" class=" form--control text-right amount" step="any" name="amount[]" required readonly></td>'
			+'<td width="60px;" align="center">'
			+'<button type="button" class="btnLbrAdd btn btn-secondary btn-add-remove"><i class="fa fa-plus"></i></button>'
			+'&nbsp;<button type="button" class="btnLbrDel btn btn-danger btn-add-remove"><i class="fa fa-minus"></i></button>'
			+'</td><tr>';

		return dat;
}


$(document).on('click',".btnLbrAdd",function()
{
	var des=$(this).closest("tr").find('.description').val();
	var nos=$(this).closest("tr").find('.nos').val();
	var qt=$(this).closest("tr").find('.quantity').val();
	var un=$(this).closest("tr").find('.unit').val();
	var am=$(this).closest("tr").find('.amount').val();
	
	if(des!="" && nos!="" && qt!="" && un!="" && am!="")
	{
		var row_data=add_new_row();
		$("#daily_work").append(row_data);
	}
	else
	{
		alert("Work details missing, Try again.!");
	}
}); 
   

$(document).on('click',".btnLbrDel",function()
{
	if(confirm("Are you sure, Delete this row?"))
	{
		$(this).closest('tr').remove();
	}
});

  
$("#item_name").change(function()
{
	var rate_id=$(this).val();
	var scid=$("#subcontractor").val();
	
		jQuery.ajax({
		  type: "GET",
		  url: "get-sub-contractor-itemunit-rate"+"/"+rate_id,
		  dataType: 'html',
			//data: {vid: vid},
		  success: function(res)
			{
			   var dt=jQuery.parseJSON(res);
				
			   $("#rate_id").val(dt.rate_id);
			   $("#unit_name").val(dt.unit);
			   $("#unit_id").val(dt.unit_id);
			   $("#item_rate").val(dt.price);
			   
			   $(".unit").val(dt.unit);
			   $(".rate").val(dt.price.toFixed(2));
		   }
	    });
});
   
</script>

@endpush

@endsection
