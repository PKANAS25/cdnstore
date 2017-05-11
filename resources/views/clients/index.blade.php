@extends('hrMaster') 

@section('urlTitles')
<?php session(['title' => 'Clients']);
session(['subtitle' => 'clientsList']); ?>
@endsection

@section('content')
<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Clients</a></li>
				<li class="active"><a href="javascript:;">List</a></li>
				 
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Clients <small>List</small></h1>
			<!-- end page-header -->
			<!-- begin row -->
			 <div class="col-md-12">
                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="table-basic-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                               
                                
                            </div>
                            <h4 class="panel-title">All Clients</h4>
                        </div>
                        <div class="panel-body">
                             @if (session('status'))
                                    <div class="alert alert-success">
                                     {{ session('status') }} 
                                    </div>
                                @endif
                               
                             <div class="table-responsive">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="nosort">#</th>
                                        <th width="25%">Name</th>
                                        <th>Industry</th> 
                                        <th>Status</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                     @foreach($clients As $index => $client)
                                    <tr>
                                        <td>{!! $index+1 !!}</td>
                                        <td>  <a href="{!! action('ClientsController@profile', base64_encode($client->id)) !!}">{!! $client->name !!}  </td>
                                        <td>{!! $client->industryName !!}</td> 
                                        <td>{{ $client->currentStatus }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->phone }}  
                                        @if($client->addedContacts)<sup><strong> {{ $client->addedContacts }} </strong><i class="fa fa-user"></i></sup>&nbsp;&nbsp;&nbsp; @endif
                                        @if($client->addedCalls)<sup><strong> {{ $client->addedCalls }} </strong><i class="fa fa-phone"></i></sup>@endif
                                        </td>
                                    </tr>
                                     
                                @endforeach
                                     
                                </tbody>
                            </table>
                            <a class="btn btn-sm text-white bg-yellow-darker"  href="/excelClientsList"><i class="fa fa-file-excel-o"></i> Excel</a> 
                        </div>
                        </div>
                    </div> 
                    <!-- end panel --> 
                </div>
			<!-- end row -->
		</div>
        @endsection