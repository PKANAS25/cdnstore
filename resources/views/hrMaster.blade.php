<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
 
<head>
<meta name="theme-color" content="#2d353c">
	  <!-- Windows Phone -->
	  <meta name="msapplication-navbutton-color" content="#2d353c">
	  <!-- iOS Safari -->
	  <meta name="apple-mobile-web-app-capable" content="yes">
	  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	
	<meta charset="UTF-8" />
	<title>CDN Store</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="SHORTCUT ICON"   href="/images/favicon-32x32.png">
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link href="/hr_assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="/hr_assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/hr_assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="/hr_assets/css/animate.min.css" rel="stylesheet" />
	<link href="/hr_assets/css/style.min.css" rel="stylesheet" />
	<link href="/hr_assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="/hr_assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
     <link href="/hr_assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
	<link href="/hr_assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />

	 
    <link href="/hr_assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/hr_assets/plugins/pace/pace.min.js"></script>

	<script src="/hr_assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	 

	<style type="text/css">
	.onlyprint {display: none;}
	.onlyprintCenter {display: none;}

	@media print { 
	  .onlyprint {display:table-cell;}
	  .onlyprintCenter {display:block;  }
	  .dataTables_filter label{display: none;}
	  
	  a[href]:after 
	   {
    	content: none !important;
  		}

	}
	</style>
<SCRIPT LANGUAGE="Javascript">
		<!---
		function decision(message, url){
		if(confirm(message)) location.href = url;
		}
		// --->
	</SCRIPT>	 
</head>
<body> 
	<!-- begin #page-loader -->
	 
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		 @include('shared.header')
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		 
		@include('shared.navbar')
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		 @yield('content')
		<!-- end #content -->
		
         
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	 </div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	
	<script src="/hr_assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="/hr_assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="/hr_assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="/hr_assets/crossbrowserjs/html5shiv.js"></script>
		<script src="/hr_assets/crossbrowserjs/respond.min.js"></script>
		<script src="/hr_assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="/hr_assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="/hr_assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="/hr_assets/plugins/morris/raphael.min.js"></script>
    <script src="/hr_assets/plugins/morris/morris.js"></script>
    <script src="/hr_assets/plugins/jquery-jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/hr_assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
    <script src="/hr_assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
	<script src="/hr_assets/plugins/gritter/js/jquery.gritter.js"></script> 
	<script src="/hr_assets/js/apps.min.js"></script>

	 

	<script src="/hr_assets/plugins/DataTables/js/jquery.dataTables.js"></script>
	<script src="/hr_assets/js/table-manage-default.demo.min.js"></script>

	<!-- <script src="/hr_assets/js/form-plugins.demo.min.js"></script> -->
	<script src="/hr_assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	 
	<!-- ================== END PAGE LEVEL JS ================== -->
	<script>
		$(document).ready(function() {
			App.init(); 
            //                               
			$('#data-table').dataTable( {
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
 
		
			//fn.datepicker.defaults.format = "yyyy-mm-dd";
			 //FormPlugins.init();	

		    

		});


	</script>
	 
	 
</body>
 </html>
