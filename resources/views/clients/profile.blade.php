@extends('hrMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => '']); ?>
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="/hr_assets/dist/msgbox/jquery.msgbox.css" />
<script type="text/javascript" src="/hr_assets/dist/msgbox/jquery.msgbox.min.js"></script>

<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Clients</a></li>
                <li><a href="javascript:;">Profile</a></li>
                 
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Client Profile <small> </small></h1>
            <!-- end page-header -->
            <!-- begin profile-container -->
            <div class="profile-container">
                <!-- begin profile-section -->
                <div class="profile-section">
                    <!-- begin profile-left -->
                    <div class="profile-left">
                        <!-- begin profile-image -->
                        <div class="profile-image">
                            <img src="{!! $profile_pic !!}" />
                            <i class="fa fa-user hide"></i>
                        </div>
                        <!-- end profile-image -->
                         
                        <!-- begin profile-highlight -->
                         

                        <div>
                            <div class="checkbox m-b-5 m-t-0">
                            @if(Auth::user()->hasRole('contactAdd'))
                                <a href="{{action('ContactsController@add',base64_encode($client->id))}}" class="btn btn-inverse btn-xs m-r-5"><i class="fa fa-user"></i> New Contact</a>  
                             @else
                             <a href="#" class="btn btn-default btn-xs m-r-5"><i class="fa fa-user"></i> New Contact</a>   
                            @endif    
                            </div> 

                            
                            <div class="checkbox m-b-5 m-t-0">
                                <a href="{{action('CallsController@add',base64_encode($client->id))}}" class="btn btn-warning btn-xs m-r-5"><i class="fa fa-phone"></i> New Call</a>  
                            </div> 
 
                            <div class="checkbox m-b-5 m-t-0">
                                @if(Auth::user()->hasRole('clientAdd'))
                                <a href="{{action('ClientsController@edit',base64_encode($client->id))}}" class="btn btn-success btn-xs m-r-5"><i class="fa fa-edit"></i> Edit Profile</a> 
                                @else 
                                <a href="#" class="btn btn-default btn-xs m-r-5"><i class="fa fa-edit"></i> Edit Profile</a> 
                                @endif
                            </div> 
                        </div>

                     
                        <!-- end profile-highlight -->
                    </div>
                    <!-- end profile-left -->
                    <!-- begin profile-right -->
                    <div class="profile-right">
                        <!-- begin profile-info -->
                        <div class="profile-info">
                            <!-- begin table -->
                            <div class="table-responsive">
                            @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}   
                                        </div>
                                    @endif
                                <table class="table table-profile table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <h4>{{ $client->name }} <small>{!! $client->industryName !!}</small></h4>
                                            </th>
                                        </tr>
                                    </thead> 

                                    <tbody>
                                        <tr class="highlight">
                                            <td class="field">Status</td>
                                            <td>{{ $client->currentStatus }}</td>
                                        </tr> 
                                        <tr>
                                            <td class="field">Parent Company</td>
                                            <td>
                                            @if($client->parentCompany)
                                            <a href="{{action('ClientsController@profile',base64_encode($client->parent_company))}}">{{ $client->parentCompany }}</a> 
                                            @else None 
                                            @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field">Description</td>
                                            <td>{{ $client->description }}</td>
                                        </tr>
                           
             
                                        <tr class="highlight">
                                            <td class="field">URL</td>
                                            <td>@if($client->url)<a target="_blank" href="{{ $client->url }}">Link</a> @else Not Available @endif</td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="field">Phone</td>
                                            <td>
                                                <i class="fa fa-mobile fa-lg m-r-5"></i> {{ $client->phone }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field">Country</td>
                                            <td>{{ $client->countryName }}</td>
                                        </tr>
                                        <tr>
                                            <td class="field">City</td>
                                            <td>@if($client->city) {{ $client->cityName }} @else Multiple Cities @endif</td>
                                        </tr>
                                        <tr>
                                            <td class="field">Address</td>
                                            <td>{{ $client->address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="field">On Map</td>
                                            <td><a title="Click to view on google maps" target="_blank" href="http://www.google.com/maps/place/{{ $client->coordinates }}" >{{ $client->coordinates }}</a></td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="field">Postal Code</td>
                                            <td>{{ $client->postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="field">Subsidiaries</td>
                                            <td>
                                            <?php $flag=0;?>
                                            @foreach($subsidiaries AS $subsidiary)
                                            <a href="{{action('ClientsController@profile',base64_encode($subsidiary->id))}}">{{ $subsidiary->name }}</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php $flag++;?>
                                            @endforeach
                                            @if(!$flag)  None  @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right">
                                        Added by {{ $client->addedBy }} on {{ date('d-M-Y',strtotime($client->created_at)) }} at {{ date('h:i:a',strtotime($client->created_at)) }} 
                                            </td>
                                        </tr>

                                         
                                   
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table -->
                        </div>
                        <!-- end profile-info -->
                    </div>
                    <!-- end profile-right -->
                </div>
                <!-- end profile-section -->
                 
                  </div><br>

            <!-- end profile-container --> 
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-4 -->
                        <div class="col-md">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#default-tab-1" data-toggle="tab"><i class="fa fa-user"></i> Contacts</a></li>
                        <li class=""><a href="#default-tab-2" data-toggle="tab"><i class="fa fa-phone"></i> Call History</a></li>
                        <li class=""><a href="#default-tab-3" data-toggle="tab"><i class="fa fa-history"></i> Edit History</a></li> 
                        <li class=""><a href="#default-tab-4" data-toggle="tab"><i class="fa fa-trash"></i> Deleted Contacts</a></li>
                    </ul>
                    <div class="tab-content">
                        
                        
                        <div class="tab-pane fade active in" id="default-tab-1">
                         <div class="panel-body">
                         <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th class="nosort">#</th>
                                    <th>Name</th>
                                    <th>Position</th> 
                                    <th>Mobile</th> 
                                    <th>Phone</th> 
                                    <th>Email</th>
                                    <th>Notes</th> 
                                    <th>Added</th> 
                                    <th> </th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts AS $index => $contact)
                                    <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>
                                    <div class="navbar-user">
                                    @if($contact->pic)<img src="/uploads/contactPics/{{ $contact->id }}.jpg" alt="" />@endif 
                                    @if(Auth::user()->hasRole('contactAdd'))
                                    <a href="{{action('ContactsController@edit',[base64_encode($client->id),base64_encode($contact->id)])}}">{{ $contact->name }}</a>
                                    @else
                                    {{ $contact->name }}
                                    @endif
                                    </div>
                                    </td>
                                    <td>{{ $contact->desig }}</td>
                                    <td>{{ $contact->mobile }}</td>
                                    <td>{{ $contact->phone }} @if($contact->phone2) , {{ $contact->phone2 }} @endif</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->notes }}</td>
                                    <td>{{ $contact->admin }}</td>
                                    <td>
                                    @if(Auth::user()->hasRole('contactAdd'))
                                    <div id="delDiv{{$contact->id}}">
                                    <button class="btn btn-xs" id="deleteContact{{ $contact->id }}" value="{{ $contact->id }}"> <i class="fa fa-trash text-danger"></i></button>
                                    </div>
                                    <script type="text/javascript">
                                                    $(document.body).on('click', '#deleteContact{{$contact->id}}', function(e){
                                                        e.preventDefault();
                                                        id = $(this).val(); 
                                                         $.post('/deleteClientContact',{id:id,_token:'{{ csrf_token() }}' }, function(actionBlade){ 
                                                            $("#delDiv{{$contact->id}}").html(actionBlade); 
                                                        });
                                                    });
                                    </script>                
                                    @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                            </div>
                            </div>
                      
      <!----------------------------------------------------Call History------------------------------------------------------------------------------- -->                
                      
                        <div class="tab-pane fade" id="default-tab-2">
                        <div class="panel-body">
                        


                       <table id="data-table2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th class="nosort">#</th>
                                    <th>Contacted Person</th>
                                    <th>Call Time</th>
                                    <th>Type</th>
                                    <th>Call Details</th>  
                                    <th>Staff</th>
                                    <th> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($calls AS $index => $call)
                                    <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td @if($call->importance==1) class="text-warning" @elseif($call->importance==2) class="text-success" @elseif($call->importance==3) class="text-danger" @endif>{{ $call->contactName.$call->contact_person }}</td>
                                    <td>{{ date('d-M-y H:i:a',strtotime($call->call_time)) }}</td>
                                    <td>@if($call->call_type==1) Outbound @else Inbound @endif</td>
                                    <td>{!! $call->call_details !!}</td>
                                    <td>{{ $call->admin }}</td>
                                    <td>@if( ( $call->added_by == Auth::id() && date('Y-m-d',strtotime($call->created_at))==date('Y-m-d') ) || Auth::user()->hasRole('Superman') )
                                            <a href="{{action('CallsController@edit',[base64_encode($client->id),base64_encode($call->id)])}}"><i class="fa fa-edit text-success"></i></a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                           
                                            <button id="callDel{{$index}}"><i  class="fa fa-trash text-danger"></i></button>
                                                 <script type="text/javascript">
                                                    $('#callDel{{$index}}').click(function(ev) {
                                                    
                                                      $.msgbox("<p>Are you sure you want to delete this?</p>", {
                                                        type    : "prompt",
                                                         inputs  : [
                                                          {type: "hidden", name: "_token", value: "{{ csrf_token() }}"}  
                                                        ],
                                                         
                                                        buttons : [
                                                          {type: "submit", name: "delete", value: "Delete"},
                                                          {type: "cancel", value: "Cancel"}
                                                        ],
                                                        form : {
                                                          active: true,
                                                          method: 'post',
                                                          action: '{{ action('CallsController@delete',[base64_encode($call->client),base64_encode($call->id)]) }}'
                                                        }
                                                      });
                                                      
                                                      ev.preventDefault();
                                                    
                                                    });
                                                 </script>
                                     @endif</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                    <span class="text-warning"><i class="fa fa-circle"></i> Important</span>&nbsp;&nbsp;&nbsp;&nbsp;  
                                    <span class="text-success"><i class="fa fa-circle"></i> Casual</span>&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <span class="text-danger"><i class="fa fa-circle"></i> Rejection</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                            
                        </div>
                        
              <!-----------------------------------------------------Edit History------------------------------------------------------------------------------ -->          
                        
                        <div class="tab-pane fade" id="default-tab-3">
                             
                           <div class="panel-body">  
                            <table id="data-table3" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th class="nosort">#</th>
                                    <th>Date</th> 
                                    <th>Changes</th>
                                    <th>Admin</th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($changes AS $index => $change)
                                    <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ date('d-M-Y',strtotime($change->dated)) }} at {{ date('h:i:a',strtotime($change->dated)) }} </td>
                                    <td>{!! $change->changes !!}</td>
                                    <td>{{ $change->addedBy }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                             </div>
                             
                        </div>
                        
    <!------------------------------------------------------------Deleted Contacts----------------------------------------------------------------------- -->                    
                         
                      <div class="tab-pane fade" id="default-tab-4">
                            <div class="panel-body">
                             <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                    <th class="nosort">#</th>
                                    <th>Name</th>
                                    <th>Position</th> 
                                    <th>Mobile</th> 
                                    <th>Phone</th> 
                                    <th>Email</th>
                                    <th>Notes</th> 
                                    <th>Deleted</th> 
                                    <th> </th> 
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deletedContacts AS $index => $contact)
                                    <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->desig }}</td>
                                    <td>{{ $contact->mobile }}</td>
                                    <td>{{ $contact->phone }} @if($contact->phone2) , {{ $contact->phone2 }} @endif</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->notes }}</td>
                                    <td>{{ $contact->admin }}</td>
                                    <td>
                                    @if(Auth::user()->hasRole('contactAdd'))
                                    <div id="resDiv{{$contact->id}}">
                                    <button class="btn btn-xs" id="restoreContact{{ $contact->id }}" value="{{ $contact->id }}"> <i class="fa fa-rotate-left text-info"></i></button>
                                    </div>
                                    <script type="text/javascript">
                                                    $(document.body).on('click', '#restoreContact{{$contact->id}}', function(e){
                                                        e.preventDefault();
                                                        id = $(this).val(); 
                                                         $.post('/restoreClientContact/',{id:id,_token:'{{ csrf_token() }}' }, function(actionBlade){ 
                                                            $("#resDiv{{$contact->id}}").html(actionBlade); 
                                                        });
                                                    });
                                    </script>                
                                    @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                        </div>
                        </div>
                      
                      
                    </div>
                     
                     
                </div>
                         
                    </div>
                    <!-- end row -->
                 
               
          
        </div>

        <script>
        $(document).ready(function() {
                                            
            $('#data-table2').dataTable( {
                "paging":   false,
                "ordering": true,
                "info":     false,
                "aaSorting": [],
                "columnDefs": [ {
                      "targets": 'nosort',
                      "bSortable": false,
                      "searchable": false
                    } ]
            } );
            

            $('#data-table3').dataTable( {
                "paging":   false,
                "ordering": true,
                "info":     false,
                "aaSorting": [],
                "columnDefs": [ {
                      "targets": 'nosort',
                      "bSortable": false,
                      "searchable": false
                    } ]
            } );

             $('#data-table4').dataTable( {
                "paging":   false,
                "ordering": true,
                "info":     false,
                "aaSorting": [],
                "columnDefs": [ {
                      "targets": 'nosort',
                      "bSortable": false,
                      "searchable": false
                    } ]
            } );

             } );

            </script>
        @endsection