@extends('formsMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => '']); ?>
@endsection


@section('content')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/datetimepicker/0.1.26/DateTimePicker.min.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/datetimepicker/0.1.26/DateTimePicker.min.js"></script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
 

<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Call</a></li>
                <li class="active"><a href="javascript:;">Edit</a></li>
                 
            </ol> 
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">{{ $client->name }} <small> Edit Call</small></h1>
            <!-- end page-header -->
            <!-- begin row -->
             <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                
                                
                            </div>
                            <h4 class="panel-title">Edit call</h4>
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
                                    <label class="control-label col-md-4 col-sm-4">Contact Person :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" id="contact_person_id" name="contact_person_id"  >
                                            @if($call->contact_person_id==0)
                                            <option value="">Please choose</option> 
                                            @else
                                            <option value="{{ $call->contact_person_id }}">{{ $call->contactName }}</option> 
                                            @endif
                                            @foreach($contacts as $contact)
                                            <option value="{!! $contact->id !!}">{!! $contact->name !!}</option>
                                            @endforeach
                                        </select> 
                                        or 
                                      <input class="form-control" type="text" id="contact_person" name="contact_person" value="{{ $call->contact_person }}" />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="name">Call Time :</label>
                                    <div class="col-md-6 col-sm-6">
                                     <input class="form-control" type="text" data-field="datetime" id="call_time" name="call_time" data-fv-notempty="true"   value="{{ date('Y-m-d H:i',strtotime($call->call_time)) }}"   data-format="yyyy-mm-dd hh:mm" />
                                     <div id="dtBox"></div>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Call Type :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control"  name="call_type" data-fv-notempty="true">
                                            @if($call->call_type==1)
                                            <option value="1">Outbound</option> 
                                            <option value="2">Inbound</option>  
                                            
                                            @else 
                                            <option value="2">Inbound</option> 
                                            <option value="1">Outbound</option>  
                                            @endif
                                           
                                        </select> 

                                    </div>
                                </div>  

                                
 
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Call Importance :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control"  name="importance" data-fv-notempty="true">
                                            @if($call->importance==1)
                                            <option value="1">Important</option> 
                                            <option value="2">Casual</option> 
                                            <option value="3">Rejection</option> 
                                            
                                            @elseif($call->importance==2) 
                                            <option value="2">Casual</option> 
                                            <option value="1">Important</option> 
                                            <option value="3">Rejection</option> 
                                           
                                            @elseif($call->importance==3)
                                            <option value="3">Rejection</option> 
                                            <option value="1">Important</option> 
                                            <option value="2">Casual</option>
                                            @endif
                                           
                                        </select> 

                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4" for="Notes">Call Details :</label>
                                    <div class="col-md-6 col-sm-6">
                                       <textarea class="form-control" id="call_details" name="call_details" rows="3" data-fv-notempty="true"  >{{ $call->call_details }}</textarea>
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

            $("#dtBox").DateTimePicker();

            tinymce.init({
  selector: 'textarea',
  plugins: "textcolor",
  menubar: false,
  elementpath: false,
  toolbar: [
    'undo redo | styleselect | bold italic | forecolor backcolor',
    'alignleft aligncenter alignright'
  ], 
        setup: function(editor) {
            editor.on('keyup', function(e) {
                // Revalidate the hobbies field
                $('#eForm').formValidation('revalidateField', 'call_details');
            });
        }
  });
 

<!-- -------------------------------------------------==================--------------------------------------------- -->

          

            $('#eForm').formValidation({
                 framework: 'bootstrap',
            excluded: [':disabled'],

                message: 'This value is not valid',
                

        fields: {
              
                 contact_person_id: 
                 {
                    validators:
                     {
                         callback: {
                          
                            message: 'You must choose a contact or enter contact person',
                            callback: function(value, validator, $field) {
                                    var contact_person = $('#eForm').find('[name="contact_person"]').val();
                                   if(contact_person=="" && value=="")
                                    return false;
                                else return true;
                                }
                            }
                     }
                 },
                  call_details: {
                    validators: {
                        callback: {
                            message: 'The call details must be atleast 20 characters long',
                            callback: function(value, validator, $field) {
                                // Get the plain text without HTML
                                var text = tinyMCE.activeEditor.getContent({
                                    format: 'text'
                                });

                                if(text.length < 20)
                                    return false;
                                else return true;
                            }
                        }
                    }
                }
     
                }
    })
            .on('keyup', '[name="contact_person"]', function(e) {
       $('#eForm').formValidation('revalidateField', 'contact_person_id');
    })
    .on('change', '[name="call_time"]', function(e) {
       $('#eForm').formValidation('revalidateField', 'call_time');
    })        

  });

                            
    </script>
        @endsection