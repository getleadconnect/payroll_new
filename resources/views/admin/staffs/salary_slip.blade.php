<style>
.tbl-data tr
{
	height:30px;
}

.tsal
{
	font-size:16px;
}

</style>

<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
<button type="button" id="btnPrint" class="btn btn-secondary pr-3 pl-3"> Print </button>
</div>
</div>
@php
	 $mon=['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
@endphp
<div id="divPrint" style="width:550px;">
	<table  width="550px">
		<tr><td align="center" >{{$cm->company_name}}</td></tr>
		<tr><td align="center"> {{$cm->address }}</td></tr>
		<tr><td align="center">Email:{{$cm->email}}</td></tr>
		<tr><td align="center">Ph: {{$cm->mobile }}</td></tr>
		<tr><td align="center"> &nbsp;</td></tr>
		<tr><td align="center"> SALARY STATEMENT</td></tr>
		<tr><td align="center"> {{$mon[$stf->month-1]}}-{{$stf->year}}</td></tr>
		<tr><td align="center"> &nbsp;</td></tr>
	</table>

	<table class="tbl-data"  width="550px">
		<tr><td width="60px;"> Name:</td><td> {{ $stf->name}}</td> <td align="right">Date:{{date('d-m-Y')}}</td></tr>
		<tr><td colspan=3><hr></td></tr>
		<tr><td colspan=2> Basic Salary:</td><td align="right"> ₹ {{number_format($stf->salary,2,'.','')}}</td></tr>
		<tr><td colspan=2> Normal OT:</td><td align="right"> ₹ {{number_format($stf->normal_amt,2,'.','')}}</td></tr>
		<tr><td colspan=2> Sunday :</td><td align="right"> ₹ {{number_format($stf->sunday_amt,2,'.','')}}</td></tr>
		<tr><td colspan=3><hr></td></tr>
		<tr ><td colspan=2 style="font-size:14px;" align="right"><b>Total Salary:</b></td><td align="right" style="font-size:14px;"><b>₹ {{number_format($tsal,2,'.','')}}</b></td></tr>
		@if($stf->leave_no>0)
		<tr ><td colspan=2 style="font-size:14px;" align="right"><b>Leave ({{$stf->leave_no}}):</b></td><td align="right" style="font-size:14px;"><b>₹ {{number_format($stf->leave_amt,2,'.','')}}</b></td></tr>
		@endif
		<tr><td colspan=3><hr></td></tr>
		<tr ><td colspan=2 style="font-size:16px;" align="right"><b> Net Salary:</b></td><td align="right" style="font-size:16px;"><b>₹ {{number_format($nsal,2,'.','')}}<b></td></tr>
		<tr><td colspan=3><hr></td></tr>
		<tr><td colspan=2 align="right"></td><td>For Director</td></tr>
	</table>
</div>
<script>

$("#btnPrint").click(function()
{
	var prtContent = document.getElementById("divPrint");
	var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
	WinPrint.document.write(prtContent.innerHTML);
	WinPrint.document.close();
	WinPrint.focus();
	WinPrint.print();
	WinPrint.close();
});

</script>

