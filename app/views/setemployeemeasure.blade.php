@extends("layout")

@section("content")



<head>

    <title>Set Measures | PNP Scorecard System</title>

</head>





<div class="container" style=" margin-bottom:5%">

	<div class="label_white">
	  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
	    <h1>Edit Measures - {{ $PersonnelName }}</h1>
	  </div>
	</div>

	<div class="col-md-12">

@if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div>

    @endif

</div>



	<div class = "row">



 {{ Form::open(array('url' => 'postsetemployeemeasure', 'method' => 'post')) }}

                      {{Form::hidden('empid',$id)}}

                        <div style="color:white">{{ Form::label('main_id', 'Main Activity:') }}</div>

                        <div style='color:black'>{{ Form::select('main_id', $main_id, Input::get('main_id'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>



 {{Form::close()}}



 {{ Form::open(array('url' => 'postsetemployeemeasure2', 'method' => 'post')) }}

                      {{Form::hidden('empid',$id)}}
                      {{Form::hidden('main_id', $main)}}

                        <div style="color:white">{{ Form::label('sub_activities', 'Sub Activity:') }}</div>

                        <div style='color:black'>{{ Form::select('sub_activities', $sub_activities, Input::get('sub_activities'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '2')) }}</div>



 {{Form::close()}}





<br><br>

{{ Form::open(array('url' => 'posteditmeasure', 'method' => 'post')) }}

 {{Form::hidden('main_id', $main)}}
 
 {{Form::hidden('empid',$id)}}

   <div class = "col-md-12">

        <div class="panel panel-primary">

              <div class="panel-heading" id = "up">

                  <strong>Measures</strong>

              </div>
           <div class="table-responsive">
             <div class="panel-body">

              <table class="table" id="example">

                  <thead>

                      <tr class="filters">       

                          <th>Measure Name</th>

                          <th> Measure Type </th>

                          <th>Actions</th>

                      </tr>

                  </thead>

                  <tbody>

                 <?php

				      $counter = 0;

				                            

				    ?>

                 

	                  @foreach ($measures as $measure)

	                        <tr>





	                            <td style='color:black'>

	                           		{{ Form::label('measure[]', $measure->MeasureName,  array('class' =>'text-info'.$counter, 'style' => 'color:black'))}}

	                           		{{ Form::label('measure[]', $measure->MeasureID,  array('class' =>'text-hidden'.$counter, 'style' => 'color:white'))}}

	                    		</td>

	                    		<td>

	                    			{{ Form::label('measure_type[]', $measure->MeasureType,  array('class' =>'text-type'.$counter, 'style' => 'color:black'))}}

	                    		</td>



	                            <td>

	                              <div class="controls" style="margin-bottom:3px">

								        {{ HTML::link('#up', 'Edit', array('id' => 'edit'.$counter, 'class' => 'btn btn-info'))}}

								    </div>



								    @if($measure->TermDate == null)

									    {{ Form::input('button', 'state', 'Disable' ,array('id' =>'disable'.$counter, 'class' => 'btn btn-danger')) }}

									    {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

									    {{ Form::label('state_id[]', $measure->MeasureID,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

								    @else

		                               {{ Form::input('button', 'state', 'Enable',array('id' =>'enable'.$counter, 'class' => 'btn btn-success')) }}

		                                {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

		                                {{ Form::label('state_id[]', $measure->MeasureID,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

	                                @endif

	                            </td>

	                              <?php

                                    $counter = $counter + 1;

                                  ?>

	                        </tr>

                          @endforeach

                

                  </tbody>

              </table>

             </div> 
           </div>
        </div>



    </div>



    <div class='col-md-12'>

    	<div class='col-md-10'></div>



    	<div class='col-md-2'>

    		 <input class = 'btn btn-success' style='font-size:15px; padding-top:15px; padding-bottom:15px' type="submit" name="Edit" value="Save Changes">

    	</div>

    </div>







	</div>

</div>





<script type="text/javascript">

$(document).on('click','#disable0',function(){

     var $this=$(this);

     $this.prop('id','enable0');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable0").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis0').text('').append(put);

	 var state_text = $('.state0').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state0').text('').append(input2);

	 });



	$(document).on('click','#enable0',function(){

	     var $this=$(this);

	      $this.prop('id','disable0');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable0").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis0').text('').append(put);

	 	   var state_text = $('.state0').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state0').text('').append(input2);

	 });



	$(document).on('click','#disable1',function(){

     var $this=$(this);

     $this.prop('id','enable1');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable1").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis1').text('').append(put);

	 var state_text = $('.state1').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state1').text('').append(input2);

	 });



	$(document).on('click','#enable1',function(){

	     var $this=$(this);

	      $this.prop('id','disable1');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable1").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis1').text('').append(put);

	 	   var state_text = $('.state1').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state1').text('').append(input2);

	 });



	$(document).on('click','#disable2',function(){

     var $this=$(this);

     $this.prop('id','enable2');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable2").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis2').text('').append(put);

	 var state_text = $('.state2').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state2').text('').append(input2);

	 });



	$(document).on('click','#enable2',function(){

	     var $this=$(this);

	      $this.prop('id','disable2');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable2").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis2').text('').append(put);

	 	   var state_text = $('.state2').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state2').text('').append(input2);

	 });



	$(document).on('click','#disable3',function(){

     var $this=$(this);

     $this.prop('id','enable3');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable3").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis3').text('').append(put);

	 var state_text = $('.state3').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state3').text('').append(input2);

	 });



	$(document).on('click','#enable3',function(){

	     var $this=$(this);

	      $this.prop('id','disable3');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable3").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis3').text('').append(put);

	 	   var state_text = $('.state3').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state3').text('').append(input2);

	 });



	$(document).on('click','#disable4',function(){

     var $this=$(this);

     $this.prop('id','enable4');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable4").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis4').text('').append(put);

	 var state_text = $('.state4').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state4').text('').append(input2);

	 });



	$(document).on('click','#enable4',function(){

	     var $this=$(this);

	      $this.prop('id','disable4');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable4").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis4').text('').append(put);

	 	   var state_text = $('.state4').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state4').text('').append(input2);

	 });





	$(document).on('click','#disable5',function(){

     var $this=$(this);

     $this.prop('id','enable5');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable5").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis5').text('').append(put);

	 var state_text = $('.state5').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state5').text('').append(input2);

	 });



	$(document).on('click','#enable5',function(){

	     var $this=$(this);

	      $this.prop('id','disable5');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable5").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis5').text('').append(put);

	 	   var state_text = $('.state5').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state5').text('').append(input2);

	 });



	$(document).on('click','#disable6',function(){

     var $this=$(this);

     $this.prop('id','enable6');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable6").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis6').text('').append(put);

	 var state_text = $('.state6').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state6').text('').append(input2);

	 });



	$(document).on('click','#enable6',function(){

	     var $this=$(this);

	      $this.prop('id','disable6');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable6").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis6').text('').append(put);

	 	   var state_text = $('.state6').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state6').text('').append(input2);

	 });



	$(document).on('click','#disable7',function(){

     var $this=$(this);

     $this.prop('id','enable7');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable7").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis7').text('').append(put);

	 var state_text = $('.state7').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state7').text('').append(input2);

	 });



	$(document).on('click','#enable7',function(){

	     var $this=$(this);

	      $this.prop('id','disable7');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable7").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis7').text('').append(put);

	 	   var state_text = $('.state7').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state7').text('').append(input2);

	 });



	$(document).on('click','#disable8',function(){

     var $this=$(this);

     $this.prop('id','enable8');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable8").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis8').text('').append(put);

	 var state_text = $('.state8').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state8').text('').append(input2);

	 });



	$(document).on('click','#enable8',function(){

	     var $this=$(this);

	      $this.prop('id','disable8');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable8").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis8').text('').append(put);

	 	   var state_text = $('.state8').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state8').text('').append(input2);

	 });



	$(document).on('click','#disable9',function(){

     var $this=$(this);

     $this.prop('id','enable9');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable9").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis9').text('').append(put);

	 var state_text = $('.state9').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state9').text('').append(input2);

	 });



	$(document).on('click','#enable9',function(){

	     var $this=$(this);

	      $this.prop('id','disable9');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable9").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis9').text('').append(put);

	 	   var state_text = $('.state9').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state9').text('').append(input2);

	 });



	$(document).on('click','#disable10',function(){

     var $this=$(this);

     $this.prop('id','enable10');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable10").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis10').text('').append(put);

	 var state_text = $('.state10').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state10').text('').append(input2);

	 });



	$(document).on('click','#enable10',function(){

	     var $this=$(this);

	      $this.prop('id','disable10');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable10").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis10').text('').append(put);

	 	   var state_text = $('.state10').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state10').text('').append(input2);

	 });



	$(document).on('click','#disable11',function(){

     var $this=$(this);

     $this.prop('id','enable11');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable11").attr('class', 'btn btn-success');

     var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Disable" />')

	 $('.dis11').text('').append(put);

	 var state_text = $('.state11').text();

	 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state11').text('').append(input2);

	 });



	$(document).on('click','#enable11',function(){

	     var $this=$(this);

	      $this.prop('id','disable11');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable11").attr('class', 'btn btn-danger');

	      var put = $('<input style = "width: 760px; height: 40px" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis11').text('').append(put);

	 	   var state_text = $('.state11').text();

		 var input2 = $('<input style = "width: 760px; height: 40px" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state11').text('').append(input2);

	 });



</script>



<script type="text/javascript">



$('#unitid').on('change', function(e){

    $(this).closest('form').submit();

});



$('#unitid2').on('change', function(e){

    $(this).closest('form').submit();

});

</script>



<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>



<script type="text/javascript">



		

		$('#edit0').click(function() {

		    var text = $('.text-info0').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info0').text('').append(input);

		    var text1 = $('.text-hidden0').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden0').text('').append(input1);

		    var text2 = $('.text-type0').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect0" name="measure_types[]" value="option">')

		     $('.text-type0').text('').append(input2);
		      var x = document.getElementById("mySelect0");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});



		$('#edit1').click(function() {

		    var text = $('.text-info1').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info1').text('').append(input);

		    var text1 = $('.text-hidden1').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden1').text('').append(input1);

		    var text2 = $('.text-type1').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect1" name="measure_types[]" value="option">')

		     $('.text-type1').text('').append(input2);
		      var x = document.getElementById("mySelect1");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});



		$('#edit2').click(function() {

		    var text = $('.text-info2').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info2').text('').append(input);

		    var text1 = $('.text-hidden2').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden2').text('').append(input1);

		    var text2 = $('.text-type2').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect2" name="measure_types[]" value="option">')

		     $('.text-type2').text('').append(input2);
		      var x = document.getElementById("mySelect2");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});



		$('#edit3').click(function() {

		    var text = $('.text-info3').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info3').text('').append(input);

		    var text1 = $('.text-hidden3').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden3').text('').append(input1);

		    var text2 = $('.text-type3').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect3" name="measure_types[]" value="option">')

		     $('.text-type3').text('').append(input2);
		      var x = document.getElementById("mySelect3");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);


		});



		$('#edit4').click(function() {

		    var text = $('.text-info4').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info4').text('').append(input);

		    var text1 = $('.text-hidden4').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden4').text('').append(input1);

		    var text2 = $('.text-type4').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect4" name="measure_types[]" value="option">')

		     $('.text-type4').text('').append(input2);
		      var x = document.getElementById("mySelect4");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit5').click(function() {

		    var text = $('.text-info5').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info5').text('').append(input);

		    var text1 = $('.text-hidden5').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden5').text('').append(input1);

		    var text2 = $('.text-type5').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect5" name="measure_types[]" value="option">')

		     $('.text-type5').text('').append(input2);
		      var x = document.getElementById("mySelect5");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit6').click(function() {

		    var text = $('.text-info6').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info6').text('').append(input);

		    var text1 = $('.text-hidden6').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden6').text('').append(input1);

		    var text2 = $('.text-type6').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect6" name="measure_types[]" value="option">')

		     $('.text-type6').text('').append(input2);
		      var x = document.getElementById("mySelect6");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit7').click(function() {

		    var text = $('.text-info7').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info7').text('').append(input);

		    var text1 = $('.text-hidden7').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden7').text('').append(input1);

		    var text2 = $('.text-type7').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect7" name="measure_types[]" value="option">')

		     $('.text-type7').text('').append(input2);
		      var x = document.getElementById("mySelect7");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit8').click(function() {

		    var text = $('.text-info8').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info8').text('').append(input);

		    var text1 = $('.text-hidden8').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden8').text('').append(input1);

		    var text2 = $('.text-type8').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect8" name="measure_types[]" value="option">')

		     $('.text-type8').text('').append(input2);
		      var x = document.getElementById("mySelect8");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit9').click(function() {

		    var text = $('.text-info9').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info9').text('').append(input);

		    var text1 = $('.text-hidden9').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden9').text('').append(input1);

		    var text2 = $('.text-type9').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect9" name="measure_types[]" value="option">')

		     $('.text-type9').text('').append(input2);
		      var x = document.getElementById("mySelect9");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit10').click(function() {

		    var text = $('.text-info10').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info10').text('').append(input);

		    var text1 = $('.text-hidden10').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden10').text('').append(input1);

		    var text2 = $('.text-type10').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect10" name="measure_types[]" value="option">')

		     $('.text-type10').text('').append(input2);
		      var x = document.getElementById("mySelect10");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit11').click(function() {

		    var text = $('.text-info11').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info11').text('').append(input);

		    var text1 = $('.text-hidden11').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden11').text('').append(input1);

		    var text2 = $('.text-type11').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect11" name="measure_types[]" value="option">')

		     $('.text-type11').text('').append(input2);
		      var x = document.getElementById("mySelect11");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});



</script>

@stop