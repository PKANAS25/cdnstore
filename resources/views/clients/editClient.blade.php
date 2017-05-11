@extends('formsMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => 'addClient']); ?>
@endsection


@section('content')
 
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Client</a></li>
                <li class="active"><a href="javascript:;">Edit</a></li>
                 
            </ol> 
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Edit <small>  Client</small></h1>
            <!-- end page-header -->
            <!-- begin row -->
             <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                
                                
                            </div>
                            <h4 class="panel-title">{{ $client->name }}</h4>
                        </div>
                        <div class="panel-body">

                            <i class="fa fa-arrow-left"></i> <a href="{!! action('ClientsController@profile', base64_encode($client->id)) !!}">Back to company profile </a>


                            <form name="eForm" id="eForm"  method="POST" autocomplete="OFF" class="form-horizontal form-bordered"  enctype="multipart/form-data"  data-fv-framework="bootstrap"  data-fv-message="Required Field"  data-fv-icon-invalid="glyphicon glyphicon-remove"  data-fv-icon-validating="glyphicon glyphicon-refresh">

                                @foreach ($errors->all() as $error)
                                    <p class="alert alert-danger">{{ $error }}</p>
                                @endforeach

                                

                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                                <fieldset>
                                    
                                     
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="name">Name:</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="name"   name="name" data-fv-notempty="true"   value="{{ $client->name }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Industry :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control"  name="industry" data-fv-notempty="true">
                                            <option value="{{ $client->industry }}">{{ $client->industryName }}</option> 
                                            @foreach($industries as $industry)
                                            <option value="{!! $industry->id !!}">{!! $industry->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
 
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Status :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" id="select-required" name="status" data-fv-notempty="true">
                                            
                                            <option value="{{ $client->status }}">{{ $client->currentStatus }}</option>
                                            @foreach($status as $stat)
                                            <option value="{!! $stat->id !!}">{!! $stat->status !!}</option>
                                            @endforeach
                                                
                                        </select>

                                    </div>
                                </div>
                                
                                 

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Parent Company :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control"  name="parent_company"  >
                                           @if($client->parentCompany)
                                            <option value="{{ $client->parent_company }}">{{ $client->parentCompany }}</option>
                                            <option value="0">None</option>
                                            @else
                                            <option value="0">None</option>
                                           @endif
                                             @foreach($clients as $cliente)
                                            <option value="{!! $cliente->id !!}">{!! $cliente->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                 
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="description">Description :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" id="description" name="description" rows="3" >{{ $client->description  }}</textarea>
                                    </div>
                                </div> 

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="phone">Phone :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="phone"  name="phone" data-fv-notempty="true"   value="{{ $client->phone  }}" />
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="url">URL :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="url"  name="url" value="{{ $client->url  }}" />
                                    </div>
                                </div>

                                <h4>Address</h4>
                                <hr> 
                               

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Country :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" id="country"  name="country" data-fv-notempty="true">
                                            <option value="{{ $client->country }}">{{ $client->countryName }}</option>
                                             @foreach($countries as $country)
                                            <option value="{!! $country->Code !!}">{!! $country->Name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">City :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <div id="cityLoader">
                                            <select class="form-control"  name="city" >
                                            @if($client->city)
                                            <option value="{{ $client->city }}">{{ $client->cityName }}</option>
                                            <option value="0">Multiple Cities</option>
                                            @else
                                            <option value="0">Multiple Cities</option>
                                           @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="postal_code">Postal Code :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="postal_code"  name="postal_code" value="{{ $client->postal_code }}" />
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="address">Address :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" id="address" name="address" rows="3" data-fv-notempty="true">{{ $client->address }}</textarea>
                                    </div>
                                </div> 

                                  <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="postal_code">Coordinates :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="coordinates"  name="coordinates" value="{{ $client->coordinates }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fileToUpload">Company Logo</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="file"  accept="image/*"    data-fv-file="true"  data-fv-file-extension="jpeg,jpg"  data-fv-file-type="image/jpeg,image/jpg"  data-fv-file-maxsize="629760" data-fv-file-message="The selected file is not valid" id="fileToUpload" name="fileToUpload" /> <span class="text-info">Max size 500 Kb, JPG only</span>
                                    </div>
                                    @if($profile_pic)
                                        <div class="profile-image">
                                        <img src="{{$profile_pic}}" />
                                        <i class="fa fa-user hide"></i>
                                        </div>
                                    @endif
                                </div> 
 
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4"></label>
                                    <div class="col-md-6 col-sm-6">
                                        <button type="reset" class="btn btn-sm btn-error">Reset</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>



                                </fieldset>
                            </form>
 
                        </div> 
                    <!-- end panel --> 
                </div>
            <!-- end row -->
        </div>
    </div>
    <script>
        $(document).ready(function() {
            App.init(); 

<!-- -------------------------------------------------==================--------------------------------------------- -->

  function cityLoader()
    {
       
      var country = $("#country").val(); 
       

       $.get('/cityLoader',{country:country }, function(branchBlade){ 
              
              $("#cityLoader").html(branchBlade); 
              
          });
    }   

<!-- -------------------------------------------------==================--------------------------------------------- -->

          

            $('#eForm').formValidation({
                message: 'This value is not valid',
                

                fields: {
                      
                
                    phone: {
                        validators: {
                            notEmpty: {},
                            digits: {},
                            
                        }
                    },
                 
            name: {
                     
                     verbose: false,
                     
                     validators: {
                     
                     notEmpty: {},
                     remote: {
                        url: '/clientEditCheck' ,
                        data: function(validator, $field, value) {
                            return {                                 
                                clientId: {{$client->id}} 
                            };
                        }

                    }
                }
            }
        }
    })
    .on('change', '[name="country"]', function(e) {
         cityLoader();
      })
    // This event will be triggered when the field passes given validator
    .on('success.validator.fv', function(e, data) {
        // data.field     --> The field name
        // data.element   --> The field element
        // data.result    --> The result returned by the validator
        // data.validator --> The validator name

         

        if (data.field === 'name'
            && data.validator === 'remote'
            && (data.result.available === false || data.result.available === 'false'))
        {

            // The userName field passes the remote validator
            data.element                    // Get the field element
                .closest('.form-group')     // Get the field parent

                // Add has-warning class
                .removeClass('has-success')
                .addClass('has-warning')

                // Show message
                .find('small[data-fv-validator="remote"][data-fv-for="name"]')
                    .show();
        }


        if (data.field === 'name'
            && data.validator === 'remote'
            && (data.result.available === true || data.result.available === 'true'))
        {
             
            // The userName field passes the remote validator
            data.element                    // Get the field element
                .closest('.form-group')     // Get the field parent

                // Add has-warning class
                .removeClass('has-warning')
                .addClass('has-success')

                // Show message
                .find('small[data-fv-validator="remote"][data-fv-for="name"]')
                    .show();
        }

    })
    // This event will be triggered when the field doesn't pass given validator
    .on('err.validator.fv', function(e, data) { 
         
        // We need to remove has-warning class
        // when the field doesn't pass any validator
         

        if (data.field === 'name') {
            data.element
                .closest('.form-group')
                .removeClass('has-warning')
                  

        }
    });

  });

                            
    </script>
        @endsection