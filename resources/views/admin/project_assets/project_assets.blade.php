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
						<h4 class="text-black fs-20">Project Assigned Asset Items</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!--<a href="{{url('asset-items')}}" class="btn btn-secondary btn-size pr-3 pl-3" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Assign project Items </a>-->
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="row mt-1 pt-2 pb-2 filter-box" >
				
				<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3">
				<select type="text" class="form-control" id="flt_project_id" name="flt_project_id" required>
				<option value="">--select--</option>
				@foreach($pros as $r)
				    <option value="{{$r->id}}">{{$r->project_name}}</option>
				@endforeach
				</select>
				</div>

			    </div>
	
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
					
					
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<th>Project</th>
									<th>Item Name</th>
									<th>Qty</th>
									<th>Ret_Status</th>
									<th>Ret_Date</th>
									<th>Ret_Qty</th>
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

	<div class="modal fade" id="basicModal-3" style="display: none;" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Return Item</h5>
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
			url:"view-project-assets",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.project_id = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"120px","targets":1},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "pname" },
			{"data": "iname" },
			{"data": "qty" },
			{"data": "status"},
			{"data": "rdate" },
			{"data": "rqty"},
			{"data": "addedby"},
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
$("#flt_project_id").change(function()
{
	table.draw();
});

$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var aid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-project-asset"+"/"+aid,
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
			url: "delete-project-asset-item"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				  table.draw();
				  alert("Project asset item successfully removed.");
			   }
			}
		});
	}
		
  });

  
  $('#datatable tbody').on( 'click', '.return_item', function ()
  {
	var aid=$(this).attr('id');

		var Result=$("#basicModal-3 .modal-body");
		
			$(this).attr('data-target','#basicModal-3');
		
				jQuery.ajax({
				type: "GET",
				url: "return-project-asset-item"+"/"+aid,
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
