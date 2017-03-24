@extends("layout-employee")

@section("content")

 

<head>

    <title>Scorecard (Approved Target) | PNP Scorecard System</title>

</head>

 {{ Form::open(array('url' => 'employee/accomplishment-final', 'method' => 'post', 'id' => 'formid')) }}

<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

  <center><h1><strong>APPROVED TARGET SCORECARD</strong></h1></center>
  <center><h4><strong>( INPUT DAILY ACCOMPLISHMENTS )</strong></h4></center><hr>


</div>



  {{Form::hidden('targetstatus', $targetstatus) }}





<div class="col-md-3">

</div>

<div class="col-md-6" style="margin-left:1%; background-color:white;  width:1118px; ">

    @if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div><br>

    @endif



@foreach($employee as $employees)



<div class="col-md-12" style="margin-top:5%; margin-bottom:10px">

  <div class="col-md-4"> 

    <img style = "height:150px; width:150px;" src="{{URL::asset($employees->EmpPicturePath)}}">

  </div>

  <div class="col-md-8">

    

    <p><strong>

    Rank and Name:

    @foreach($rank as $ranks)

    @if($ranks->id == $employees->RankID)

    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{$ranks->RankCode}}   {{$employees->EmpFirstName}} {{$employees->EmpMidInit}} {{$employees->EmpLastName}} {{$employees->EmpQualifier}}

    @endif

    @endforeach

      </strong>

    </p>



    <p><strong>

    Position:

    @foreach($position as $positions)

    @if($positions->id == $employees->PositionID)

      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;{{$positions->PositionName}}

    @endif

    @endforeach

      </strong>

    </p>



@endforeach

    <p> <strong>

    Period Covered:

    &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;{{ $DateCovered }}

      </strong>

    </p>

    
      <a href = '#' class = 'btn btn-danger btn-info' name="Reset" data-toggle="modal" data-target="#resetModal" value="Reset">Reset (Click if you have changes in your Scorecard)</a>

       <!-- Modal -->
    <div id="resetModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Are you sure?</h4>
          </div>
        <div class="modal-body">
          <p>Resetting your scorecard will <bold>cancel its request whether its currently pending, approved or rejected</bold>. Doing so will re-enter your target values. Continue?</p>
        </div>
        <div class="modal-footer">
          
          <!--<input class = 'btn btn-success' type="submit" value="Ok">-->

        <input class = 'btn btn-danger' type="submit" name="Reset" value="Reset">

        <button type="button" class="btn btn-default" data-dismiss="modal"><i>Cancel</i></button>
          </div>
        </div>

        </div>
      </div>

  </div>

</div>

<?php $a = 0; ?> 



  <?php

              $tempMainActivity = '';

              $tempSubActivity = '';

              $tempMeasure = '';

              $tempObjectiveName = '';

            ?>







  <table class = "table table-bordered" style = "color:black;  width:100%;" >

    <?php

      $counter = 0;

                            

    ?>



   @foreach($emp_activities as $emp_activity)



        {{Form::hidden('targetID[]', $emp_activity->targetID) }}

    

        @if($emp_activity->MainActivityName != $tempMainActivity)

         <?php $a++ ?> 

        <tr>

        <td style = "font-size:10px" colspan=55><b>Main Activity {{$a}}</b>: {{$emp_activity->MainActivityName}}</td>

              </tr> 

        <tr>

        <td style = "font-size:10px" rowspan=2 colspan=7 width=10%>Objectives</td>

        <td style = "font-size:10px" rowspan=2 colspan=7 width=10%>Enabling Actions<br><center>(Sub-activity)</center></td>

        <td style = "font-size:10px; text-align:center" rowspan=2 colspan=7 width=10%>Measure</td>

        <td style = "font-size:10px; text-align:center" rowspan=2 width=5%>Target</td>

        <td style = "font-size:10px; text-align:center" colspan=14>Accomplishments</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Total</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Cost</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Remarks</td>

         </tr>

        

        <td style = "font-size:10px" colspan=2 width=6.5%>Mon</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Tue</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Wed</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Thu</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Fri</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Sat</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Sun</td>

          <?php

                         $tempMainActivity = $emp_activity->MainActivityName

                    ?>

       @endif

  

          

              <tr>

                            @if($emp_activity->ObjectiveName != $tempObjectiveName)

                                <td style = "font-size:10px" colspan=7>  {{$emp_activity->ObjectiveName}}</td>

                                <?php

                                $tempObjectiveName = $emp_activity->ObjectiveName

                              ?>



                            @else

                                <td colspan=7></td>

                            @endif



                            @if($emp_activity->SubActivityName != $tempSubActivity)

                             

                               <td style = "font-size:10px" colspan=7>  {{$emp_activity->SubActivityName}}</td>

                            

                              <?php

                                $tempSubActivity = $emp_activity->SubActivityName

                              ?>

                            {{Form::hidden('mainactivities[]', $emp_activity->MainActivityID )}}

                            {{Form::hidden('subactivities[]', $emp_activity->SubActivityID )}}

                            @else

                              <td colspan=7></td>

                            @endif



                               <td style = "font-size:10px">{{$emp_activity->MeasureName}}</td>



                          

                             {{Form::hidden('measures[]', $emp_activity->MeasureID )}}



                              

                                

                                 <td style = "font-size:10px; text-align:center;" colspan=7>{{ Form::text('targets[]',$emp_activity->targetvalue, array('placeholder' => '0','autocomplete' => 'off', 'size' => '2', 'readonly')) }}</td>

                               



                               <div class = 'row'>



                               <td style = "font-size:10px" colspan=2>{{ Form::text('day1[]', Input::get('day1[]'), array('id' => '', 'class' =>'Calc'.$counter, 'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day2[]', Input::get('day2[]'),  array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day3[]', Input::get('day3[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day4[]', Input::get('day4[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day5[]', Input::get('day5[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day6[]', Input::get('day6[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('day7[]', Input::get('day7[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                

                                 <td style = "font-size:10px" colspan=2><span id="Total{{$counter}}" class="panel"></span></td>

                               

                                 <td style = "font-size:10px"  colspan=2>{{ Form::text('cost[]', Input::get('cost[]'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                 <td style = "font-size:10px" colspan=2>{{ Form::text('remarks[]', Input::get('remarks[]'), array('placeholder' => '','autocomplete' => 'off', 'size' => '2')) }}</td>

                                 </div>

                                 <?php

                                    $counter = $counter + 1;

                                  ?>

                            

              </tr>

       



   @endforeach

          

  </table>


  <?php $a = 0; ?> 



  <?php

             
              $tempOtherActivity = '';

              $tempOtherMeasure = '';

            ?>






@if($other_activities != null)
  <table class = "table table-bordered" style = "color:black;  width:100%;" >

    <?php

      $counter1 = 0;

                            

    ?>



        <tr>

        <td style = "font-size:10px" colspan=55><b>Other Activities (Other duties as directed)</b></td>

              </tr> 

        <tr>
        <td style = "font-size:10px" rowspan=2 colspan=7 width=10%>Objectives</td>

        <td style = "font-size:10px" rowspan=2 colspan=7 width=10%>Enabling Actions<br><center>(Sub-activity)</center></td>

        <td style = "font-size:10px; text-align:center" rowspan=2 colspan=7 width=10%>Measure</td>

        <td style = "font-size:10px; text-align:center" rowspan=2 width=5%>Target</td>

        <td style = "font-size:10px; text-align:center" colspan=14>Accomplishments</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Total</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Cost</td>

        <td style = "font-size:10px" colspan=2 rowspan=2 width=6.5%>Remarks</td>

         </tr>

        

        <td style = "font-size:10px" colspan=2 width=6.5%>Mon</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Tue</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Wed</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Thu</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Fri</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Sat</td>

        <td style = "font-size:10px" colspan=2 width=6.5%>Sun</td>

      
  

   @foreach($other_activities as $other_activity)

    



          

              <tr>

                          
                                <td colspan=7></td>

                          


                            @if($other_activity->OtherActivitiesName != $tempOtherActivity)

                             

                               <td style = "font-size:10px" colspan=7>  {{$other_activity->OtherActivitiesName}}</td>

                            

                              <?php

                                $tempOtherActivity = $other_activity->OtherActivitiesName

                              ?>

                            {{Form::hidden('otheractivities[]', $other_activity->OtherActivitiesID )}}

                            @else

                              <td colspan=7></td>

                            @endif



                               <td style = "font-size:10px">{{$other_activity->OtherActivitiesMeasureName}}</td>



                          

                             {{Form::hidden('othermeasures[]', $other_activity->OtherMeasureID )}}

                       







                               <td style = "font-size:10px; text-align:center;" colspan=7>{{ Form::text('othertargets[]', Input::get('othertarget[]'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '2' )) }}</td>



                               <div class = 'row'>



                               <td style = "font-size:10px" colspan=2>{{ Form::text('otherday1[]', Input::get('otherday1[]'), array('id' => '', 'class' =>'Calca'.$counter1, 'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday2[]', Input::get('otherday2[]'),  array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday3[]', Input::get('otherday3[]'), array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday4[]', Input::get('otherday4[]'), array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday5[]', Input::get('otherday5[]'), array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday6[]', Input::get('otherday6[]'), array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                <td style = "font-size:10px" colspan=2>{{ Form::text('otherday7[]', Input::get('otherday7[]'), array('id' => '', 'class' =>'Calca'.$counter1,'placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                

                                 <td style = "font-size:10px" colspan=2><span id="Totala{{$counter1}}" class="panel"></span></td>

                               

                                 <td style = "font-size:10px"  colspan=2>{{ Form::text('othercost[]', Input::get('othercost[]'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                 <td style = "font-size:10px" colspan=2>{{ Form::text('otherremarks[]', Input::get('otherremarks[]'), array('placeholder' => '','autocomplete' => 'off', 'size' => '2')) }}</td>

                                 </div>

                                 <?php

                                    $counter1 = $counter1 + 1;

                                  ?>

                            

              </tr>

       



   @endforeach

          

  </table>
@endif


    <div class='col-md-12'>

      <div class='col-md-10'></div>

      <div class='col-md-2' style='margin-bottom:10%'>

      <button type="button" class="btn btn-lg btn-success" style='text-align:left; font-size:15px; margin-bottom:70px;' data-toggle="modal" data-target="#confirmModal">Save</button>

       <!-- Modal -->
    <div id="confirmModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Are you sure?</h4>
          </div>
        <div class="modal-body">
          <p>Your scorecard will become<i> final</i> and you cannot make changes<i> anymore</i><br>Are you sure you really want to submit your scorecard?</p>
        </div>
        <div class="modal-footer">
          
          <!--<input class = 'btn btn-success' type="submit" value="Ok">-->

       <input class = 'btn btn-lg btn-success' type="submit" name="Submit" value="OK">

        <button type="button" class="btn btn-default" data-dismiss="modal"><i>Cancel</i></button>
          </div>
        </div>

        </div>
      </div>


    </div>

  </div>

{{Form::close()}}

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

</script>

<script type="text/javascript">
$('#formid').on('keyup keypress', function(e) {
  var code = e.keyCode || e.which;
  if (code == 13) { 
    e.preventDefault();
    return false;
  }
});
</script>



<script type="text/javascript">



      $(document).ready(function(){

          $('.Calc0').change(function(){

              var total = 0;

              $('.Calc0').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total0').html(total);

          });



          

          $('.Calc1').change(function(){

              var total = 0;

              $('.Calc1').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total1').html(total);

          });



          $('.Calc2').change(function(){

              var total = 0;

              $('.Calc2').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total2').html(total);

          });



          $('.Calc3').change(function(){

              var total = 0;

              $('.Calc3').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total3').html(total);

          });



          $('.Calc4').change(function(){

              var total = 0;

              $('.Calc4').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total4').html(total);

          });



          $('.Calc5').change(function(){

              var total = 0;

              $('.Calc5').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total5').html(total);

          });



          $('.Calc6').change(function(){

              var total = 0;

              $('.Calc6').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total6').html(total);

          });



          $('.Calc7').change(function(){

              var total = 0;

              $('.Calc7').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total7').html(total);

          });

          $('.Calc8').change(function(){

              var total = 0;

              $('.Calc8').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total8').html(total);

          });

          $('.Calc9').change(function(){

              var total = 0;

              $('.Calc9').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total9').html(total);

          });

          $('.Calc10').change(function(){

              var total = 0;

              $('.Calc10').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total10').html(total);

          });

          $('.Calc11').change(function(){

              var total = 0;

              $('.Calc11').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total11').html(total);

          });

          $('.Calc12').change(function(){

              var total = 0;

              $('.Calc12').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total12').html(total);

          });

          $('.Calc13').change(function(){

              var total = 0;

              $('.Calc13').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total13').html(total);

          });

          $('.Calc14').change(function(){

              var total = 0;

              $('.Calc14').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total14').html(total);

          });

          $('.Calc15').change(function(){

              var total = 0;

              $('.Calc15').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total15').html(total);

          });

          $('.Calc16').change(function(){

              var total = 0;

              $('.Calc16').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total16').html(total);

          });

          $('.Calc17').change(function(){

              var total = 0;

              $('.Calc17').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total17').html(total);

          });

          $('.Calc18').change(function(){

              var total = 0;

              $('.Calc18').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total18').html(total);

          });

          $('.Calc19').change(function(){

              var total = 0;

              $('.Calc19').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total19').html(total);

          });

          $('.Calc20').change(function(){

              var total = 0;

              $('.Calc20').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total20').html(total);

          });

          $('.Calc21').change(function(){

              var total = 0;

              $('.Calc21').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total21').html(total);

          });

          $('.Calc22').change(function(){

              var total = 0;

              $('.Calc22').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total22').html(total);

          });

          $('.Calc23').change(function(){

              var total = 0;

              $('.Calc23').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total23').html(total);

          });

          $('.Calc24').change(function(){

              var total = 0;

              $('.Calc24').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total24').html(total);

          });

          $('.Calc25').change(function(){

              var total = 0;

              $('.Calc25').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total25').html(total);

          });

          $('.Calc26').change(function(){

              var total = 0;

              $('.Calc26').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total26').html(total);

          });

          $('.Calc27').change(function(){

              var total = 0;

              $('.Calc27').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total27').html(total);

          });

          $('.Calc28').change(function(){

              var total = 0;

              $('.Calc28').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total28').html(total);

          });

          $('.Calc29').change(function(){

              var total = 0;

              $('.Calc29').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total29').html(total);

          });

          $('.Calc30').change(function(){

              var total = 0;

              $('.Calc30').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total30').html(total);

          });

          $('.Calc31').change(function(){

              var total = 0;

              $('.Calc31').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total31').html(total);

          });

          $('.Calc32').change(function(){

              var total = 0;

              $('.Calc32').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total32').html(total);

          });

          $('.Calc33').change(function(){

              var total = 0;

              $('.Calc33').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total33').html(total);

          });

          $('.Calc34').change(function(){

              var total = 0;

              $('.Calc34').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total34').html(total);

          });

          $('.Calc35').change(function(){

              var total = 0;

              $('.Calc35').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total35').html(total);

          });

          $('.Calc36').change(function(){

              var total = 0;

              $('.Calc36').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total36').html(total);

          });

          $('.Calc37').change(function(){

              var total = 0;

              $('.Calc37').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total37').html(total);

          });

          $('.Calc38').change(function(){

              var total = 0;

              $('.Calc38').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total38').html(total);

          });

          $('.Calc39').change(function(){

              var total = 0;

              $('.Calc39').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total39').html(total);

          });

          $('.Calc40').change(function(){

              var total = 0;

              $('.Calc40').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total40').html(total);

          });

          $('.Calc41').change(function(){

              var total = 0;

              $('.Calc41').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total41').html(total);

          });

          $('.Calc42').change(function(){

              var total = 0;

              $('.Calc42').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total42').html(total);

          });

          $('.Calc43').change(function(){

              var total = 0;

              $('.Calc43').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total43').html(total);

          });

          $('.Calc44').change(function(){

              var total = 0;

              $('.Calc44').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total44').html(total);

          });

          $('.Calc45').change(function(){

              var total = 0;

              $('.Calc45').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total45').html(total);

          });

          $('.Calc46').change(function(){

              var total = 0;

              $('.Calc46').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total46').html(total);

          });

          $('.Calc47').change(function(){

              var total = 0;

              $('.Calc47').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total47').html(total);

          });

          $('.Calc48').change(function(){

              var total = 0;

              $('.Calc48').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total48').html(total);

          });

          $('.Calc49').change(function(){

              var total = 0;

              $('.Calc49').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total49').html(total);

          });

          $('.Calc50').change(function(){

              var total = 0;

              $('.Calc50').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Total50').html(total);

          });



          $('.Calca0').change(function(){

              var total = 0;

              $('.Calca0').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala0').html(total);

          });



          

          $('.Calca1').change(function(){

              var total = 0;

              $('.Calca1').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala1').html(total);

          });



          $('.Calca2').change(function(){

              var total = 0;

              $('.Calca2').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala2').html(total);

          });



          $('.Calca3').change(function(){

              var total = 0;

              $('.Calca3').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala3').html(total);

          });



          $('.Calca4').change(function(){

              var total = 0;

              $('.Calca4').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala4').html(total);

          });



          $('.Calca5').change(function(){

              var total = 0;

              $('.Calca5').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala5').html(total);

          });



          $('.Calca6').change(function(){

              var total = 0;

              $('.Calca6').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala6').html(total);

          });



          $('.Calca7').change(function(){

              var total = 0;

              $('.Calca7').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala7').html(total);

          });

          $('.Calca8').change(function(){

              var total = 0;

              $('.Calca8').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala8').html(total);

          });

          $('.Calca9').change(function(){

              var total = 0;

              $('.Calca9').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala9').html(total);

          });

          $('.Calca10').change(function(){

              var total = 0;

              $('.Calca10').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala10').html(total);

          });

          $('.Calca11').change(function(){

              var total = 0;

              $('.Calca11').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala11').html(total);

          });

          $('.Calca12').change(function(){

              var total = 0;

              $('.Calca12').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala12').html(total);

          });

          $('.Calca13').change(function(){

              var total = 0;

              $('.Calca13').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala13').html(total);

          });

          $('.Calca14').change(function(){

              var total = 0;

              $('.Calca14').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala14').html(total);

          });

          $('.Calca15').change(function(){

              var total = 0;

              $('.Calca15').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala15').html(total);

          });

          $('.Calca16').change(function(){

              var total = 0;

              $('.Calca16').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala16').html(total);

          });

          $('.Calca17').change(function(){

              var total = 0;

              $('.Calca17').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala17').html(total);

          });

          $('.Calca18').change(function(){

              var total = 0;

              $('.Calca18').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala18').html(total);

          });

          $('.Calca19').change(function(){

              var total = 0;

              $('.Calca19').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala19').html(total);

          });

          $('.Calca20').change(function(){

              var total = 0;

              $('.Calca20').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala20').html(total);

          });

          $('.Calca21').change(function(){

              var total = 0;

              $('.Calca21').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala21').html(total);

          });

          $('.Calca22').change(function(){

              var total = 0;

              $('.Calca22').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala22').html(total);

          });

          $('.Calca23').change(function(){

              var total = 0;

              $('.Calca23').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala23').html(total);

          });

          $('.Calca24').change(function(){

              var total = 0;

              $('.Calca24').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala24').html(total);

          });

          $('.Calca25').change(function(){

              var total = 0;

              $('.Calca25').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala25').html(total);

          });

          $('.Calca26').change(function(){

              var total = 0;

              $('.Calca26').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala26').html(total);

          });

          $('.Calca27').change(function(){

              var total = 0;

              $('.Calca27').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala27').html(total);

          });

          $('.Calca28').change(function(){

              var total = 0;

              $('.Calca28').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala28').html(total);

          });

          $('.Calca29').change(function(){

              var total = 0;

              $('.Calca29').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala29').html(total);

          });

          $('.Calca30').change(function(){

              var total = 0;

              $('.Calca30').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala30').html(total);

          });

          $('.Calca31').change(function(){

              var total = 0;

              $('.Calca31').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala31').html(total);

          });

          $('.Calca32').change(function(){

              var total = 0;

              $('.Calca32').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala32').html(total);

          });

          $('.Calca33').change(function(){

              var total = 0;

              $('.Calca33').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala33').html(total);

          });

          $('.Calca34').change(function(){

              var total = 0;

              $('.Calca34').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala34').html(total);

          });

          $('.Calca35').change(function(){

              var total = 0;

              $('.Calca35').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala35').html(total);

          });

          $('.Calca36').change(function(){

              var total = 0;

              $('.Calca36').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala36').html(total);

          });

          $('.Calca37').change(function(){

              var total = 0;

              $('.Calca37').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala37').html(total);

          });

          $('.Calca38').change(function(){

              var total = 0;

              $('.Calca38').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala38').html(total);

          });

          $('.Calca39').change(function(){

              var total = 0;

              $('.Calca39').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala39').html(total);

          });

          $('.Calca40').change(function(){

              var total = 0;

              $('.Calca40').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala40').html(total);

          });

          $('.Calca41').change(function(){

              var total = 0;

              $('.Calca41').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala41').html(total);

          });

          $('.Calca42').change(function(){

              var total = 0;

              $('.Calca42').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala42').html(total);

          });

          $('.Calca43').change(function(){

              var total = 0;

              $('.Calca43').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala43').html(total);

          });

          $('.Calca44').change(function(){

              var total = 0;

              $('.Calca44').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala44').html(total);

          });

          $('.Calca45').change(function(){

              var total = 0;

              $('.Calca45').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala45').html(total);

          });

          $('.Calca46').change(function(){

              var total = 0;

              $('.Calca46').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala46').html(total);

          });

          $('.Calca47').change(function(){

              var total = 0;

              $('.Calca47').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala47').html(total);

          });

          $('.Calca48').change(function(){

              var total = 0;

              $('.Calca48').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala48').html(total);

          });

          $('.Calca49').change(function(){

              var total = 0;

              $('.Calca49').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala49').html(total);

          });

          $('.Calca50').change(function(){

              var total = 0;

              $('.Calca50').each(function(i){

                  if($(this).val() != '')

                  {

                      total += parseInt($(this).val());

                  }

              });

              $('#Totala50').html(total);

          });

})(jQuery);



   



















</script>



@stop