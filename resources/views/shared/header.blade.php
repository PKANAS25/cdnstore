<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="#" class="navbar-brand"><span class="navbar-logo"></span> CDN Store</a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					 
					<li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
							<i class="fa fa-bell-o"></i>
							<!-- <span class="label">5</span>  --> 
						</a>
						<ul class="dropdown-menu media-list pull-right animated fadeInDown">
                            <li class="dropdown-header">Notifications</li>
                            
                            
                            <li class="media">
                                <a href="/refunds/tickets/unassigned">
                                    <div class="media-left"><!-- <i class="fa fa-phone media-object bg-blue"></i> --></div>
                                    <div class="media-body">
                                        <h6 class="media-heading"> No new Notifications</h6>
                                        <!-- <div class="text-muted f-s-11">Assign call center agents</div> -->
                                    </div>
                                </a>
                            </li>
                           

                            
						</ul>
					</li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="/hr_assets/img/user-12.jpg" alt="" /> 
							<span class="hidden-xs">{!! Auth::user()->name !!}</span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li class="arrow"></li>
							<li><a href="/webmail" target="_blank">Inbox</a></li> 
                            <li><a href="/users/password/edit/self">Change Password</a></li>
							<li class="divider"></li>
							<li><a href="/logout">Logout</a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>