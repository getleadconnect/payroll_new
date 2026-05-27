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

/* chat box -------------------------------------*/

.chatbox {
    width: 400px !important;
}
.chatbox .nav {
    padding: .3rem 1rem 0 1rem !important;
    background: #6363d7;
    border: 0;
    justify-content: space-between;
}

.chatbox .chatbox-close {
    right: 400px !important;
}

.td-width{width:130px;}
.view-table td{height:25px;padding-left:7px; }		
.navlink:hover
{
	cursor:pointer;
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
						<h4 class="text-black fs-20">Labour Working Cost Entry</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('add-staffs')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> Add </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				<div class="d-flex py-3 align-items-center">


					<div class="table-responsive">
						<table id="datatable" class="display" style="width:140%">
							<thead>
								<tr>

									<th>No</th>
									<th>Action</th>
									<th>Status</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Qualification</th>
									<th>Aadhar/Pan</th>
									<th>Role</th>
									<th>Salary</th>	
									
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div><!-- d-flex end ------->
				
			</div>
		</div>
	</div>
			 
</div>


<!--<div class="chatbox active"> ---> 
<!---------- display classified details  --> 
	<div class="chatbox">
		<div class="chatbox-close"></div>
		<div class="custom-tab-1">
			<ul class="nav nav-tabs">
				<li>
					<a class="nav-link" data-toggle="tab" href="#notes">Staff Details</a>
				</li>
				<li>
					<a class="nav-link navlink" data-toggle="tab" id="close" >Close</a>
				</li>
			</ul>
			<div class="tab-content">
			<div class="tab-pane fade active show" id="chat" role="tabpanel" style="padding-left:10px;padding-right:5px;">
			
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
			url:"view-staffs",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  
				  {"width":"40px","targets":0},
				  {"width":"100px","targets":1},
				  {"width":"50px","targets":2},
				],
	
        columns: [
			{"data": "id" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "status" },
			{"data": "name" },
			{"data": "mob" },
			{"data": "quali" },
			{"data": "aadhar" },
			{"data": "role" },
			{"data": "sal",class:"text-right" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
 /*$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');

		var Result=$("#basicModal-2 .modal-body");
		
			$(this).attr('data-target','#basicModal-2');
		
				jQuery.ajax({
				type: "GET",
				url: "edit-staff"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });*/
  
$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			var cid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete-staff"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  alert("Supplier details successfully removed.");
				   }
				}
			});
		}
		
  });
    
 $("#close").click(function()
  {
	  $(".chatbox").removeClass('active');
  });
  
  $('#datatable tbody').on( 'click', '.btnview', function ()
  {
	  
		var sid=$(this).attr('id');
			jQuery.ajax({
			type: "GET",
			url: "get-staff-details"+"/"+sid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $(".tab-pane").html(res);
			   $(".chatbox").addClass('active');
			}
		});
  });
    
  $('#datatable tbody').on( 'click', '.btnActDeact', function ()
  {
		if(confirm("Are you sure, Activate/Deactivate this company?"))
		{
			var cid=$(this).attr('id');
			var op=$(this).attr('res');
				jQuery.ajax({
				type: "GET",
				url: "staff_activate_deactivate"+"/"+cid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
					  if(op==1)
					  {	  alert("Staff successfully Activated."); }
					  else{	alert("Staff successfully Deactivated."); }
				   }
				}
			});
		}
		
  });
  
</script>

@endpush

@endsection
