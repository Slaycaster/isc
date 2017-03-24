@extends("layout-employee")
@section("content")

<head>

    <title>Key Performance Indicator (KPI) | PNP Scorecard System</title>

</head>
<style type="text/css">

.text_paragraph >p{

    -webkit-animation: fadi 3s 1;
}



@-webkit-keyframes fadi {

    0%   { opacity: 0; }

    100% { opacity: 1; }

}

@-moz-keyframes4fadi {

    0%   { opacity: 0; }

    100% { opacity: 1; }

}



</style>
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

    <br><center><div class="text_paragraph">

    <p style="font-size: 30px"><strong>ANALYSIS REPORT - KEY PERFORMANCE INDICATOR (KPI)</strong> </p>
    <hr>
  </div></center>

  </div>
  {{ Form::open(array('target' => '_blank', 'url' => 'KPIReport', 'method' => 'get')) }}

        <div class = "col-md-12">
                            <div class="panel panel-default hideit">
            <div class="panel-heading">
             <strong>Result</strong> <div style="text-align:right; margin-top: -20px">{{ Form::submit('Generate PDF Report', array('class' => 'btn btn-primary')) }}</div> 
            </div>	
             <div class="panel-body">

                        {{Form::hidden('empid',$empid)}}
                        {{Form::hidden('StartDate',$StartDate)}}

                        <table class="table" id="example3">

                          <thead>

                             <tr>       
                                  <th width="30%">Measure Name</th>

                                  <th width="10%">Target</th>

                                  <th width="10%">Measure Type</th>

                                  <th width="10%">Accomplishment</th>

                                  <th width="10%">Variance (Accomp - Target)</th>

                                  <th width="30%">Performance</th>

                              </tr>

                          </thead>

                          <tbody>
                          @foreach ($summations as $summation)

                          <tr>
                              <td>
                                  {{$summation->MeasureName}}  
                              </td>
                              <td>
                                {{$summation->Target}}
                              </td>
                              <td>
                                {{$summation->MeasureType}}
                              </td>
                              <td>
                                @if($summation->MeasureType == 'Summation/Total')
                                  {{$summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue}}
                                @elseif($summation->MeasureType == 'Average')
                                {{round( (($summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue) / 7), 2)}}
                                @endif
                              </td>

                              <td>
                                @if($summation->MeasureType == 'Summation/Total')
                                  <?php
                                    $res = $summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue
                                  ?>
                                  {{ round(($res - $summation->Target), 2) }}
                                @elseif($summation->MeasureType == 'Average')
                                 <?php
                                  $res2 = (($summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue) / 7)
                                  ?>
                                  {{ round(($res2 - $summation->Target), 2) }}
                                @endif
                              </td>

                              <td>
                                @if($summation->MeasureType == 'Summation/Total')
                                  <?php
                                    $res = $summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue
                                  ?>
                                  <a name="poll_bar"></a> <span name="poll_val">{{round(($res / $summation->Target) * 100, 2)}}%</span><br/>
                                @elseif($summation->MeasureType == 'Average')
                                 <?php
                                  $res2 = (($summation->MondayValue + $summation->TuesdayValue + $summation->WednesdayValue + $summation->ThursdayValue + $summation->FridayValue + $summation->SaturdayValue + $summation->SundayValue) / 7)
                                  ?>
                                  <a name="poll_bar"></a> <span name="poll_val">{{round(($res2 / $summation->Target) * 100, 2)}}%</span><br/>
                                @endif
                                
                                
                              </td>
                              
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                       </div>
          </div>
        </div>

        <div class = "col-md-12">
          <div class="panel panel-default hideit1">
            <div class="panel-heading">
             <strong>Target Value</strong> <div style="text-align:right; margin-top: -20px">{{ Form::submit('Generate PDF Report', array('class' => 'btn btn-primary', 'name' => 'Target')) }}</div>
            </div>
             <div class="panel-body">

                        <table class="table" id="example1">

                          <thead>

                              <tr>       
                                  <th width="25%">Measure Name</th>

                                  <th width="15%">Measure Type</th>

                                  <th width="10%">Targets</th>

                                  <th width="10%">Latest Value of Accomplishment</th>

                                  <th width="10%">TV - LVA</th>

                                  <th width="30%">Performance</th>

                              </tr>

                          </thead>

                          <tbody>

                          @foreach ($summations as $summation)
                          <tr>
                              <td>
                                  {{$summation->MeasureName}}  
                              </td>
                              <td>
                                {{$summation->MeasureType}}
                              </td>
                              <td>
                                {{$summation->Target}}
                              </td>
                              <td>
                                @if($summation->MondayValue != 0 
                                    && $summation->TuesdayValue == 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)                                    

                                    <div>{{$summation->MondayValue}} (Monday)</div>
                                   
                                @elseif($summation->TuesdayValue != 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)

                                    <div>{{$summation->TuesdayValue}} (Tuesday)</div>
                                    
                                @elseif($summation->WednesdayValue != 0 
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)

                                    <div>{{$summation->WednesdayValue}} (Wednesday)</div>

                                @elseif($summation->ThursdayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)

                                    <div>{{$summation->ThursdayValue}} (Thursday)</div>

                                @elseif($summation->FridayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)

                                    <div>{{$summation->FridayValue}} (Friday)</div>

                                @elseif($summation->SaturdayValue != 0 
                                    && $summation->SundayValue == 0)

                                    <div>{{$summation->SaturdayValue}} (Saturday)</div>

                                @elseif($summation->SundayValue != 0)

                                    <div>{{$summation->SundayValue}} (Sunday)</div>
  
                                @elseif($summation->FridayValue == 0 
                                    && $summation->MondayValue == 0 
                                    && $summation->TuesdayValue == 0
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <div>0</div>
                                    
                                @endif
                              </td>
                              <td>
                                @if($summation->MondayValue != 0 
                                    && $summation->TuesdayValue == 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)                                    
                                    <?php $mon = $summation->Target - $summation->MondayValue?>
                                    <div>{{$mon}}</div>
                                   
                                @elseif($summation->TuesdayValue != 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $tue = $summation->Target - $summation->TuesdayValue?>
                                    <div>{{$tue}}</div>
                                    
                                @elseif($summation->WednesdayValue != 0 
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $wed = $summation->Target - $summation->WednesdayValue?>
                                    <div>{{$wed}}</div>

                                @elseif($summation->ThursdayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $thu = $summation->Target - $summation->ThursdayValue?>
                                    <div>{{$thu}}</div>

                                @elseif($summation->FridayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $fri = $summation->Target - $summation->FridayValue?>
                                    <div>{{$fri}}</div>

                                @elseif($summation->SaturdayValue != 0 
                                    && $summation->SundayValue == 0)
                                    <?php $sat = $summation->Target - $summation->SaturdayValue?>
                                    <div>{{$sat}}</div>

                                @elseif($summation->SundayValue != 0)
                                    <?php $sun = $summation->Target - $summation->SundayValue?>
                                    <div>{{$sun}}</div>
  
                                @elseif($summation->FridayValue == 0 
                                    && $summation->MondayValue == 0 
                                    && $summation->TuesdayValue == 0
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <div>{{$summation->Target}}</div>
                                    
                                @endif
                              </td>
                              <td>
                                @if($summation->MondayValue != 0 
                                    && $summation->TuesdayValue == 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)                                    
                                    <?php $mon = $summation->Target - $summation->MondayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($mon / $summation->Target) * 100, 2)}}%</span><br/></div>
                                   
                                @elseif($summation->TuesdayValue != 0 
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $tue = $summation->Target - $summation->TuesdayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($tue / $summation->Target) * 100, 2)}}%</span><br/></div>
                                    
                                @elseif($summation->WednesdayValue != 0 
                                    && $summation->ThursdayValue == 0
                                    && $summation->FridayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $wed = $summation->Target - $summation->WednesdayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($wed / $summation->Target) * 100, 2)}}%</span><br/></div>

                                @elseif($summation->ThursdayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $thu = $summation->Target - $summation->ThursdayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($thu / $summation->Target) * 100, 2)}}%</span><br/></div>

                                @elseif($summation->FridayValue != 0 
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <?php $fri = $summation->Target - $summation->FridayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($fri / $summation->Target) * 100, 2)}}%</span><br/></div>

                                @elseif($summation->SaturdayValue != 0 
                                    && $summation->SundayValue == 0)
                                    <?php $sat = $summation->Target - $summation->SaturdayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($sat / $summation->Target) * 100, 2)}}%</span><br/></div>

                                @elseif($summation->SundayValue != 0)
                                    <?php $sun = $summation->Target - $summation->SundayValue?>
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($sun / $summation->Target) * 100, 2)}}%</span><br/></div>
  
                                @elseif($summation->FridayValue == 0 
                                    && $summation->MondayValue == 0 
                                    && $summation->TuesdayValue == 0
                                    && $summation->WednesdayValue == 0
                                    && $summation->ThursdayValue == 0
                                    && $summation->SaturdayValue == 0
                                    && $summation->SundayValue == 0)
                                    <div><a name="poll_bar"></a> <span name="poll_val">{{round(($summation->Target / $summation->Target) * 100, 2)}}%</span><br/></div>
                                    
                                @endif
                              </td>
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                       </div>
          </div>
        </div>

        <div class = "col-md-12">
          <div class="panel panel-default hideit2">
            <div class="panel-heading">
             <strong>Weighted Average</strong> <div style="text-align:right; margin-top: -20px">{{ Form::submit('Generate PDF Report', array('class' => 'btn btn-primary', 'name' => 'WeightedAverage')) }}</div>
            </div>
            <div class="panel-body">
              <table class="table" id="example2">

                          <thead>

                              <tr>       
                                  <th width="30%">Measure Name</th>

                                  <th width="20%">Measure Type</th>

                                  <th width="20%">Targets</th>

                                  <th width="30%">Weighted Average</th>

                              </tr>

                          </thead>

                          <tbody>

                          @foreach ($summations as $summation)
                          <tr>
                              <td>
                                  {{$summation->MeasureName}}  
                              </td>
                              <td>
                                {{$summation->MeasureType}}
                              </td>
                              <td>
                                {{$summation->Target}}
                              </td>
                              <td>
                                <?php $ave = 0;
                                      $count = 0;
                                  if ($summation->MondayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->TuesdayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->WednesdayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->ThursdayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->FridayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->SaturdayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                  elseif ($summation->SundayValue == 0) 
                                  {
                                    $count = $count + 1;
                                  }
                                    

                                  $ave = 7 - $count;

                                  if ($count != 0)
                                  {

                                  $mon = ($summation->MondayValue / $ave) * 100;
                                  $tue = ($summation->TuesdayValue / $ave) * 100;
                                  $wed = ($summation->WednesdayValue / $ave) * 100;
                                  $thu = ($summation->ThursdayValue / $ave) * 100;
                                  $fri = ($summation->FridayValue / $ave) * 100;
                                  $sat = ($summation->SaturdayValue / $ave) * 100;
                                  $sun = ($summation->SundayValue / $ave) * 100;
                                  }
                                  else
                                  {

                                  }
                                ?>
                                <div><a name="poll_bar"></a> <span name="poll_val">{{round(($mon + $tue + $wed + $thu + $fri + $sat + $sun), 2)}}%</span></div>
                                
                              </td>
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
            </div>
          </div>
        </div>
{{ Form::Close() }}
<script type="text/javascript">
      

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="0"){
                $(".hideit").toggle(500);
       
            }
            else {
                $(".hideit").hide();
            }

        });
    });
</script>
<script type="text/javascript">
      $(".hideit1").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="1"){
                $(".hideit1").toggle(500);
       
            }
            else {
                $(".hideit1").hide();
            }

        });
    });
</script>
<script type="text/javascript">
      $(".hideit2").hide();

     $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            if($(this).attr("value")=="2"){
                $(".hideit2").toggle(500);
       
            }
            else {
                $(".hideit2").hide();
            }

        });
    });
</script>


<script type="text/javascript">

  $(document).ready(function() {

      $('#example1').DataTable();

  } );
  $(document).ready(function(){
      // add button style 
   
    // Add button style with alignment to left with margin.
    $("[name='poll_bar'").css({"text-align":"left","margin":"10px"});    
    
    //loop 
    $("[name='poll_bar'").each(
        function(i){      
          //get poll value  
          var bar_width = (parseFloat($("[name='poll_val'").eq(i).text())/2).toString();          
          bar_width = bar_width + "%"; //add percentage sign.                   
          //set bar button width as per poll value mention in span.
          var maxi = '70%';
          $("[name='poll_bar'").eq(i).width(bar_width);         
          
          //Define rules.
          var bar_width_rule = parseFloat($("[name='poll_val'").eq(i).text());
          if(bar_width_rule >= 101){$("[name='poll_bar'").eq(i).width(maxi).addClass("btn btn-sm btn-info")}           
          if(bar_width_rule >= 50 && bar_width_rule <= 100){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-success")}
          if(bar_width_rule <  50 && bar_width_rule >= 26){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-warning")}
          if(bar_width_rule <= 25 && bar_width_rule >= 1){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-danger")}
          if(bar_width == 0){$("[name='poll_bar'").eq(i).width(0)}
          //Hide dril down divs
          $("#" + $("[name='poll_bar'").eq(i).text()).hide();
    });
    
    //On click main menu bar show its particular detail div.
    /*$("[name='poll_bar'").click(function()
    {  
       //Hide all 
       $(".panel-body").children().hide();
       //Display only selected bar texted div sub chart.
       $("#" + $(this).text()).show();
       //If not inner drill down sub detail found then move to main menu.
       if($("#" + $(this).text()).length == 0) {
           $("#Main").show();          
        }       
    });*/
});

</script>

<script type="text/javascript">

  $(document).ready(function() {

      $('#example3').DataTable();

  } );

  $(document).ready(function(){
      // add button style 
   
    // Add button style with alignment to left with margin.
    $("[name='poll_bar'").css({"text-align":"left","margin":"10px"});    
    
    //loop 
    $("[name='poll_bar'").each(
        function(i){      
          //get poll value  
          var bar_width = (parseFloat($("[name='poll_val'").eq(i).text())/2).toString();          
          bar_width = bar_width + "%"; //add percentage sign.                   
          //set bar button width as per poll value mention in span.
          
          $("[name='poll_bar'").eq(i).width(bar_width);         
          
          //Define rules.
          var bar_width_rule = parseFloat($("[name='poll_val'").eq(i).text());
          if(bar_width_rule >= 101){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-info")}           
          if(bar_width_rule >= 50 && bar_width_rule <= 100){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-success")}
          if(bar_width_rule <  50 && bar_width_rule >= 26){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-warning")}
          if(bar_width_rule <= 25 && bar_width_rule >= 1){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-danger")}
          if(bar_width == 0){$("[name='poll_bar'").eq(i).width(0)}
          //Hide dril down divs
          $("#" + $("[name='poll_bar'").eq(i).text()).hide();
    });
    
    //On click main menu bar show its particular detail div.
    /*$("[name='poll_bar'").click(function()
    {  
       //Hide all 
       $(".panel-body").children().hide();
       //Display only selected bar texted div sub chart.
       $("#" + $(this).text()).show();
       //If not inner drill down sub detail found then move to main menu.
       if($("#" + $(this).text()).length == 0) {
           $("#Main").show();          
        }       
    });*/
});

</script>

<script type="text/javascript">

  $(document).ready(function() {

      $('#example2').DataTable();

  } );

  $(document).ready(function(){
      // add button style 
   
    // Add button style with alignment to left with margin.
    $("[name='poll_bar'").css({"text-align":"left","margin":"10px"});    
    
    //loop 
    $("[name='poll_bar'").each(
        function(i){      
          //get poll value  
          var bar_width = (parseFloat($("[name='poll_val'").eq(i).text())/2).toString();          
          bar_width = bar_width + "%"; //add percentage sign.                   
          //set bar button width as per poll value mention in span.
          var maxi = '70%';
          $("[name='poll_bar'").eq(i).width(bar_width);         
          
          //Define rules.
          var bar_width_rule = parseFloat($("[name='poll_val'").eq(i).text());
          if(bar_width_rule >= 101){$("[name='poll_bar'").eq(i).width(maxi).addClass("btn btn-sm btn-info")}           
          if(bar_width_rule >= 50 && bar_width_rule <= 100){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-success")}
          if(bar_width_rule <  50 && bar_width_rule >= 26){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-warning")}
          if(bar_width_rule <= 25 && bar_width_rule >= 1){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-danger")}
          if(bar_width == 0){$("[name='poll_bar'").eq(i).width(0)}
          //Hide dril down divs
          $("#" + $("[name='poll_bar'").eq(i).text()).hide();
    });
    
    //On click main menu bar show its particular detail div.
    /*$("[name='poll_bar'").click(function()
    {  
       //Hide all 
       $(".panel-body").children().hide();
       //Display only selected bar texted div sub chart.
       $("#" + $(this).text()).show();
       //If not inner drill down sub detail found then move to main menu.
       if($("#" + $(this).text()).length == 0) {
           $("#Main").show();          
        }       
    });*/
});
</script>

<script type="text/javascript">
$(document).ready(function(){
      // add button style 
   
    // Add button style with alignment to left with margin.
    $("[name='poll_bar'").css({"text-align":"left","margin":"10px"});    
    
    //loop 
    $("[name='poll_bar'").each(
        function(i){      
          //get poll value  
          var bar_width = (parseFloat($("[name='poll_val'").eq(i).text())/2).toString();          
          bar_width = bar_width + "%"; //add percentage sign.                   
          //set bar button width as per poll value mention in span.
          var maxi = '70%';
          $("[name='poll_bar'").eq(i).width(bar_width);         
          
          //Define rules.
          var bar_width_rule = parseFloat($("[name='poll_val'").eq(i).text());
          if(bar_width_rule >= 101){$("[name='poll_bar'").eq(i).width(maxi).addClass("btn btn-sm btn-info")}           
          if(bar_width_rule >= 50 && bar_width_rule <= 100){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-success")}
          if(bar_width_rule <  50 && bar_width_rule >= 26){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-warning")}
          if(bar_width_rule <= 25 && bar_width_rule >= 1){$("[name='poll_bar'").eq(i).addClass("btn btn-sm btn-danger")}
          if(bar_width == 0){$("[name='poll_bar'").eq(i).width(0)}
          //Hide dril down divs
          $("#" + $("[name='poll_bar'").eq(i).text()).hide();
    });
    
    //On click main menu bar show its particular detail div.
    /*$("[name='poll_bar'").click(function()
    {  
       //Hide all 
       $(".panel-body").children().hide();
       //Display only selected bar texted div sub chart.
       $("#" + $(this).text()).show();
       //If not inner drill down sub detail found then move to main menu.
       if($("#" + $(this).text()).length == 0) {
           $("#Main").show();          
        }       
    });*/
});
</script>
@stop