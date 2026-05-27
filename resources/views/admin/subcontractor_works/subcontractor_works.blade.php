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

.accordion__header {
    color: #fff !important;
    font-weight: 500 !important;
}
.form-control:disabled, .form-control[readonly] {
    background-color: #f5f5f5 !important;
    opacity: 1;
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
						<h4 class="text-black fs-20">Sub-Contractor Daily Works</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('add-subcontractor-works')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> Add </a>
				</div>
			</div>
			
		<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				
				<!--- filter ------------------------->
				<label style="position:relative;font-size:13px;z-index:99999;top:12px;"><b>Filter :</b></label>
				
				<div class="row p-2 filter-box" >
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label pr-0">Sub-Contractor</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					 <select class="form-control input-default " id="flt_subcontractor_id" name="flt_subcontractor_id" required>
						<option value="">--select--</option>
						@foreach($scon as $r)
						  <option value="{{$r->id}}">{{ $r->name }}</option>
						@endforeach
					 </select>
					</div>
				
				
				@if(Session::get('admin_role_id')!=4)
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Date</label>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
					<input type="date" class="form-control" id="flt_period_from" name="flt_period_from" value="{{$start_date}}" >
					</div>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
					<input type="date" class="form-control" id="flt_period_to" name="flt_period_to" value="{{$thu_date}}">
					</div>
				@endif


					<div class="col-lg-1 col-xl-1 col-xxl-1">
					<button type="button" class="btn btn-secondary btn-size" style="margin-top:3px;" id="btnFilter">Get</button>
					</div>
					
				</div>
				<!--- filter end ------------------------->

				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">

				<label style="width:100%;color: #0808bb;padding: 10px 20px;border: 1px solid #a5e3bf;border-radius:15px; background: #d6e7ddd9;">
					 Showing last 6 months data only. Use filters above to view different date ranges.
				</label>
				
				<div class="table-responsive mt-2">
						<table id="datatable" class="display" style="width:150%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th width="60px">Date</th>
									<th>Contractor</th>
									<th>Cost_Center</th>
									<th>Floor</th>
									<th>Item_name</th>
									<th>Description</th>
									<th>Unit</th>
									<th>Nos</th>
									<th>Length</th>
									<th>Bredth</th>
									<th>Width</th>
									<th>Qty</th>
									<th>Rate</th>
									<th>Amount</th>
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
			url:"view-subcontractor-works",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.contractor_id= $('#flt_subcontractor_id').val();
			   data.period_from = $('#flt_period_from').val();
			   data.period_to = $('#flt_period_to').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":0},
				  {"width":"40px","targets":1},
				  {"width":"200px","targets":[4,7]},
				  {"width":"50px","targets":[9,10,11,12,13,14,15]},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "cdate" },
			{"data": "scon" },
			{"data": "mcc" },
			{"data": "fno" },
			{"data": "iname" },
			{"data": "desc"},
			{"data": "unit" },
			{"data": "nos" ,class:"text-right" },
			{"data": "length",class:"text-right" },
			{"data": "bredth",class:"text-right" },
			{"data": "width",class:"text-right" },
			{"data": "qty",class:"text-right" },
			{"data": "rate",class:"text-right" },
			{"data": "amt",class:"text-right" },
			{"data": "addedby"},
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#btnFilter").click(function()
{
	table.draw();
})

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-subcontractor-work"+"/"+cid,
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
				url: "delete-subcontractor-work"+"/"+cid,
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
