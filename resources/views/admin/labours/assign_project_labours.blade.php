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
						<h4 class="text-black fs-20">Assign labours to project</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right pr-0">
					<a href="{{url('project-labours')}}" class="btn btn-secondary btn-size" ><i class="fas fa-plus"></i> View Project Labours</a>
				</div>
			</div>
			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">

				<div class="row mt-1 p-2 filter-box">
					<label class="col-lg-2 col-xl-2 col-xxl-2 text-right col-form-label">Select Skill</label>
						<div class="col-lg-3 col-xl-3 col-xxl-3">
						<select class="form-control" id="flt_skill_type" name="flt_skill_type">
						<option value="">--select--</option>
						@foreach($skill as $r)
						<option value="{{$r->id}}">{{$r->skill_type}}</option>
						@endforeach
						</select>
					</div>
				</div>
				
				
				<div class="row mt-2">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
					<label class="mb-3 mt-3"><b><u>Labours</u></b></label>
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6 text-right">
				
				<input type="hidden" id="lbrcount" value="0">  <!-- selected labours id count --->
				
				<a href="#" id="btn-assign-labours" class="btn btn-secondary btn-size" data-toggle="modal" ><i class="fas fa-plus"></i> Assign labours </a>
				</div>
				</div>

				<div class="row mt-2">
				  <div class="col-lg-12 col-xl-12 col-xxl-12">

					<div class="table-responsive">
						<table id="datatable" class="display" style="width:100%">
							<thead>
								<tr>
									<th></th>
									<th>No</th>
									<th>Code</th>
									<th>Name</th>
									<th>Skill</th>
									<th>Wage_Status</th>
									<!--<th width="100px">Action</th>-->
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
					<h5 class="modal-title">Assign Labours</h5>
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
			url:"view-labour-details",
			data: function (data) 
		    {
               data.search = $('input[type="search"]').val();
			   data.searchBySkill = $('#flt_skill_type').val();
		    },
          },
		
		columnDefs:[
				  {"width":"40px","targets":0},
				],
	
        columns: [
			{"data": "selbtn" },
			{"data": "slno" },
			{"data": "code" },
			{"data": "name" },
			{"data": "sktype" },
			{"data": "wstat" },
			//{"data": "action" ,name: 'Action',orderable: false, searchable: false},
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
	
	$("#flt_skill_type").change(function()
	{
		table.draw();
	});
	
		
 $('#datatable tbody').on( 'click', '.sub_chk', function ()
  {
	
		var wval=$(this).closest('tr').find("td:eq(5) input[type='hidden']").val();
		if(wval=="0")
		{
			Swal.fire('',"Please set this labour's wage details.");
			$(this).prop('checked',false);
		}
		else
		{
			$(this).closest('tr').toggleClass('selected');

			if($(this).is(':checked',true))  
			{
			   var cnt=parseInt($("#lbrcount").val())+1;
			   $("#lbrcount").val(cnt);  
			}  
			else  
			{  
			   var cnt=parseInt($("#lbrcount").val())-1;
			   $("#lbrcount").val(cnt) ;
			}  
		}
  });
	
	
$("#btn-assign-labours").click(function()
  {
	  
		var lbid="";
		var lbrcnt=$("#lbrcount").val();
		
		$.each($("#datatable tr.selected"),function()
		{ 
			//lbid+=","+$(this).find('td').eq(0).text(); 
			lbid+=","+$(this).find('.sub_chk').attr('data-id'); 
		});
		
		if($.trim(lbid).length<=0)
			{
				$("#btn-assign-labours").attr('data-target',"");
				alert("Please select labours.","");
				//swal("Cancelled", "Please select students.","");
			}
			else
			{
				var Result=$("#basicModal-1 .modal-body");
				
				$("#btn-assign-labours").attr('data-target','#basicModal-1');
				
					jQuery.ajax({
					type: "POST",
					url: "set-labours-to-project",
					dataType: 'html',
					data: {_token:"{{ csrf_token() }}",labour_id:lbid,labour_count:lbrcnt},
					success: function(res)
					{
					   Result.html(res);
					}
				});
			}
  }); 
  

	
	
 $('#datatable tbody').on( 'click', '.setWage', function ()
  {
	var id=$(this).attr('id');

		var Result=$("#basicModal-1 .modal-body");
		
			$(this).attr('data-target','#basicModal-1');
		
				jQuery.ajax({
				type: "GET",
				url: "set-labour-wage"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
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
  
</script>

@endpush

@endsection
