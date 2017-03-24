@extends("layout-noheader")

@section("content")

 

<head>

    <title>Scorecard | PNP Scorecard System</title>

</head>















<div class="container" style="margin-bottom:5%;">

      <div class="col-md-3">

      </div>

      <div class="col-md-6" style="margin-top:55px; margin-left:-5%; background-color:white;  width:765px; ">

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

          &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;   {{$month}} {{$dt_min->format('d')}} - {{$dt_max->format('d')}}, {{$yearnow}}

            </strong>

          </p>

        </div>

      </div>

      <?php $a = 0; ?> 



        <?php

                    $tempMainActivity = '';

                    $tempSubActivity = '';

                    $tempMeasure = '';

                    $tempObjectiveName = '';

                  ?>







        <table class = "table table-bordered" style = "color:black;  width:600px;" >

          <?php

            $counter = 0;

                                  

          ?>



         @foreach($emp_activities as $emp_activity)



                  

              @if($emp_activity->MainActivityName != $tempMainActivity)

               <?php $a++ ?> 

              <tr>

              <td style = "font-size:10px" colspan=55><b>Main Activity {{$a}}</b>: {{$emp_activity->MainActivityName}}</td>

                    </tr> 

              <tr>

              <td style = "font-size:10px" rowspan=2 colspan=7>Objectives</td>

              <td style = "font-size:10px" rowspan=2 colspan=7>Enabling Actions<br><center>(Sub-activity)</center></td>

              <td style = "font-size:10px; text-align:center" rowspan=2 colspan=7>Measure</td>

              <td style = "font-size:10px; text-align:center" rowspan=2>Target</td>

              <td style = "font-size:10px; text-align:center" colspan=20>Accomplishments</td>

               </tr>

              

              <td style = "font-size:10px" colspan=2>Mon</td>

              <td style = "font-size:10px" colspan=2>Tue</td>

              <td style = "font-size:10px" colspan=2>Wed</td>

              <td style = "font-size:10px" colspan=2>Thu</td>

              <td style = "font-size:10px" colspan=2>Fri</td>

              <td style = "font-size:10px" colspan=2>Sat</td>

              <td style = "font-size:10px" colspan=2>Sun</td>

              <td style = "font-size:10px" colspan=2>Total</td>

              <td style = "font-size:10px" colspan=2>Cost</td>

              <td style = "font-size:10px" colspan=2>Remarks</td>

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



                                    

                                      @if($emp_activity->targetvalue == 0)
                                        <td style = "font-size:10px; text-align:center;" colspan=7><b>0</b></td>
                                      @else

                                       <td style = "font-size:10px; text-align:center;" colspan=7>{{ Form::label('targets[]',$emp_activity->targetvalue, array('placeholder' => '0','autocomplete' => 'off', 'size' => '2' )) }}</td>
                                       @endif
                                     



                                     <div class = 'row'>



                                     <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day1[]'), array('id' => '', 'class' =>'Calc'.$counter, 'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day2[]'),  array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day3[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day4[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day5[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day6[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('day7[]'), array('id' => '', 'class' =>'Calc'.$counter,'placeholder' => '0','autocomplete' => 'off', 'size' => '1', 'disabled' => 'disabled')) }}</td>

                                      

                                       <td style = "font-size:10px" colspan=2><span id="Total{{$counter}}" class="panel"></span></td>

                                     

                                       <td style = "font-size:10px"  colspan=2>{{ Form::label('', Input::get('cost[]'), array('placeholder' => '0','autocomplete' => 'off', 'size' => '1')) }}</td>

                                       <td style = "font-size:10px" colspan=2>{{ Form::label('', Input::get('remarks[]'), array('placeholder' => '','autocomplete' => 'off', 'size' => '2')) }}</td>

                                       </div>

                                       <?php

                                          $counter = $counter + 1;

                                        ?>

                                  

                    </tr>

             



         @endforeach

                

        </table>

      </div>

      {{Form::close()}}

      </div>

</div>



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



})(jQuery);



   



















</script>



@stop