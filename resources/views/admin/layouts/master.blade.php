<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ashwani infra</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/chartist/css/chartist.min.css')}}">
    <!--<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" >-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/lineicons.2.0.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('assets/vendor/owl-carousel/owl.carousel.css')}}" >
	<link rel="stylesheet" href="{{asset('assets/vendor/datatables/css/jquery.dataTables.min.css')}}" >
	<link rel="stylesheet" href="{{ asset('assets/datatable/buttons.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free-5.15-web/css/all.min.css')}}" type="text/css" />
	<link href="{{ asset('assets/vendor/toastr/css/toastr.min.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet">
	<link  href="{{ asset('assets/vendor/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet">

</head>

<style>
/*[data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu > li > a i {
    color: #2f7a10 !important;
	font-size:10px !important;
}*/
[data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu > li > a i {
    color: #fff !important;
    font-size: 15px !important;
}


</style>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
           <a href="javascript:;" class="brand-logo">
               <!--<img class="logo-abbr" src="{{asset('assets/images/logo.png')}}" alt="">
                <img class="logo-compact" src="{{asset('assets/images/logo-1.png')}}" alt="">
                <img class="brand-title" src="{{asset('assets/images/logo-1.png')}}" alt="">-->    
                ASHVANIINFRA  
             </a>    

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
							<div class="dashboard_bar">
								Administrations
							</div>
                        </div>

                        <ul class="navbar-nav header-right">
						<!---- user section ---------------------------------------------------->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="{{asset('assets/images/profile/1.png')}}" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">{{Session::get('admin_name')}}</span>
                                    </a>

                                    <a href="{{ route('admin.logout') }}" class="dropdown-item ai-icon" onclick="event.preventDefault();document.getElementById('logout-form2').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout</span>
                                    </a>
									<form id="logout-form2" action="{{ route('admin.logout') }}" method="POST" class="d-none">
										@csrf
									</form>
                                </div>
                            </li>
						<!--------------------------------------------------------------------->

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

		@include('admin.layouts.sidebar_new');
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
			
			
			<!--**********************************
                body Contents
            ***********************************-->
			
			@yield('contents')
			
			<!--**********************************
                body Contents end
            ***********************************-->


            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by : <a href="https://webqua.com/" target="_blank">Webqua.com</a> 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
	<!--<script src="{{asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>-->
	<script src="{{asset('assets/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
	<script src="{{asset('assets/js/deznav-init.js')}}"></script>
	<!-- Apex Chart -->
	<!--<script src="{{asset('assets/vendor/apexchart/apexchart.js')}}"></script>-->
	
	<script src="{{asset('assets/vendor/counter/counterup.min.js')}}"></script>
	<script src="{{asset('assets/vendor/counter/waypoints-min.js')}}"></script>
	<script src="{{ asset('assets/vendor/toastr/js/toastr.min.js')}}"></script>
	<script src="{{ asset('assets/vendor/moment/moment.min.js')}}"></script>
	<!-- Dashboard 1 -->
	<!--<script src="{{asset('assets/js/dashboard/distance-map.js')}}"></script>-->
	
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{ asset('assets/datatable/dataTables.buttons.min.js')}}" type="text/javascript"> </script>
	<script src="{{ asset('assets/datatable/jszip.min.js')}}" type="text/javascript"> </script>
	<script src="{{ asset('assets/datatable/pdfmake.min.js')}}" type="text/javascript"> </script>
	<script src="{{ asset('assets/datatable/vfs_fonts.js')}}" type="text/javascript"> </script>
	<script src="{{ asset('assets/datatable/buttons.html5.min.js')}}" type="text/javascript"> </script>
	<script src="{{ asset('assets/datatable/buttons.print.min.js')}}" type="text/javascript"> </script>

	<script src="{{ asset('assets/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>
	<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js')}}"></script>
	
	<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
	
	<script src="{{ asset('assets/vendor/select2/js/select2.full.min.js')}}"></script>
    <!--<script src="{{ asset('assets/js/plugins-init/select2-init.js')}}"></script>-->

	@stack('scripts')
	
	<script>
    jQuery(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 5,
            time: 2000
        });
    });
  </script>
  
 
	
  
</body>
</html>