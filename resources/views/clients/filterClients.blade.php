@extends('hrMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => 'filterClient']); ?>
@endsection

@section('content')
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Clients</a></li>
				<li class="active"><a href="javascript:;">Filter</a></li>
				 
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Filter <small> Clients</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
            <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading hidden-print">
                            
                            <h4 class="panel-title">Filter options</h4>
                        </div>
                        
                        <div class="panel-body">

                        <form class="form-inline hidden-print" name="eForm" id="eForm"  method="post" autocomplete="OFF">
                             <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                                <div class="form-group m-r-10">
                                  <select class="form-control" id="select-required" name="industry"  >
                                  @if($industryFilter) <option value="{{ $chosenIndustry->id }}">{{ $chosenIndustry->name }}</option>  @endif
                                            <option value="">All Industries</option>
                                            @foreach($industries as $industry)
                                            <option value="{!! $industry->id !!}">{!! $industry->name !!}</option>
                                            @endforeach
                                        </select>

                                       <select class="form-control" id="select-required" name="status"  > 
                                       @if($statusFilter) <option value="{{ $chosenStatus->id }}">{{ $chosenStatus->status }}</option>  @endif
                                            <option value="">All Status</option>
                                            @foreach($status as $stat)
                                            <option value="{!! $stat->id !!}">{!! $stat->status !!}</option>
                                            @endforeach 
                                        </select>

                                       


                                        <select class="form-control" id="country"  name="country"  onchange="cityLoader()" >
                                         @if($countryFilter) <option value="{{ $chosenCountry->Code }}">{{ $chosenCountry->Name }}</option>  @endif
                                            <option value="">All Countries</option>
                                             @foreach($countries as $country)
                                            <option value="{!! $country->Code !!}">{!! $country->Name !!}</option>
                                            @endforeach
                                        </select>

                                         <span id="cityLoader">
                                            <select class="form-control"  name="city" >
                                            @if($cityFilter) <option value="{{ $chosenCity->ID }}">{{ $chosenCity->Name }}</option>  @endif
                                                <option value="">All Cities</option>
                                            </select>
                                        </span>
                                </div>
                                
                                 
                                <button type="submit" class="btn btn-primary m-r-5">Filter</button> 
                            </form>  
                            </div>

                             </div>
            <!-- end row -->
        </div>


			 <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        
                        <div class="panel-body">
                             @if (session('status'))
                                    <div class="alert alert-success">
                                     {{ session('status') }} 
                                    </div>
                                @endif
                               
                             <div class="table-responsive">
                             @if($clients)
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="nosort">#</th>
                                        <th width="25%">Name</th>
                                        <th>Industry</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>BD Grade</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                     @foreach($clients As $index => $client)
                                    <tr>
                                        <td>{!! $index+1 !!}</td>
                                        <td>  <a href="{!! action('ClientsController@profile', base64_encode($client->id)) !!}">{!! $client->name !!}  </td>
                                        <td>{!! $client->industryName !!}</td>
                                        <td>{{  $client->countryName }} </td>
                                        <td>@if($client->city) {{ $client->cityName }} @else Multiple Cities @endif</td>
                                        <td>{{ $client->currentStatus }}</td>
                                        <td>{{ $client->bdGrade }}</td>
                                        <td>{{ $client->phone }} 
                                        @if($client->addedContacts)<sup><strong> {{ $client->addedContacts }} </strong><i class="fa fa-user"></i></sup>&nbsp;&nbsp;&nbsp; @endif
                                        @if($client->addedCalls)<sup><strong> {{ $client->addedCalls }} </strong><i class="fa fa-phone"></i></sup>@endif
                                        </td>
                                    </tr>
                                     
                                @endforeach
                                     
                                </tbody>
                            </table>
                            @endif
                        </div>
                        </div>
                    </div> 
                    <!-- end panel --> 
                </div>
			<!-- end row -->
		</div>
<script>
  function cityLoader()
    {
       
      var country = $("#country").val(); 
       

       $.get('/cityLoader',{country:country }, function(branchBlade){ 
              
              $("#cityLoader").html(branchBlade); 
              
          });
    }   

        // $(document).ready(function() {
        //     App.init(); 
        //  $('#eForm').formValidation({ 
        //     })
        //     .on('change', '[name="country"]', function(e) {
        //          cityLoader();
        //       })
        //      });

        //  $('#data-table').dataTable( {
        //         "paging":   false,
        //         "ordering": true,
        //         "info":     false,
        //         "aaSorting": [],
        //         "columnDefs": [ {
        //               "targets": 'nosort',
        //               "bSortable": false,
        //               "searchable": false
        //             } ]
        //     } );

                            
    </script>
        @endsection
