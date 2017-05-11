@extends('hrMaster') 

@section('urlTitles')
<?php session(['title' => 'Home']);
session(['subtitle' => '']); ?>
@endsection
<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="/hr_assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" />
    <link href="/hr_assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
    <link href="/hr_assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="/hr_assets/plugins/morris/morris.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL CSS STYLE ================== -->

@section('content')
<div id="content" class="content">
            <!-- begin breadcrumb -->
            <ol class="breadcrumb pull-right">
                <li><a href="javascript:;">Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
            <!-- end breadcrumb -->
            <!-- begin page-header -->
            <h1 class="page-header">Dashboard <small>Clients and contacts</small></h1>
            <!-- end page-header -->
            
            <!-- begin row -->
            <div class="row">
                 @if (session('warning'))
                                    <div class="alert alert-danger">
                                        {{ session('warning') }}   
                                    </div>
                                @endif
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-green">
                        <div class="stats-icon"><i class="fa fa-bank"></i></div>
                        <div class="stats-info">
                            <h4>TOTAL CLIENTS</h4>
                            <p>{{ $totalClients }}</p>    
                        </div>
                        <div class="stats-link">
                            <a href="javascript:;"> &nbsp; <i class="fa fa-arrow-circle-o-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-blue">
                        <div class="stats-icon"><i class="fa fa-users"></i></div>
                        <div class="stats-info">
                            <h4>TOTAL CONTACTS</h4>
                            <p>{{ $totalContacts }}</p>   
                        </div>
                        <div class="stats-link">
                            <a href="javascript:;"> &nbsp;<i class="fa fa-arrow-circle-o-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-purple">
                        <div class="stats-icon"><i class="fa fa-thumb-tack"></i></div>
                        <div class="stats-info">
                            <h4>NEW CLIENTS</h4>
                            <p>{{ $newClients }}</p>    
                        </div>
                        <div class="stats-link">
                            <a href="javascript:;">Clients added in past 15 days <i class="fa fa-arrow-circle-o-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end col-3 -->
                <!-- begin col-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="widget widget-stats bg-red">
                        <div class="stats-icon"><i class="fa fa-phone"></i></div>
                        <div class="stats-info">
                            <h4>NEW CALLS</h4>
                            <p>{{ $newCalls }}</p> 
                        </div>
                        <div class="stats-link">
                            <a href="javascript:;">Calls made today <i class="fa fa-arrow-circle-o-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- end col-3 -->
            </div>
            <!-- end row -->

          <!-- begin row -->
            <div class="row">
                <div class="col-md-8">
                    <div class="widget-chart with-sidebar bg-black">
                        <div class="widget-chart-content">
                            <h4 class="chart-title">
                                Clients Call Analytics
                                <small>Inbound and Outbound calls made in past 6 months</small>
                            </h4>
                            <div id="line-all" class="morris-inverse" style="height: 260px;"></div>
                        </div>
                        <div class="widget-chart-sidebar bg-black-darker">
                            <div class="chart-number">
                                Clients Industry
                                <small> </small>
                            </div>
                            <div id="industry-donut-chart" style="height: 230px"></div>
                            
                            <ul class="chart-legend">
                                <li> <span id="morrisDonutChartSpan" class="text-white f-s-16 f-w-500"></span> <li>
                                 
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-inverse" data-sortable-id="index-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                Clients Origin
                            </h4>
                        </div>
                        <div id="clients-map" class="bg-black" style="height: 181px;"></div>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                <span class="badge badge-success">@if($totalClients) {{ round((($uaeClients/$totalClients)*100),2)}} @endif %</span>
                                1. United Arab Emirates 
                            </a> 
                            <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                <span class="badge badge-primary">@if($totalClients) {{ round((($saudiClients/$totalClients)*100),2) }} @endif%</span>
                                2. Saudi Arabia
                            </a>
                            <a href="#" class="list-group-item list-group-item-inverse text-ellipsis">
                                <span class="badge badge-inverse">@if($totalClients)  {{ round((($qatarClients/$totalClients)*100),2) }} @endif%</span>
                                3. Qatar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <!-- begin row -->
            
            <!-- end row --></div>
        </div>  

        <script>

        function prepareMorrisDonutChart() {
    $("#industry-donut-chart tspan:first").css("display","none");
    $("#industry-donut-chart tspan:nth-child(1)").css("font-size","40px");
    
    var isi = $("#industry-donut-chart tspan:first").html();
    $('#morrisDonutChartSpan').text(isi);
}

$( "#industry-donut-chart" ).mouseover(function() {
    prepareMorrisDonutChart();
});



        $(document).ready(function() { 

            Morris.Donut({
              element: 'industry-donut-chart',
              data: [
              @foreach ($industries as $industry)
                  {label: "{{ str_replace("&", "n", $industry->industryName) }}", value: {{ $industry->counter }} },
              @endforeach
               
                               
              ],
              backgroundColor:"#242a30",
              colors:["#1d73aa","#c44441","#8cbc4f","#7a5892","#009ab2","#f48533","#8baad1","#bfc802","#CD5C5C","#9d331e","#7a538a","#008080"], 
              labelColor:"fff",
              formatter: function (x) { return  Math.round(((x / {{ $totalClients }})*100).toString().match(/^\d+(?:\.\d{0,2})?/)) + '﹪' },

            });

            prepareMorrisDonutChart();

            
// --------------------------------------------------------------------------------
            Morris.Line({
              element: 'line-all',
              data: [
                { y: '{{ $months[0] }}', a: {{ $inboundCalls[0] }},  b: {{ $outboundCalls[0] }}  },
                { y: '{{ $months[1] }}', a: {{ $inboundCalls[1] }},  b: {{ $outboundCalls[1] }} },
                { y: '{{ $months[2] }}', a: {{ $inboundCalls[2] }},  b: {{ $outboundCalls[2] }}  },
                { y: '{{ $months[3] }}', a: {{ $inboundCalls[3] }},  b: {{ $outboundCalls[3] }}  },
                { y: '{{ $months[4] }}', a: {{ $inboundCalls[4] }},  b: {{ $outboundCalls[4] }}  },
                { y: '{{ $months[5] }}', a: {{ $inboundCalls[5] }},  b: {{ $outboundCalls[5] }} }  
                  ],
                  parseTime: false,  
                  xkey: 'y',
                  ykeys: ['a', 'b'],
                  labels: ['Inbound', 'Outbound'],  
                  lineColors:["#008080","#7a5892"],
                 // yLabelFormat: function(y){return y != Math.round(y)?'':y;},
            });

            // --------------------------------------------------------------------------------
             $(function(){
                  $('#clients-map').vectorMap(
                    {map: 'world_merc_en',
                    scaleColors:["#e74c3c","#0071a4"],
                    container:$("#visitors-map"),
                    normalizeFunction:"linear",
                    hoverOpacity:.5,
                    hoverColor:false,
                    markerStyle:{initial:{fill:"#4cabc7",stroke:"transparent",r:3}},
                    regions:[{attribute:"fill"}],
                    regionStyle:{initial:{fill:"rgb(97,109,125)","fill-opacity":1,stroke:"none","stroke-width":.4,"stroke-opacity":1},hover:{"fill-opacity":.8},selected:{fill:"yellow"},selectedHover:{}},
                    series:{regions:[{values:{SA:"#056DAD",QA:"#808000",AE:"#0facac",IN:"#00acac"}}]},focusOn:{x:.6,y:.6,scale:6},backgroundColor:"#2d353c" }
                    );
                });

           // --------------------------------------------------------------------------------  
           }); 


    </script>
    
    
        @endsection

       