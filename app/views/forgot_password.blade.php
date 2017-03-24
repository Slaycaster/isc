@extends("layout-noheader3")

@section("content")





<head>

    <title>Forgot Password | PNP Scorecard System</title>

</head>



<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

  <h2><strong>FORGOT PASSWORD?</strong></h2><hr>

</div>



<div class="container">

  <div class="row">

    <!--CREATE Perspective-->

    <div class = "col-md-4">

      <div class="panel panel-default">

          <div class="panel-heading">

            <strong>Fill the fields below then click submit.</strong>

          </div>

          <div class="panel-body">

                {{ Form::open(array('url' => 'forgot_password', 'method' => 'post')) }}

              <fieldset>

                <div class="row">

                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">



                    <div class="form-group">

                      <div class="input-group">


                        @if (Session::has('forgot_success'))

                        <div class="alert alert-success">{{ Session::get('forgot_success') }}</div>

                        @endif

                        @if (Session::has('forgot_error'))

                        <div class="alert alert-danger">{{ Session::get('forgot_error') }}</div>

                        @endif


                     

                      </div>

                    </div>

                    

                    <div class="form-group">

                          <div>{{ Form::label('BadgeNo', 'Badge Number:') }}</div>
                           <div style='color:black'> {{ Form::text('BadgeNo', Input::get('BadgeNo'), array('placeholder' => 'PRS-0001','autocomplete' => 'off', 'class' => 'form-control')) }}</div><br>
                           <div>{{ Form::label('email', 'Email:') }}</div>
                        <div style='color:black'> {{ Form::text('email', Input::get('email'), array('placeholder' => 'pnp@gmail.com','autocomplete' => 'off', 'class' => 'form-control')) }}</div>

                    </div>



                    <div class="form-group">

                      {{ Form::submit('Send to E-mail', array('class' => 'btn btn-lg btn-success btn-block')) }}

                    </div>

                  </div>

                </div>

              </fieldset>

            {{ Form::close() }}

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