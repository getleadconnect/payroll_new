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
						<h4 class="text-black fs-20">Project Labours <small>(Assigned)</small></h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<a href="{{url('assign-labours')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> Assign Labours </a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">

						<div class="row p-2 filter-box">
						
								<label class="col-lg-1 col-xl-1 col-xxl-1 text-right col-form-label">Project</label>
								<div class="col-lg-3 col-xl-3 col-xxl-3">
								<select class="form-control" id="flt_project_id" name="flt_project_id">
								<option value="">--select--</option>
								@foreach($proj as $r)
								<option value="{{$r->id}}">{{$r->project_name}}</option>
								@endforeach
								</select>
								</div>
								
								<label class="col-lg-1 col-xl-1 col-xxl-1 text-right col-form-label pr-0">Skill Type</label>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<select class="form-control" id="flt_skill_type" name="flt_skill_type">
								<option value="">--select--</option>
								@foreach($skill as $r)
								<option value="{{$r->id}}">{{$r->skill_type}}</option>
								@endforeach
								</select>
								</div>
								
								<div class="col-lg-1 col-xl-1 col-xxl-1">
								<button type="button" id="btnFilter" class="btn btn-secondary btn-xs mt-1">Get</button>
								</div>
						</div>


				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
			
					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Code</th>
									<th>Labour Name</th>
									<th>Skill</th>
									<th style="width:230px;">Project_Name</th>
									<th style="width:230px;">Period</th>
									<th>Status</th>
									<th>Added_By</th>
									<th width="100px">Action</th>
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

$("#flt_project_id").select2();
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
			url:"view-project-labours",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchBySkill = $('#flt_skill_type').val();
			   data.searchByProject = $('#flt_project_id').val();
		    },
          },
		
		columnDefs:[
				  {"width":"30px","targets":[0,1]},
				  {"width":"170px","targets":2},
				  {"width":"230px","targets":[4,5]},
				  {"width":"40px","targets":8},
				],
	
        columns: [
			{"data": "slno" },
			{"data": "lcode" },
			{"data": "lname" },
			{"data": "sktype" },
			{"data": "pname" },
			{"data": "sedate" },
			{"data": "status" },
			{"data": "addedby" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false},
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
	$("#btnFilter").click(function()
	{
		if($("#flt_project_id").val()!="" || $("#flt_skill_type").val()!="")
		{
		   table.draw();
		}
	});
	

  /*$('#datatable tbody').on( 'click', '.edit', function ()
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
  });*/
  


$('#datatable tbody').on( 'click', '.btnRelease', function ()
  {
	var id=$(this).attr('id');
	
	var Result=$("#basicModal-2 .modal-body");
	
	   $("#basicModal-2 .modal-title").html('Release Labour');
	   
		$(this).attr('data-target','#basicModal-2');
	
		jQuery.ajax({
			type: "GET",
			url: "release-project-labour"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});

  });

  
$('#datatable tbody').on('click', '.btndel', function ()
  {
		var id=$(this).attr('id');
			Swal.fire({
			  title: 'Are you sure?',
			  text: "You want to remove this labour!",
			  //icon: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Yes Delete !!',
			}).then((result) => {
			  /* Read more about isConfirmed, isDenied below */
			  if (result.isConfirmed) {
				jQuery.ajax({
					type: "GET",
					url: "delete-project-labour"+"/"+id,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   if(res==1)
					   {
						  table.draw();
						  Swal.fire("Labour successfully removed.");
					   }
					}
				});
			}
		});
});
    
   
</script>

@endpush

@endsection
