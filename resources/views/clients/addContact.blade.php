@extends('formsMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => '']); ?>
@endsection


@section('content')
 
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Contact</a></li>
                <li class="active"><a href="javascript:;">Add</a></li>
                 
            </ol> 
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">{{ $client->name }} <small> New Contact</small></h1>
            <!-- end page-header -->
            <!-- begin row -->
             <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                
                                
                            </div>
                            <h4 class="panel-title">Add</h4>
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
                                        <input class="form-control" type="text" id="name"   name="name" data-fv-notempty="true"   value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Position :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control"  name="position" data-fv-notempty="true">
                                            <option value="">Please choose</option> 
                                            @foreach($designations as $designation)
                                            <option value="{!! $designation->id !!}">{!! $designation->position !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
 
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Mobile :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="mobile"  name="mobile" data-fv-notempty="true"  data-fv-digits="true" value="{{ old('mobile') }}" />

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Phone :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="phone"  name="phone"   data-fv-digits="true" value="{{ old('phone') }}" />

                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Phone 2 :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="phone2"  name="phone2"  data-fv-digits="true"  value="{{ old('phone2') }}" />

                                    </div>
                                </div>

                                 
                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="email">Email :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" id="email"   name="email"    data-fv-emailaddress="true"   data-fv-emailaddress-message="The value is not a valid email address"  value="{{ old('email') }}" />
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="Notes">Notes :</label>
                                    <div class="col-md-6 col-sm-6">
                                       <textarea class="form-control" id="notes" name="notes" rows="3"  >{{ old('notes') }}</textarea>
                                    </div>
                                </div> 
 

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="fileToUpload">Photo</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="file"  accept="image/*"    data-fv-file="true"  data-fv-file-extension="jpeg,jpg"  data-fv-file-type="image/jpeg,image/jpg"  data-fv-file-maxsize="629760" data-fv-file-message="The selected file is not valid" id="fileToUpload" name="fileToUpload" /> <span class="text-info">Max size 500 Kb, JPG only</span>
                                    </div>
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

          

            $('#eForm').formValidation({
                message: 'This value is not valid',
                

                fields: {
                      
                     
            name: {
                     
                     verbose: false,
                     
                     validators: {
                     
                     notEmpty: {},
                     remote: {
                        url: '/contactAddCheck' ,
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