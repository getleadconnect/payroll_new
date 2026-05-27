@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')


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
						<h4 class="text-black fs-20">Labour details report</h4>
					</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
					<!-- buttons here/data --------------->
				</div>
			</div>

			
			<div class="card-body pb-4 pt-0" id="RecentActivitiesContent">
				<!--<div class="d-flex py-3 border-bottom align-items-center"> -->
				
				<div class="row mt-3 p-2 filter-box">
				  <label class="col-xl-2 col-xxl-2 col-lg-2 col-form-label text-right" >Select Labours</label>
				  <div class="col-xl-4 col-xxl-4 col-lg-4">
					   <select class="form-control form-control-lg" id="flt_labour_id" name="flt_labour_id" required>
					   <option value="">--select--</option>
						@foreach($lbrs as $key=>$r)
						<option value="{{$r->id}}">{{$r->name}}</option>
						@endforeach
				    </select>
				  </div>

				<div class="col-xl-6 col-xxl-6 col-lg-6 text-right">
					<button type="button" id="btnPrint" class="btn btn-info btn-size"><i class="fas fa-print"></i>&nbsp;&nbsp;Print </button>
				</div>
				
				</div>

				
				<div class="lbr-details row mt-3 p-2">
				<div id="printArea" style="width:100%;">
				
				
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

$("#flt_labour_id").select2();

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


$("#btnPrint").prop('disabled',true);

	
$("#btnGet").click(function()
{
	if($('#project_id').val()!="")
	{
	   table.draw();
	}
});

	
 $('#flt_labour_id').change(function ()
  {
	var cid=$(this).val();
	$("#btnPrint").prop('disabled',false);
		
		jQuery.ajax({
		type: "GET",
		url: "get-labour-detail-report"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#printArea").html(res);
		}
		});
  });


$("#btnPrint").click(function()
{
	var prtContent = document.getElementById("printArea");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
});
 
  
</script>

@endpush

@endsection
