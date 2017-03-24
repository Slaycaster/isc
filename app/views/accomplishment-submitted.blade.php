@extends("layout-employee")

@section("content")

 

<head>

    <title>Scorecard (Submitted) | PNP Scorecard System</title>

</head>

 {{ Form::open(array('url' => 'employee/accomplishment-final', 'method' => 'post')) }}

<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

  <center><h1><strong>SUBMITTED SCORECARD</strong></h1></center>
  <center><h4><strong>( GENERATE PDF THROUGH REPORT BUTTON )</strong></h4></center><hr>



  {{Form::hidden('targetstatus', $targetstatus) }}





<div class="col-md-3">

</div>

<div class="col-md-6" style=" margin-left:1%; background-color:white;  width:1118px; ">

    @if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div><br>

    @endif



@foreach($employee as $employees)



<div class="col-md-12" style="margin-top:5%; margin-bottom:10px;">

  <div class="col-md-4"> 

    <img style = "height:150px; width:150px;" src="{{URL::asset($employees->EmpPicturePath)}}">

  </div>

  <div class="col-md-8" style="color:black;">

    

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

    {{ HTML::link('#my_modal', 'Undo Scorecard Submission', array('data-book-id' => '123', 'data-toggle' => 'modal', 'class' => 'btn btn-danger'))}}
     

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



                              

                                

                                 <td style = "font-size:10px; text-align:center;" colspan=7>{{ $emp_activity->Target}}</td>

                               



                               <div class = 'row'>



                      





                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->MondayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->TuesdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->WednesdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->ThursdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->FridayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->SaturdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $emp_activity->SundayValue }}</td>







                                

                                 <td style = "font-size:10px" colspan=2>
                                    @if($emp_activity->MeasureType == 'Summation/Total')
                                    {{$emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue}}
                                    
                                @elseif($emp_activity->MeasureType == 'Average')
                                {{round( (($emp_activity->MondayValue + $emp_activity->TuesdayValue + $emp_activity->WednesdayValue + $emp_activity->ThursdayValue + $emp_activity->FridayValue + $emp_activity->SaturdayValue + $emp_activity->SundayValue) / 7), 2)}}
                                    
                                @endif

                                  </td>

                               

                                 <td style = "font-size:10px"  colspan=2> </td>

                                 <td style = "font-size:10px" colspan=2>{{ $emp_activity->Remarks}} </td>

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

                       







                                 

                                 <td style = "font-size:10px; text-align:center;" colspan=7>{{ $other_activity->Target}}</td>

                               



                               <div class = 'row'>



                      





                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->MondayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->TuesdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->WednesdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->ThursdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->FridayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->SaturdayValue }}</td>

                                <td style = "font-size:10px; text-align:center;" colspan=2>{{ $other_activity->SundayValue }}</td>







                                

                                 <td style = "font-size:10px" colspan=2>{{ $other_activity->MondayValue + $other_activity->TuesdayValue + $other_activity->WednesdayValue + $other_activity->ThursdayValue + $other_activity->FridayValue + $other_activity->SaturdayValue + $other_activity->SundayValue }}</td>

                               

                                 <td style = "font-size:10px"  colspan=2> </td>

                                 <td style = "font-size:10px" colspan=2>{{ $other_activity->Remarks}} </td>

                                 </div>

                                 <?php

                                    $counter1 = $counter1 + 1;

                                  ?>

                            

              </tr>

       



   @endforeach

          

  </table>
@endif
  <br><br>

</div>

</div>
  {{Form::close()}}
{{ Form::open(array('url' => 'postEmpremovescorecard', 'method' => 'post')) }}

                               <div class="modal" id="my_modal">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                              <h4 class="modal-title">Remove Current Scorecard</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><b>WARNING!</b> This will clear all targets and accomplishments you've submitted and note that this will reflect again as not submitted to your supervisor.
                                           </p> <br>
                                           <p> Are you sure you want to proceed?</p>
                                          </div>
                                          <div class="modal-footer">
                                            <input type="submit" value = "Confirm" class="btn btn-success"></input>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
        {{Form::close()}}

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