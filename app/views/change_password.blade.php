@extends("layout-employee")

@section("content")





<head>

    <title>Change Password | PNP Scorecard System</title>

</head>



<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

  <h1><strong>CHANGE PASSWORD</strong></h1><hr>

</div>



<div class="container">

  <div class="row">

    <!--CREATE Perspective-->

    <div class = "col-md-4">

      <div class="panel panel-default">

          <div class="panel-heading">

            <strong>Confirm changing your password by filling up below. <br><li style="color:red">Special characters like /,!,@,# are not allowed </li> </strong>

          </div>

          <div class="panel-body">

            {{ Form::open(array('url'=>'change_password', 'class'=>'block small center login')) }}

              <fieldset>

                <div class="row">

                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">



                    <div class="form-group">

                      <div class="input-group">

                       @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                        @if (Session::has('changepw_error'))

                        <div class="alert alert-danger">{{ Session::get('changepw_error') }}</div>

                        @endif

                        @if (Session::has('changepw_success'))

                        <div class="alert alert-success">{{ Session::get('changepw_success') }}</div>

                        @endif



                      </div>

                    </div>

                    

                    <div class="form-group">

                        <div>{{ Form::label('old_password', 'Old Password:')}}</div>

                        <div style='color:black'> {{ Form::password('old_password', array('placeholder' => 'Old Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>

                    </div>



                    <div class="form-group">

                        <div>{{ Form::label('new_password', 'New Password:')}}</div>

                        <div style='color:black'> {{ Form::password('new_password', array('placeholder' => 'New Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>

                    </div>



                    <div class="form-group">

                        <div>{{ Form::label('password_again', 'Confirm New Password:')}}</div>

                        <div style='color:black'> {{ Form::password('password_again', array('placeholder' => 'Confirm New Password','autocomplete' => 'off', 'class' => 'form-control')) }}</div>

                    </div>

                    @foreach($myrecord as $employee)
                      {{ Form::hidden('email', $employee->email)}}
                    @endforeach

                    <div class="form-group">

                      {{ Form::submit('Change Password', array('class' => 'btn btn-lg btn-success btn-block')) }}

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