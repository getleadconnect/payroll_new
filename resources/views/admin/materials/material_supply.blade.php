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
						<h4 class="text-black fs-20">Material Supply - List</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('add-material-supply')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> Add Material Supply</a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->

				<div class="row mt-1 pt-2 pb-2 filter-box" >
				
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Project </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_project_id" name="flt_project_id" required>
					<option value="">--select--</option>
					@foreach($projs as $r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
					@endforeach
					</select>
					</div>
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">Supplier</label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
					<select class="form-control" id="flt_supplier_id" name="flt_supplier_id" required>
						<option value="">--select--</option>
						@foreach($supp as $r)
							<option value="{{$r->id}}">{{$r->supplier_name}}</option>
						@endforeach
					</select>
					</div>
					
					<div class="col-lg-1 col-xl-1 col-xxl-1">
						<button type="button" id="btnFilter" class="btn btn-secondary btn-size"  style="margin-top:3px;">Get</button>
					</div>
			    </div>

				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table id="datatable" class="display" style="width:180%">
							<thead>
								<tr>
									<th>No</th>
									<th>Action</th>
									<!--<th>Status</th>-->
									<th>Invoice</th>
									<th>Project</th>
									<th>Supplier</th>
									<th width="150px;">Item</th>
									<th>GST</th>
									<th>Supp.Date</th>
									<th>Supp.Time</th>
									<th>Lorry_No</th>	
									<th>Payment_type</th>											
									<th>Unit</th>
									<th>Qty</th>
									<th>Price</th>
									<th>Gst_Amt</th>
									<th>Round_Off</th>
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

$("#flt_project_id").select2();
$("#flt_supplier_id").select2();

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
			url:"view-material-supply",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			    data.project_id = $('#flt_project_id').val();
			    data.supplier_id = $('#flt_supplier_id').val();
		    },
          },
		
		columnDefs:[
					
				  {"width":"30px","targets":0},
				  {"width":"60px","targets":1},
				  {"width":"140px","targets":[3,4,5]},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			<!--{"data": "status" },-->
			{"data": "inv_no" },
			{"data": "project" },
			{"data": "supplier" },
			{"data": "item" },
			{"data": "gst" },
			{"data": "sdate" },
			{"data": "stime" },
			{"data": "lno" },
			{"data": "ptype" },
			{"data": "unit" },
			{"data": "qty",class:"text-right" },
			{"data": "price",class: "text-right"  },
			{"data": "gamt",class: "text-right"  },
			{"data": "roff",class: "text-right"  },
			{"data": "amt",class: "text-right"  },
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
	var id=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-material-supply"+"/"+id,
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
				url: "delete-material-supply"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Material supply successfully removed.");
				   }
				}
			});
		}
		
  });
 
  
</script>

@endpush

@endsection
