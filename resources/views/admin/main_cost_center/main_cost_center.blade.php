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

table.dataTable tfoot th, table.dataTable tfoot td {
    padding: 10px 12px 6px 18px;
    border-top: 1px solid #111;
	font-size:14px !important;
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
						<h4 class="text-black fs-20">Labour Cost Schedule</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<button type="button" class="btn btn-secondary btn-size" data-toggle="modal" data-target="#basicModal-1"><i class="fas fa-plus"></i> Add </button>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				
				<form method="post" action="{{url('main-cost-centers')}}">
				@csrf
				<div class="row mt-1 pt-2 pb-2 filter-box">
				
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Project </label>
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					<select class="form-control" id="flt_project_id" name="flt_project_id" required>
					<option value="">--select--</option>
					@foreach($proj as $r)
						<option value="{{$r->id}}">{{$r->project_name}}</option>
					@endforeach
					</select>
					</div>
				<div class="col-lg-1 col-xl-1 col-xxl-1">
				  <button type="submit" class="btn btn-secondary btn-xs btn-sm mt-1">Get</button>
				</div>
					
				<div class="col-lg-6 col-xl-6 col-xxl-6 text-right">
				
				@php
				$total=0.00;
				if(array_key_exists("0",$mcosts) and array_key_exists("total_amount",$mcosts[0]))
				{
					$total=$mcosts[0]['total_amount'];
				}
				@endphp
				
				  <label class="col-form-label" style="font-size:16px;" >Total Amount:&nbsp;&nbsp;<b><span id="tot_Amount">{{$total}}</span></b></label>
				</div>

			    </div>
			</form>

				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Project</th>
									<th>Floor</th>
									<th>Main_Item</th>
									<th>Quantity</th>
									<th>Amount</th>
									<th>Added_By</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							@foreach($mcosts as $r)
							
							<tr>	
								<td>{{$r['slno']}}</td>
								<td>{{$r['proj']}}</td>
								<td>{{$r['mitem']}}</td>
								<td>{{$r['floorno']}}</td>
								<td class="text-right">{{$r['sqty']}} </td>
								<td class="text-right">{{$r['samt']}}</td>
								<td>{{$r['addedby']}}</td>
								<td>{!! $r['action'] !!}</td>
							</tr>
							@endforeach
							
							</tbody>
							<tfoot>
							
							<tr>	
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>Total</th>
								<th class="text-right">{{$total}}</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
							</tr>
							
							</tfoot>
							
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
					<h5 class="modal-title">Add Client</h5>
					<button type="button" class="close" data-dismiss="modal"><span>×</span>
					</button>
				</div>
				<div class="modal-body" style="padding-bottom:.5rem;">
				
				<form method="POST" action="{{url('save-cost-center')}}" enctype="multipart/form-data">
				@csrf
	
				<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Project Name</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					   <select class="form-control" name="project_id" required>
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
				<label class="col-lg-3 col-xl-3 col-xxl-3 pr-0 col-form-label">Main Cost Items</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					   <select class="form-control" name="main_cost_item_id" required>
					   <option value="">--select--</option>
						 @foreach($mitems as $r)
					  <option value="{{$r->id}}">{{$r->main_item}}</option>
				   @endforeach
					   </select>
					</div>
                </div>
				</div>
				
				<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Floor Nos</label>
					<div class="col-lg-8 col-xl-8 col-xxl-8">
					   <select class="form-control" name="floor_no_id" required>
					   <option value="">--select--</option>
						 @foreach($flrnos as $r)
							<option value="{{$r->id}}">{{$r->floor_no}}</option>
						 @endforeach
					   </select>
					</div>
                </div>
				</div>

				<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Schedule Qty</label>
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					   <input type="text" class="form-control input-default " name="schedule_qty" required>
					</div>
                </div>
				</div>

				<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Amount</label>
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					   <input type="text" class="form-control input-default " name="schedule_amount" required>
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
        //serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :50,
		scrollX: true,
});

/*		
		'pagingType':"simple_numbers",
        'lengthChange': true,

        ajax:
		{
			url:"view-cost-centers",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.project_id = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"70px","targets":7},
				  
				],
	
        columns: [
            {"data": "id" },
			{"data": "proj" },
			{"data": "floorno" },
			{"data": "mitem" },
			{"data": "sqty" ,class:"text-right" },
			{"data": "samt" ,class:"text-right" },
			{"data": "addedby"},
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
						
			var dataArr = [];
			$.each($("#datatable tr"),function(){ //get each tr which has selected class
				dataArr.push($(this).find('td').eq(5).text().replace(',',''));
			});
			
			let v1=0;
			for(i=0;i<=dataArr.length;i++)
			{
				if($.isNumeric(dataArr[i]))
				{
					v1+=parseFloat(dataArr[i]);
				}
			}
			$("#tot_Amount").html(v1);
			
		},

	/*"footerCallback": function (row, data, start, end, display) {
                
				var api=this.api();
				total = this.api()
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);
				
				$("#tot_Amount").html("₹ "+total.toFixed(2));
				$( api.column( 4 ).footer()).html('Total');
				$( api.column( 5 ).footer()).html("₹ "+total.toFixed(2));
	},*/
	
/*});*/

	
$("#flt_project_id").change(function()
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
				url: "edit-cost-center"+"/"+cid,
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
				url: "delete-cost-center"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  alert("Main cost center successfully removed.");
					  location.reload();
				   }
				}
			});
		}
		
  });
  
  
 
</script>

@endpush

@endsection
