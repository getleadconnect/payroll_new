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
 
 .col-width
 {
	 min-width:100px !important;
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
						<h4 class="text-black fs-20">Set Labour Wages</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<a href="{{url('add-labour')}}" class="btn btn-secondary pr-3 pl-3" ><i class="fas fa-plus"></i> Add </a>-->
				</div>
			</div>
			
			<div class="card-body pb-4" id="RecentActivitiesContent">

				<label class="mb-2"><b><u>Add Wages</u></b></label>
				<div class="row">
				<div class="col-lg-5 col-xl-5 col-xxl-5">

					<div class="row p-2">
						<label class="col-lg-3 col-xl-3 col-xxl-3 text-right col-form-label">Select Skill</label>
							<div class="col-lg-8 col-xl-8 col-xxl-8">
							<select class="form-control" id="flt_skill_type" name="flt_skill_type">
							<option value="">--select--</option>
							@foreach($skill as $r)
							<option value="{{$r->id}}">{{$r->skill_type}}</option>
							@endforeach
							</select>
						</div>
					</div>
				</div>
				
				<div class="col-lg-7 col-xl-7 col-xxl-7">

					<div class="row p-2 filter-box">
							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label pr-0">Set Labour Wage</label>
							<div class="col-lg-8 col-xl-8 col-xxl-8">
							<select class="form-control" id="labour_id" name="labour_id" data-toggle="modal">
							<option value="">--select labour--</option>

							</select>
						</div>
					</div>
				</div>
				
				</div>	
				
		<hr style="margin:5px 0px;">				
				
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				<label class="mb-3"><b><u>Labour Wages</u></b></label>
				
				    <div class="table-responsive">
						<table id="datatable1" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Date</th>
									<th>Code</th>
									<th>Name</th>
									<th>Normal</th>
									<th>Concrete</th>
									<th>OT</th>
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
				<h5 class="modal-title">Set Wages</h5>
				<button type="button" class="close" data-dismiss="modal"><span>×</span>
				</button>
			</div>
			<div class="modal-body" style="padding-bottom:.5rem;">
			
			
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

 $("#labour_id").select2();
 $("#flt_skill_type").select2();
 
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

	$("#flt_skill_type").change(function()
	{
		var skid=$(this).val();

		jQuery.ajax({
			type: "GET",
			url: "view-labour-data"+"/"+skid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  $("#labour_id").html(res);
			}
		});
	});
	
	
	
    var table1 = $('#datatable1').DataTable({
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
			url:"view-labour-wages",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"30px","targets":0},
				  {"width":"80px","targets":1},
				  
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false,},
			{"data": "wdate" },
			{"data": "code" },
			{"data": "name" },
			{"data": "wnormal",class:"text-right" },
			{"data": "wcon",class:"text-right" },
			{"data": "wot",class:"text-right" },
			{"data": "addedby"},
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
	
 });

$("#labour_id").change(function()
  {
	var id=$(this).val();

			
			var Result=$("#basicModal-1 .modal-body");
			//$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "set-labour-wage"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				   $("#basicModal-1").modal('show');
				}
			});
  });
  
  
  $('#datatable1 tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');

	var Result=$("#basicModal-2 .modal-body");
	
	$(this).attr('data-target','#basicModal-2');

		jQuery.ajax({
		type: "GET",
		url: "edit-labour-wage"+"/"+id,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   Result.html(res);
		}
	});
	
  });

  
/*$('#datatable1 tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var id=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-labour"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Labour successfully removed.");
				   }
				}
			});
		}
		
  });*/
    
  
  $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var cid=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "labour_activate_deactivate"+"/"+id+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Labour successfully Activated."); }
					  else{	alert("Labour successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
  
  $(document).on('click','#conf',function()
  {
	  return confirm("Are you sure, delete this?");
	  
  });
  
</script>

@endpush

@endsection
