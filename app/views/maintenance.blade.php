@extends("layout")

@section("content")	

<head>

	<title>Maintenance | Time and Attendance Monitoring System</title>

</head>

<div class='container'>			

<h1 style = "color:white; margin-top:80px">Maintenance</h1>



<div class = "col-md-12" style='margin-top:50px'>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('employs') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Personnel</center></a>

	</div>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('ranks') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Rank</center></a>

	</div>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('positions') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Position</center></a>

	</div>



	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('unit_offices') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Unit Office</center></a>

	</div>



	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('main_activities') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Main Activities</center></a>

	</div>



	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('sub_activities') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Sub Activities</center></a>

	</div>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('measures') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Measures</center></a>

	</div>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('measure_target_units') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Measure Target Units</center></a>

	</div>

	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('measure_targets') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Measure Targets</center></a>

	</div>



	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('perspectives') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Perspectives</center></a>

	</div>



	<div class = "col-md-3">

				<a style="color:white" href="{{ URL::to('objectives') }}"class="btn btn-link btn-lg"><span class='glyphicon glyphicon-user' style='font-size:80px'></span></br>

					<center>Objectives</center></a>

	</div>

</div>

</div>

@stop