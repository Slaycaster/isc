@extends("layout-employee")

@section("content")





<head>

    <title>Change Password | PNP Scorecard System</title>

</head>



<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

  <h1><strong>CHANGE PROFILE PHOTO</strong></h1><hr>

</div>



<div class="container">

  <div class="row">

    <!--CREATE Perspective-->

    <div class = "col-md-4">

                        @if (Session::has('changepw_success'))

                        <div class="alert alert-success">{{ Session::get('changepw_success') }}</div>

                        @endif

      <div class="panel panel-default">

          <div class="panel-heading">


            <strong>Click the button to add your photo.</strong>

          </div>

          <div class="panel-body">

            {{ Form::open(array('url'=>'change_photo', 'class'=>'block small center login', 'files' => true)) }}

              <fieldset>

                <div class="row">

                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                      <div class="form-group">
                          <div>{{ Form::label('EmpPicturePath', 'Select Profile Picture:') }}</div>
                          <div>{{ Form::file('EmpPicturePath') }}</div>
                          
                        </div>


                    <div class="form-group">

                      {{ Form::submit('Change Photo', array('class' => 'btn btn-lg btn-success btn-block')) }}

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