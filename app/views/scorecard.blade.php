@extends("layout-employee")

@section("content")



<head>

    <title>Scorecard (Step 1) | PNP Scorecard System</title>

</head>





<div class="label_white">

  <div class="row">

    <div class="col-md-12">

      <h1><strong><center>SCORECARD ACTIVITIES</center></strong></h1>

      <br>

    </div>

  </div>

</div>

<div class="container">

  <div class="row">

   <div class="alert alert-warning"><li style= 'color:black; font-weight:bolder'>After adding all your activities. Next is go to &nbsp;  <a style = 'font-size:16px ' href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li></div><br>

   <div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-heading">

            <strong>Create a Scorecard</strong>

        </div>

        <div class="panel-body">

        

        @if (Session::has('message'))
          <div class="alert alert-success">{{ Session::get('message') }}</div><br>
        @endif



          {{ Form::open(array('url' => 'employee/postscorecard', 'method' => 'post')) }}

                 <label>Main Activity</label>

          {{ Form::text('main_activity', Input::get('main_activity'), array('placeholder' => 'Main Activity','autocomplete' => 'off', 'class' => 'form-control')) }}



      <div class="multi-field-wrapper">

          <div class="row">

            <div class="col-md-12">

              <br>

              <button type="button" class="add-field"><span class="glyphicon glyphicon-plus"></span>Add Sub Activity</button>

            </div>

          </div>

          <div class="row">

              <br>

              

              <div class="multi-fields">

                  <div class="multi-field">

                     <div class="col-md-12">

                      

                        <label>Sub Activity</label> 

                        <input type="text" name="sub_activities[]" class="form-control" autocomplete="off">

                        <br>

                     </div>

                     

                  </div>

               </div>

           </div> 

      </div>

              <br>

              {{ Form::submit('(Step 1 of 2) Next', array('class' => 'btn btn-lg btn-success')) }}

              {{Form::close()}}

        </div>

        <br>

        

    </div>

  </div>

  <div class="row">

    <div class="col-md-12">

      <div class="panel panel-primary">

        

        <div class="panel-heading">

          <strong>Your Current Activity List</strong>

        </div>



        <div class="panel-body">

          <table class="table" >

            <thead>

              <tr>

                <th>Main Activity</th>

                <th>Sub-activities</th>

                <th>Measures</th>



              </tr>

            </thead>



            <?php

              $tempMainActivity = '';

              $tempSubActivity = '';

              $tempMeasure = '';

            ?>

            <tbody>

              @foreach($emp_activities as $emp_activity)

              <tr>

                @if($emp_activity->MainActivityName != $tempMainActivity)

                  <td>

                    {{$emp_activity->MainActivityName}}

                    </td>

                    <?php

                      $tempMainActivity = $emp_activity->MainActivityName

                    ?>

                @else

                  <td></td>

                @endif

                

                @if($emp_activity->SubActivityName != $tempSubActivity)

                  <td>

                    {{$emp_activity->SubActivityName}}

                  </td>

                  <?php

                    $tempSubActivity = $emp_activity->SubActivityName

                  ?>

                @else

                  <td></td>

                @endif



                <td>

                  {{$emp_activity->MeasureName}}

                </td>

              </tr>

              @endforeach

            </tbody>

           

          </table>

        </div>



      </div>

    </div>

  </div>

  

 </div>

</div>

<br>

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

$('.multi-field-wrapper').each(function() {

    var $wrapper = $('.multi-fields', this);

    $(".add-field", $(this)).click(function(e) {

        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val(id).focus();

        

       // document.write('<input type="hidden" name="sub_id[]" value="'+id+'"/>');

    });

    var $wrapper2 = $('.multi-field2',this);

    $(".add-field2", $(this)).click(function(e) {

        $('.multi-field3:first-child', $wrapper2).clone(true).appendTo($wrapper2).find('input').val('').focus();

    });

    $('.multi-field .remove-field', $wrapper).click(function() {

        if ($('.multi-field', $wrapper).length > 1)

            $(this).parent('.multi-field').remove();

    });

});

</script>





<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>



@stop