@extends("layout-unitadmin-home")

@section("content")

<head>

	<title>Unit Administration Login | Scorecard</title>

</head>

	



	     <div class="container">

    	<div class="row">

			<div class="col-sm-12 col-md-8 col-md-offset-2">

				<div class="panel panel-default">

					<div class="panel-heading">

						<strong>PNP Unit Administrator Login</strong>

					</div>

					<div class="panel-body">

						{{ Form::open(array('url' => 'login/unitadmin', 'method' => 'post')) }}

							<fieldset>

								<div class="row">

									<div class="center-block">

										<img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/login_header.png" class="profile-img" alt="INSERT PICTURE HERE">

									</div>

								</div>

								<div class="row">

									<div class="col-sm-12 col-md-10  col-md-offset-1 ">

										<div class="form-group">

											<div class="input-group">

												@if (Session::has('message'))

													<div class="alert alert-danger">{{ Session::get('message') }}</div>

												@endif


												@if (Session::has('message2'))

													<div class="alert alert-success">{{ Session::get('message2') }}</div>

												@endif

											</div>

											<div class="input-group">

													<span class="input-group-addon">

													<i class="glyphicon glyphicon-user"></i>

												</span> 

												<strong>{{ Form::text('username', Input::get('username'), array('placeholder' => 'Username','autocomplete' => 'off', 'class' => 'form-control')) }}</strong>

											</div>

										</div>

										<div class="form-group">

											<div class="input-group">

												<span class="input-group-addon">

													<i class="glyphicon glyphicon-lock"></i>

												</span>

												<strong>{{ Form::password('password', array('placeholder' => 'Password', 'autocomplete' => 'off', 'class' => 'form-control')) }}</strong>

											</div>

										</div>

										<div class="form-group">

											{{ Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block')) }}

										</div>

									</div>

								</div>

							</fieldset>

						{{ Form::close() }}

					</div>

					<div class="panel-footer ">

						Please sign in with the correct login credentials.

					</div>

                </div>

			</div>

		</div>

	</div>
<script type="text/javascript">

    $(function(){

    $(".dropdown").hover(            

            function() {

                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");

                $(this).toggleClass('open');

                $('b', this).toggleClass("caret caret-up");                

            },

            function() {

                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");

                $(this).toggleClass('open');

                $('b', this).toggleClass("caret caret-up");                

            });

    });

    

</script>

               

@stop
	 

@stop
