<link href="/hr_assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
<div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile">
                         
                        <div class="info">
                           
                             {!! Auth::user()->name; !!} 
                            <small></small>
                        </div>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav">
                    <li class="nav-header">Navigation</li>
<!-- **************************************************************************************************************************************** -->                    
                    <li @if(session('title') == 'Home') class="active" @endif><a href="/home"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
<!-- ***********************************************************Clients***************************************************************************** -->                   
                      
                    <li class="has-sub @if(session('title') == 'Clients')   active @endif">
                        <a href="javascript:;">
                             <b class="caret pull-right"></b>
                            <i class="fa fa-institution alias"></i> 
                            <span>Clients</span>
                        </a>
                        <ul class="sub-menu">
                            <li @if(session('subtitle') == 'clientsList') class="active" @endif><a href="\clients\index">List of Clients</a></li>
                            @if(Auth::user()->hasRole('clientAdd'))
                            <li @if(session('subtitle') == 'addClient') class="active" @endif><a href="\clients\add">Add Client</a></li>
                            @endif
                            <li @if(session('subtitle') == 'filterClient') class="active" @endif><a href="\clients\filter">Filter <i class="fa fa-filter text-theme m-l-5"></i></a></li> 
                            <li @if(session('subtitle') == 'filterContact') class="active" @endif><a href="\contacts\search">Search Contacts <i class="fa fa-binoculars text-theme m-l-5"></i></a></li>  
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Statement</a></li>
                        </ul>
                    </li>

                    
<!-- ***********************************************************Invoices***************************************************************************** -->                   

                     <li class="has-sub @if(session('title') == 'Invoices')   active @endif">
                        <a href="javascript:;">
                             <b class="caret pull-right"></b>
                            <i class="fa fa-file-text-o"></i> 
                            <span>Invoices</span>
                            </a>
                        <ul class="sub-menu">
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Report</a></li> 
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Add Invoice</a></li>    
                        </ul>
                    </li>
<!-- ***********************************************************Payments***************************************************************************** -->                   

                     <li class="has-sub @if(session('title') == 'Payments')   active @endif">
                        <a href="javascript:;">
                             <b class="caret pull-right"></b>
                            <i class="fa fa-money"></i> 
                            <span>Payments</span>
                            </a>
                        <ul class="sub-menu">
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Report</a></li> 
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">New Payment</a></li>    
                        </ul>
                    </li>
<!-- ***********************************************************Products***************************************************************************** -->                   

                     <li class="has-sub @if(session('title') == 'Products')   active @endif">
                        <a href="javascript:;">
                             <b class="caret pull-right"></b>
                            <i class="fa fa-database"></i> 
                            <span>Products</span>
                            </a>
                        <ul class="sub-menu">
                            <li @if(session('subtitle') == 'clientsList') class="active" @endif><a href="#">Items</a></li> 
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Add Item</a></li>   
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Categories</a></li>   
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Stock Report</a></li>   
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Transfer Report</a></li>    
                        </ul>
                    </li>
<!-- ***********************************************************Suppliers***************************************************************************** -->                   

                     <li class="has-sub @if(session('title') == 'Suppliers')   active @endif">
                        <a href="javascript:;">
                             <b class="caret pull-right"></b>
                            <i class="fa fa-list-alt"></i> 
                            <span>Suppliers</span>
                            </a>
                        <ul class="sub-menu">
                            <li @if(session('subtitle') == 'clientsList') class="active" @endif><a href="#">Suppliers List</a></li>  
                            <li @if(session('subtitle') == '#') class="active" @endif><a href="#">Statement</a></li>   
                        </ul>
                    </li>
 <!-- **********************************************************Administrator****************************************************************************** -->                    
                   @if( Auth::user()->hasRole('SuperUser') || Auth::user()->hasRole('userAdd'))
                    <li class="has-sub @if(session('title') == 'Administrator')   active @endif" >
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <i class="ion-star"></i>
                            <span>Administrator</span>
                        </a>
                        <ul class="sub-menu">
                            
                            <li @if(session('subtitle') == 'users') class="active" @endif><a href="/users">Users</a></li> 
                            <li @if(session('subtitle') == 'register') class="active" @endif><a href="/users/register">Add Users</a></li> 
                          @if( Auth::user()->hasRole('SuperUser')  )
                            <li @if(session('subtitle') == 'Roles') class="active" @endif><a href="/roles">Roles</a></li>
                            <li @if(session('subtitle') == 'addRoles') class="active" @endif><a href="/roles/create">Add Roles</a></li> 
                          @endif
                             
                        </ul>
                    </li>
                    @endif
 <!-- *************************************************************Settings*************************************************************************** -->                    
                    @if( Auth::user()->hasRole('contactAdd') || Auth::user()->hasRole('clientAdd'))
                    <li class="has-sub @if(session('title') == 'Settings')   active @endif" >
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <i class="fa fa-cogs"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sub-menu">  
                            <li @if(session('subtitle') == 'industries') class="active" @endif><a href="/settings/industries">Tax</a></li> 
                            <li @if(session('subtitle') == 'designations') class="active" @endif><a href="/settings/designations">Company Info</a></li> 
                        </ul>
                    </li>
                    @endif
                     
                     
                     
                     
                    <!-- begin sidebar minify button -->
                    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                    <!-- end sidebar minify button -->
                </ul>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>