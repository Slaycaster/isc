@extends("layout-employee")
@section("content")

<head>
    <title>Accomplishment Report | PNP Scorecard System</title>
</head>

<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">
  <left><h1><strong>SCORECARD REPORT</strong></h1></left><hr>
</div>
<div class = "col-md-4 ">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Reports Panel</strong>
          </div>
          <div class="panel-body">
          {{ Form::open(array('target' => '_blank','url' => 'employee/reports-pdf', 'method' => 'get')) }}
                <h4>Your Scorecard Report</h4><hr>
              <div class="form-group">
                        {{ Form::label('StartDate', 'Select a Start Date:') }}
                        {{ Form::text('StartDate',Input::get('StartDate'), array('autocomplete' => 'off', 'size' => '35','id' => 'dp','placeholder' => 'Date', 'class' => 'form-control')) }}
                      </div>
                
                  <fieldset>

                      <div class="form-group">
                        {{ Form::submit('Generate Weekly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'weekly')) }}
                      </div>
                      <div class="form-group">
                        {{ Form::submit('Generate Monthly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'monthly')) }}
                      </div>
                  </fieldset>
                {{ Form::close() }}
          </div>
       </div>
</div>
    <?php
      $fl = Session::get('report_filename', 'default');
    ?> 
<div class = "col-md-9"></div>
<div class = "col-md-2"></div>


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



<script type="text/javascript">
    $(function() {
        $("#dp").datepicker(
        {   
            beforeShowDay: function(day) {

            var day = day.getDay();
            if (day == 0 || day == 2 || day == 3 || day == 4 || day == 5 || day == 6) {
                return [false]
            } else {
                return [true]
            }
        }
        });
    });

</script>
<script type="text/javascript">
    $("#dp").val($.datepicker.formatDate('dd/mm/yy'));
</script>

@stop
