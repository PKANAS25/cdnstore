@extends('hrMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => 'filterContact']); ?>
@endsection

@section('content')
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Contacts</a></li>
				<li class="active"><a href="javascript:;">Search</a></li>
				 
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Search <small> Contacts</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
            <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading hidden-print">
                            
                            <h4 class="panel-title">Search</h4>
                        </div>
                        
                        <div class="panel-body">
                        <form name="eForm" id="eForm"  method="GET" autocomplete="OFF" class="form-inline hidden-print"  enctype="multipart/form-data"  data-fv-framework="bootstrap"
    data-fv-message="Required Field"
   
    data-fv-icon-invalid="glyphicon glyphicon-remove"
    data-fv-icon-validating="glyphicon glyphicon-refresh">

                                

                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                                <fieldset>
                                    
                                     

                                <div class="form-group m-r-10">
                                    
                                        <input class="form-control" size="50" type="text" id="keyword" name="keyword"  placeholder="Name /  Mobile / Phone"    />
                                      
                                </div>

                                

                                 

                                    <script type="text/javascript">

 
                                    $('#keyword').keyup(function(e){  
                             
                                        e.preventDefault();
                                        var value =($(this).val());

                                        var data = {thisConfirm : $(this).val()};
                                        clearTimeout($(this).data('timer'));

                                         $(this).data('timer', setTimeout(function() {
                                            $.get('/hrm/contactSearchBind',{keyword:value }, function(searchBlade){                      
                                            $("#searchResults").html(searchBlade);
                                            });
                                        },400));
                        
                                     }); 

                                  
                                   </script> 

                                </fieldset>
                            </form>

                      <strong>OR</strong>  

                        <form class="form-inline hidden-print" name="eForm" id="eForm"  method="post" autocomplete="OFF">
                             <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
                                <div class="form-group m-r-10">

                                 <select class="form-control" id="select-required" name="position"  > 
                                       @if($positionFilter) <option value="{{ $chosenPosition->id }}">{{ $chosenPosition->position }}</option>  @endif
                                            <option value="">All Positions</option>
                                            @foreach($positions as $position)
                                            <option value="{!! $position->id !!}">{!! $position->position !!}</option>
                                            @endforeach 
                                        </select>


                                  <select class="form-control" id="select-required" name="industry"  >
                                  @if($industryFilter) <option value="{{ $chosenIndustry->id }}">{{ $chosenIndustry->name }}</option>  @endif
                                            <option value="">All Industries</option>
                                            @foreach($industries as $industry)
                                            <option value="{!! $industry->id !!}">{!! $industry->name !!}</option>
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
                             <div id="searchResults">  
                             <div class="table-responsive">
                             @if($contacts)
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="nosort">#</th>
                                        <th>Name</th>
                                        <th>Company</th> 
                                        <th>Industry</th> 
                                        <th>Position</th> 
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Mobile</th> 
                                        <th>Phone</th> 
                                        <th>Email</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                     @foreach($contacts As $index => $contact)
                                    <tr>
                                        <td>{!! $index+1 !!}</td> 
                                        <td>{!! $contact->name !!}</td>
                                        <td><a href="{!! action('ClientsController@profile', base64_encode($contact->client)) !!}">{!! $contact->clientName !!}</a></td>
                                        <td>{{  $contact->industryName }} </td>
                                        <td>{{  $contact->positionName }} </td>
                                        <td>{{  $contact->countryName }} </td>
                                        <td>@if($contact->city) {{ $contact->cityName }} @else Multiple Cities @endif</td>
                                        <td>{{ $contact->mobile }}</td>
                                         <td>{{ $contact->phone }} @if($contact->phone2) , {{ $contact->phone2 }} @endif</td>
                                        <td>{{ $contact->email }}</td>
                                         
                                    </tr>
                                     
                                @endforeach
                                     
                                </tbody>
                            </table>
                            <a class="btn btn-sm text-white bg-yellow-darker"  href="/excelContactsFilter/{{ $positionFilter }}/{{ $industryFilter }}/{{ $countryFilter }}/{{ $cityFilter }}"><i class="fa fa-file-excel-o"></i> Excel</a>
                            @endif
                        </div>
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
