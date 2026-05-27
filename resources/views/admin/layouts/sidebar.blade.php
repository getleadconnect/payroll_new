 <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
				@php
					$role=Session::get('admin_role_id');
				@endphp
				
				@if($role==1)
				
					<li><a href="{{url('dashboard')}}" class="ai-icon" aria-expanded="false">
							<!--<i class="flaticon-381-networking"></i>-->
							<i class="fas fa-circle"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Revenue</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('revenues')}}"><i class="fas fa-caret-right"></i>Revenue</a></li>
                            <!--<li><a href="{{url('revenue-balance')}}"><i class="fas fa-caret-right"></i>Revenue Balance</a></li>-->
                        </ul>
                    </li>

                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Master</span>
						</a>
                        <ul aria-expanded="false">
                            <!--<li><a href="{{url('company')}}"><i class="fas fa-caret-right"></i>Company</a></li>-->
                            <li><a href="{{url('clients')}}"><i class="fas fa-caret-right"></i>Clients</a></li>
							<li><a href="{{url('project-types')}}"><i class="fas fa-caret-right"></i>Project Types</a></li>
							<li><a href="{{url('projects')}}"><i class="fas fa-caret-right"></i>Projects</a></li>
							<li><a href="{{url('staff-roles')}}"><i class="fas fa-caret-right"></i>Staff Roles</a></li>
							<li><a href="{{url('material-units')}}"><i class="fas fa-caret-right"></i>Material Units</a></li>
							<li><a href="{{url('material-gst')}}"><i class="fas fa-caret-right"></i>Material GST</a></li>
							<li><a href="{{url('skill-types')}}"><i class="fas fa-caret-right"></i>Skill Types</a></li>
							<li><a href="{{url('payment-types')}}"><i class="fas fa-caret-right"></i>Payment Types</a></li>
							<li><a href="{{url('floors')}}"><i class="fas fa-caret-right"></i>Floor Nos</a></li>
							<li><a href="{{url('material-types')}}"><i class="fas fa-caret-right"></i>Material Types</a></li>
							<li><a href="{{url('material-sub-types')}}"><i class="fas fa-caret-right"></i>Material Sub-Types</a></li>
							<li><a href="{{url('main-cost-centers')}}"><i class="fas fa-caret-right"></i>Main Cost Center</a></li>
							<li><a href="{{url('main-cost-items')}}"><i class="fas fa-caret-right"></i>Main cost center items</a></li>
							<li><a href="{{url('misc-category')}}"><i class="fas fa-caret-right"></i>Misc/Other Category</a></li>
							<li><a href="{{url('misc-vendors')}}"><i class="fas fa-caret-right"></i>Misc Vendors</a></li>
                        </ul>
                    </li>

					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<!--<i class="flaticon-381-television"></i>-->
							<i class="fas fa-circle"></i>
							<span class="nav-text">Assets</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('asset-category')}}"><i class="fas fa-caret-right"></i>Asset Category</a></li>
                            <li><a href="{{url('asset-items')}}"><i class="fas fa-caret-right"></i>Asset Items</a></li>
							<li><a href="{{url('assign-project-assets')}}"><i class="fas fa-caret-right"></i>Assign to Project</a></li>
							<li><a href="{{url('project-assets')}}"><i class="fas fa-caret-right"></i>Project Asset Items</a></li>
                        </ul>
                    </li>
					
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Suppliers</span>
						</a>
                        <ul aria-expanded="false">
                           <li><a href="{{url('suppliers')}}"><i class="fas fa-caret-right"></i>Suppliers</a></li>
						   <li><a href="{{url('material-prices')}}"><i class="fas fa-caret-right"></i>Material Prices</a></li>

                        </ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Sub-Contractors</span>
						</a>
                        <ul aria-expanded="false">
                           <li><a href="{{url('sub-contractors')}}"><i class="fas fa-caret-right"></i>Sub-contractors</a></li>
						   <li><a href="{{url('sub-contractor-items')}}"><i class="fas fa-caret-right"></i>Sub-contractor Items</a></li>
						   <li><a href="{{url('sub-contractor-rates')}}"><i class="fas fa-caret-right"></i>Sub-contractor Rates</a></li>
						   <li><a href="{{url('sub-contractor-works')}}"><i class="fas fa-caret-right"></i>Sub-contractor works</a></li>
                        </ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Materials</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('material-supply')}}"><i class="fas fa-caret-right"></i>Material Supply</a></li>
                        </ul>
                    </li>
					
                    <!--<li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-settings-2"></i>
							<span class="nav-text">Widget</span>
						</a>
					</li>-->
					
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Labours</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('labours')}}"><i class="fas fa-caret-right"></i>Labours</a></li>
							<li><a href="{{url('labour-wages')}}"><i class="fas fa-caret-right"></i>Labour Wages</a></li>
							<li><a href="{{url('project-labours')}}"><i class="fas fa-caret-right"></i>View Project Labours</a></li>
							<li><a href="{{url('assign-labours')}}"><i class="fas fa-caret-right"></i>Assign Project Labours</a></li>
							
							<li><a href="{{url('all-labour-wages ')}}"><i class="fas fa-caret-right"></i>View Labour Wages</a></li>
                        </ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Staffs</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('staffs')}}"><i class="fas fa-caret-right"></i>Staffs</a></li>
							<li><a href="{{url('project-staffs')}}"><i class="fas fa-caret-right"></i>Assign Project Staffs</a></li>
							<li><a href="{{url('salary-increments')}}"><i class="fas fa-caret-right"></i>Salary & Increments</a></li>
							<li><a href="{{url('staff-salary')}}"><i class="fas fa-caret-right"></i>Staff Salary</a></li>
							
                        </ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Daily Entry</span>
						</a>
                        <ul aria-expanded="false">
                        	<li><a href="{{url('labour-daily-wages')}}"><i class="fas fa-caret-right"></i>Daily Labour Wages</a></li>    
							<!--<li><a href="{{url('misc-expenses')}}"><i class="fas fa-caret-right"></i>Misc Expenses</a></li>-->
							<li><a href="{{url('misc-site-expenses')}}"><i class="fas fa-caret-right"></i>Misc Site Expenses</a></li>
							<li><a href="{{url('misc-works')}}"><i class="fas fa-caret-right"></i>Misc Works (GST)</a></li>
							<li><a href="{{url('staff-over-times')}}"><i class="fas fa-caret-right"></i>Staff Over Times</a></li>
                        </ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Reports</span>
						</a>
                        <ul aria-expanded="false">
                        	<li><a href="{{url('weekly-work-reports')}}"><i class="fas fa-caret-right"></i>Weekly Labour Works</a></li> 
							<li><a href="{{url('labour-details-report')}}"><i class="fas fa-caret-right"></i>Labour Details</a></li>
							<li><a href="{{url('project-reports')}}"><i class="fas fa-caret-right"></i>Projects Report</a></li>
							<li><a href="{{url('miscellaneous-report')}}"><i class="fas fa-caret-right"></i>Miscellaneous-Non GST </a></li>
							<li><a href="{{url('miscellaneous-gst-report')}}"><i class="fas fa-caret-right"></i>Miscellaneous-GST</a></li>
							<li><a href="{{url('misc-non-gst-office-payment')}}"><i class="fas fa-caret-right"></i>Miscellaneous Non-GST Office</a></li>
							<li><a href="{{url('misc-gst-office-payment')}}"><i class="fas fa-caret-right"></i>Miscellaneous GST Office</a></li>
							
							<li><a href="{{url('subcontractor-work-report')}}"><i class="fas fa-caret-right"></i>Sub-Contractor Works</a></li>
							<li><a href="{{url('material-gst-office-payment')}}"><i class="fas fa-caret-right"></i>Material-GST Office</a></li>
							<li><a href="{{url('staff-salary-report')}}"><i class="fas fa-caret-right"></i>Staff Salary Report</a></li>
							<li><a href="{{url('summation-report')}}"><i class="fas fa-caret-right"></i>Summation Weekly</a></li>
						</ul>
                    </li>
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fas fa-circle"></i>
							<span class="nav-text">Users</span>
						</a>
                        <ul aria-expanded="false">
                        	<li><a href="{{url('admin-users')}}"><i class="fas fa-caret-right"></i>Admin Users</a></li>    
							
                        </ul>
                    </li>
					
			@elseif($role==5) <!-- HR USER	--->
			
			
			@endif 

			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->