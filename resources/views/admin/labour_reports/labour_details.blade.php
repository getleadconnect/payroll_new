	<style>
	@page { size: portrait; }
	.view-table tr,th,td
	{
		height:35px;
		padding-left:15px;
		border:1px solid #e4e4e4 ;
	}
	</style>
		
	<div style="width:100%;margin-left:20px;">
	
	@if(!empty($ldt))
	<p >
		<b>{{$cm->company_name}}</b></br>
		{{$cm->address }}</br>
		Email:{{$cm->email}}</br>
		Ph: {{$cm->mobile }}</br>
	</p>
	
	<hr>
	
	<label style="margin-top:15px;font-weight:600;" class="text-right" ><u>Labour Details</u></label>
	<br>
	
	<table border=0 cellpadding=0 cellspacing=0  class="view-table" style="width:95%;margin-top:15px;" >
	<tr><td class="td-width">Code</td><td id="business">{{$ldt->code}}</td></tr>
	<tr><td class="td-width">Name</td><td id="service"><b>{{$ldt->name}}</b></td></tr>
	<tr><td class="td-width">Address</td><td id="keywords">{{$ldt->address}}</td></tr>
	<tr><td class="td-width">Birth Date</td><td id="building">{{$ldt->birth_date}}</td></tr>
	<tr><td class="td-width">Gender</td><td id="building">{{$ldt->gender}}</td></tr>
	<tr><td class="td-width">Mobile</td><td id="street">{{$ldt->mobile}}</td></tr>
	<tr><td class="td-width">State</td><td id="land">{{$ldt->state}}</td></tr>
	<tr><td class="td-width">District</td><td id="area">{{$ldt->District}}</td></tr>
	<tr><td class="td-width">Nationality</td><td id="state" >{{$ldt->nationality}}</td></tr>
	<tr><td class="td-width">Aaadhar No</td><td id="city">{{$ldt->aadhar_no}}</td></tr>
		
	</table>
	
@else
	<p> Please select labour for display details.</p>
@endif	

	</div>
	