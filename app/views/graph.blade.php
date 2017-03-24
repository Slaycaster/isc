@extends("layout")
@section("content")

<head>

    <title>Administrator - Key Performance Indicator (KPI)| PNP Scorecard System</title>

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
    

  </div>
  @foreach($employsname as $names)
    <h1 style="color:white"><i style="font-size: 25px"> {{$names->RankCode}} {{$names->EmpLastName}}, {{$names->EmpFirstName}}</i></h1>
    @endforeach 
  </center>




  </div>
  {{ Form::open(array('target' => '_blank', 'url' => 'KPIReport', 'method' => 'get')) }}


        <div class = "col-md-12">
        
                  <div class="panel panel-default">
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

      $('#examples').DataTable();

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