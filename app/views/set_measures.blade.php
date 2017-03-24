	@extends("layout-employee")

@section("content")



<head>

    <title>Edit Measures | PNP Scorecard System</title>

</head>




<?php
	$emp_id = Session::get('empid', 'default');
?>
<div class="container" style=" margin-bottom:5%">

	<div class="label_white">

	<div class="col-md-12">

			<center><h1>Scorecard - Edit Measures </h1></center>

	</div>

	</div>

	<div class="col-md-12">

@if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div>

    @endif

</div>



	<div class = "row">

	@foreach($users as $user)  

        @if($user->state == 'Disable' or $user->state == 'Enable')

            @foreach($myrecord as $records)
                 
                @foreach($unitoffice as $unitoffices)
                             
                   @if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                                  
                      @if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                        or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                        
                           	@if($unitoffices->state == 'Disable') 

								@foreach($main_id as $id)
							     <div style="color:white">{{ Form::label('main_id', 'Main Activity:') }} <p style="font-size:20px">{{$id->MainActivityName}}</p></div>
							      {{Form::hidden('main', $id->id)}}
								@endforeach

                            @endif
                            @if($unitoffices->state == 'Enable')

				                    <div style="color:white">{{ Form::label('main_id', 'Main Activity:') }}</div>
				                    <div style='color:black'>{{ Form::select('main_id', $main_id, Input::get('main_id'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>

                            @endif
                    
                        @endif

                    @endif
                            <?php break; ?>
                @endforeach  

            @endforeach

        @endif

	@endforeach

 				{{ Form::open(array('url' => 'employee/postset_measures2', 'method' => 'post')) }}
					{{Form::hidden('main_id', $main)}}                      
                    <div style="color:white">{{ Form::label('sub_activities', 'Sub Activity:') }}</div>
                    <div style='color:black'>{{ Form::select('sub_activities', $sub_activities, Input::get('sub_activities'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid2', 'tabindex' => '2')) }}</div>
 				{{Form::close()}}





<br><br>

{{ Form::open(array('url' => 'employee/postedit_measures', 'method' => 'post')) }}

 {{Form::hidden('main_id', $main)}}

   <div class = "col-md-12">

        <div class="panel panel-primary">

              <div class="panel-heading" id = "up">

                  <strong>Measures</strong>

              </div>

             <div class="panel-body">

              <table class="table" id="example">

                  <thead>

                      <tr class="filters">       

                          <th>Measure Name</th>

                          <th>Measure Type</th>

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



    <div class='col-md-12'>

    	<div class='col-md-10'></div>



    	<div class='col-md-2'>

    		 <input class = 'btn btn-success' style='font-size:15px; padding-top:15px; padding-bottom:15px' type="submit" name="Edit" value="Save Changes">

    	</div>

    </div>







	</div>

</div>

<script type="text/javascript">

	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
	$(document).ready(function()
	{
    	//Unit Office dropdown
    	$('#unitid').change(function()
    	{
        	$('#unitid2').html('');
        	var id = $('option:selected').val();
        	var emp_id = "<?= $emp_id ?>";

         if (id != '0') {
        	$.ajax({
            	type: "POST",
            	url: "set_measures/edit_measures",
            	data: {'mainID' : id, 'empID' : emp_id},
            	success: function(data)
            	{
                	var arr = data ;
                	var i;
                	var select = document.getElementById("unitid2");
                	for(i = 0; i < arr.length; i++)
                	{
                    	var option = document.createElement('option');
                    	option.value = arr[i].id;
                    	option.text = arr[i].SubActivityName;
                    	select.add(option, i);
                	}
                	 $('#unitid2').prepend('<option value="' + 0 + '">' + 'Select Sub-activity' + '</option>');
                	 $('#unitid2').val('0');
              	}

          	})
        }
      	});

  	});

</script>

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

$(document).on('click','#disable0',function(){

     var $this=$(this);

     $this.prop('id','enable0');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable0").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis0').text('').append(put);

	 var state_text = $('.state0').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state0').text('').append(input2);

	 });



	$(document).on('click','#enable0',function(){

	     var $this=$(this);

	      $this.prop('id','disable0');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable0").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis0').text('').append(put);

	 	   var state_text = $('.state0').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state0').text('').append(input2);

	 });



	$(document).on('click','#disable1',function(){

     var $this=$(this);

     $this.prop('id','enable1');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable1").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis1').text('').append(put);

	 var state_text = $('.state1').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state1').text('').append(input2);

	 });



	$(document).on('click','#enable1',function(){

	     var $this=$(this);

	      $this.prop('id','disable1');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable1").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis1').text('').append(put);

	 	   var state_text = $('.state1').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state1').text('').append(input2);

	 });



	$(document).on('click','#disable2',function(){

     var $this=$(this);

     $this.prop('id','enable2');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable2").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis2').text('').append(put);

	 var state_text = $('.state2').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state2').text('').append(input2);

	 });



	$(document).on('click','#enable2',function(){

	     var $this=$(this);

	      $this.prop('id','disable2');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable2").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis2').text('').append(put);

	 	   var state_text = $('.state2').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state2').text('').append(input2);

	 });



	$(document).on('click','#disable3',function(){

     var $this=$(this);

     $this.prop('id','enable3');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable3").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis3').text('').append(put);

	 var state_text = $('.state3').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state3').text('').append(input2);

	 });



	$(document).on('click','#enable3',function(){

	     var $this=$(this);

	      $this.prop('id','disable3');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable3").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis3').text('').append(put);

	 	   var state_text = $('.state3').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state3').text('').append(input2);

	 });



	$(document).on('click','#disable4',function(){

     var $this=$(this);

     $this.prop('id','enable4');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable4").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis4').text('').append(put);

	 var state_text = $('.state4').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state4').text('').append(input2);

	 });



	$(document).on('click','#enable4',function(){

	     var $this=$(this);

	      $this.prop('id','disable4');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable4").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis4').text('').append(put);

	 	   var state_text = $('.state4').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state4').text('').append(input2);

	 });





	$(document).on('click','#disable5',function(){

     var $this=$(this);

     $this.prop('id','enable5');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable5").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis5').text('').append(put);

	 var state_text = $('.state5').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state5').text('').append(input2);

	 });



	$(document).on('click','#enable5',function(){

	     var $this=$(this);

	      $this.prop('id','disable5');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable5").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis5').text('').append(put);

	 	   var state_text = $('.state5').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state5').text('').append(input2);

	 });



	$(document).on('click','#disable6',function(){

     var $this=$(this);

     $this.prop('id','enable6');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable6").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis6').text('').append(put);

	 var state_text = $('.state6').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state6').text('').append(input2);

	 });



	$(document).on('click','#enable6',function(){

	     var $this=$(this);

	      $this.prop('id','disable6');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable6").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis6').text('').append(put);

	 	   var state_text = $('.state6').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state6').text('').append(input2);

	 });



	$(document).on('click','#disable7',function(){

     var $this=$(this);

     $this.prop('id','enable7');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable7").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis7').text('').append(put);

	 var state_text = $('.state7').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state7').text('').append(input2);

	 });



	$(document).on('click','#enable7',function(){

	     var $this=$(this);

	      $this.prop('id','disable7');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable7").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis7').text('').append(put);

	 	   var state_text = $('.state7').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state7').text('').append(input2);

	 });



	$(document).on('click','#disable8',function(){

     var $this=$(this);

     $this.prop('id','enable8');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable8").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis8').text('').append(put);

	 var state_text = $('.state8').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state8').text('').append(input2);

	 });



	$(document).on('click','#enable8',function(){

	     var $this=$(this);

	      $this.prop('id','disable8');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable8").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis8').text('').append(put);

	 	   var state_text = $('.state8').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state8').text('').append(input2);

	 });



	$(document).on('click','#disable9',function(){

     var $this=$(this);

     $this.prop('id','enable9');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable9").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis9').text('').append(put);

	 var state_text = $('.state9').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state9').text('').append(input2);

	 });



	$(document).on('click','#enable9',function(){

	     var $this=$(this);

	      $this.prop('id','disable9');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable9").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis9').text('').append(put);

	 	   var state_text = $('.state9').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state9').text('').append(input2);

	 });



	$(document).on('click','#disable10',function(){

     var $this=$(this);

     $this.prop('id','enable10');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable10").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis10').text('').append(put);

	 var state_text = $('.state10').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state10').text('').append(input2);

	 });



	$(document).on('click','#enable10',function(){

	     var $this=$(this);

	      $this.prop('id','disable10');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable10").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis10').text('').append(put);

	 	   var state_text = $('.state10').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state10').text('').append(input2);

	 });



	$(document).on('click','#disable11',function(){

     var $this=$(this);

     $this.prop('id','enable11');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable11").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis11').text('').append(put);

	 var state_text = $('.state11').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state11').text('').append(input2);

	 });



	$(document).on('click','#enable11',function(){

	     var $this=$(this);

	      $this.prop('id','disable11');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable11").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis11').text('').append(put);

	 	   var state_text = $('.state11').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state11').text('').append(input2);

	 });


	$(document).on('click','#disable12',function(){

     var $this=$(this);

     $this.prop('id','enable12');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable12").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis12').text('').append(put);

	 var state_text = $('.state12').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state12').text('').append(input2);

	 });



	$(document).on('click','#enable12',function(){

	     var $this=$(this);

	      $this.prop('id','disable12');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable12").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis12').text('').append(put);

	 	   var state_text = $('.state12').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state12').text('').append(input2);

	 });

	$(document).on('click','#disable13',function(){

     var $this=$(this);

     $this.prop('id','enable13');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable13").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis13').text('').append(put);

	 var state_text = $('.state13').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state13').text('').append(input2);

	 });



	$(document).on('click','#enable13',function(){

	     var $this=$(this);

	      $this.prop('id','disable13');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable13").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis13').text('').append(put);

	 	   var state_text = $('.state13').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state13').text('').append(input2);

	 });

	$(document).on('click','#disable14',function(){

     var $this=$(this);

     $this.prop('id','enable14');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable14").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis14').text('').append(put);

	 var state_text = $('.state14').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state14').text('').append(input2);

	 });



	$(document).on('click','#enable14',function(){

	     var $this=$(this);

	      $this.prop('id','disable14');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable14").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis14').text('').append(put);

	 	   var state_text = $('.state14').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state14').text('').append(input2);

	 });

	$(document).on('click','#disable15',function(){

     var $this=$(this);

     $this.prop('id','enable15');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable15").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis15').text('').append(put);

	 var state_text = $('.state15').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state15').text('').append(input2);

	 });



	$(document).on('click','#enable15',function(){

	     var $this=$(this);

	      $this.prop('id','disable15');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable15").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis15').text('').append(put);

	 	   var state_text = $('.state15').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state15').text('').append(input2);

	 });

	$(document).on('click','#disable16',function(){

     var $this=$(this);

     $this.prop('id','enable16');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable16").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis16').text('').append(put);

	 var state_text = $('.state16').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state16').text('').append(input2);

	 });



	$(document).on('click','#enable16',function(){

	     var $this=$(this);

	      $this.prop('id','disable16');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable16").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis16').text('').append(put);

	 	   var state_text = $('.state16').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state16').text('').append(input2);

	 });

	$(document).on('click','#disable17',function(){

     var $this=$(this);

     $this.prop('id','enable17');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable17").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis17').text('').append(put);

	 var state_text = $('.state17').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state17').text('').append(input2);

	 });



	$(document).on('click','#enable17',function(){

	     var $this=$(this);

	      $this.prop('id','disable17');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable17").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis17').text('').append(put);

	 	   var state_text = $('.state17').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state17').text('').append(input2);

	 });

	$(document).on('click','#disable18',function(){

     var $this=$(this);

     $this.prop('id','enable18');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable18").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis18').text('').append(put);

	 var state_text = $('.state18').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state18').text('').append(input2);

	 });



	$(document).on('click','#enable18',function(){

	     var $this=$(this);

	      $this.prop('id','disable18');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable18").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis18').text('').append(put);

	 	   var state_text = $('.state18').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state18').text('').append(input2);

	 });

	$(document).on('click','#disable19',function(){

     var $this=$(this);

     $this.prop('id','enable19');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable19").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis19').text('').append(put);

	 var state_text = $('.state19').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state19').text('').append(input2);

	 });



	$(document).on('click','#enable19',function(){

	     var $this=$(this);

	      $this.prop('id','disable19');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable19").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis19').text('').append(put);

	 	   var state_text = $('.state19').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state19').text('').append(input2);

	 });

	$(document).on('click','#disable20',function(){

     var $this=$(this);

     $this.prop('id','enable20');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable20").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis20').text('').append(put);

	 var state_text = $('.state20').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state20').text('').append(input2);

	 });



	$(document).on('click','#enable20',function(){

	     var $this=$(this);

	      $this.prop('id','disable20');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable20").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis20').text('').append(put);

	 	   var state_text = $('.state20').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state20').text('').append(input2);

	 });

	$(document).on('click','#disable21',function(){

     var $this=$(this);

     $this.prop('id','enable21');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable21").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis21').text('').append(put);

	 var state_text = $('.state21').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state21').text('').append(input2);

	 });



	$(document).on('click','#enable21',function(){

	     var $this=$(this);

	      $this.prop('id','disable21');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable21").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis21').text('').append(put);

	 	   var state_text = $('.state21').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state21').text('').append(input2);

	 });

	$(document).on('click','#disable22',function(){

     var $this=$(this);

     $this.prop('id','enable22');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable22").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis22').text('').append(put);

	 var state_text = $('.state22').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state22').text('').append(input2);

	 });



	$(document).on('click','#enable22',function(){

	     var $this=$(this);

	      $this.prop('id','disable22');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable22").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis22').text('').append(put);

	 	   var state_text = $('.state22').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state22').text('').append(input2);

	 });

	$(document).on('click','#disable23',function(){

     var $this=$(this);

     $this.prop('id','enable23');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable23").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis23').text('').append(put);

	 var state_text = $('.state23').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state23').text('').append(input2);

	 });



	$(document).on('click','#enable23',function(){

	     var $this=$(this);

	      $this.prop('id','disable23');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable23").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis23').text('').append(put);

	 	   var state_text = $('.state23').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state23').text('').append(input2);

	 });

	$(document).on('click','#disable24',function(){

     var $this=$(this);

     $this.prop('id','enable24');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable24").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis24').text('').append(put);

	 var state_text = $('.state24').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state24').text('').append(input2);

	 });



	$(document).on('click','#enable24',function(){

	     var $this=$(this);

	      $this.prop('id','disable24');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable24").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis24').text('').append(put);

	 	   var state_text = $('.state24').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state24').text('').append(input2);

	 });

	$(document).on('click','#disable25',function(){

     var $this=$(this);

     $this.prop('id','enable25');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable25").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis25').text('').append(put);

	 var state_text = $('.state25').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state25').text('').append(input2);

	 });



	$(document).on('click','#enable25',function(){

	     var $this=$(this);

	      $this.prop('id','disable25');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable25").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis25').text('').append(put);

	 	   var state_text = $('.state25').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state25').text('').append(input2);

	 });

	$(document).on('click','#disable26',function(){

     var $this=$(this);

     $this.prop('id','enable26');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable26").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis26').text('').append(put);

	 var state_text = $('.state26').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state26').text('').append(input2);

	 });



	$(document).on('click','#enable26',function(){

	     var $this=$(this);

	      $this.prop('id','disable26');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable26").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis26').text('').append(put);

	 	   var state_text = $('.state26').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state26').text('').append(input2);

	 });

	$(document).on('click','#disable27',function(){

     var $this=$(this);

     $this.prop('id','enable27');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable27").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis27').text('').append(put);

	 var state_text = $('.state27').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state27').text('').append(input2);

	 });



	$(document).on('click','#enable27',function(){

	     var $this=$(this);

	      $this.prop('id','disable27');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable27").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis27').text('').append(put);

	 	   var state_text = $('.state27').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state27').text('').append(input2);

	 });

	$(document).on('click','#disable28',function(){

     var $this=$(this);

     $this.prop('id','enable28');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable28").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis28').text('').append(put);

	 var state_text = $('.state28').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state28').text('').append(input2);

	 });



	$(document).on('click','#enable28',function(){

	     var $this=$(this);

	      $this.prop('id','disable28');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable28").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis28').text('').append(put);

	 	   var state_text = $('.state28').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state28').text('').append(input2);

	 });

	$(document).on('click','#disable29',function(){

     var $this=$(this);

     $this.prop('id','enable29');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable29").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis29').text('').append(put);

	 var state_text = $('.state29').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state29').text('').append(input2);

	 });



	$(document).on('click','#enable29',function(){

	     var $this=$(this);

	      $this.prop('id','disable29');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable29").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis29').text('').append(put);

	 	   var state_text = $('.state29').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state29').text('').append(input2);

	 });

	$(document).on('click','#disable30',function(){

     var $this=$(this);

     $this.prop('id','enable30');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable30").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis30').text('').append(put);

	 var state_text = $('.state30').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state30').text('').append(input2);

	 });



	$(document).on('click','#enable30',function(){

	     var $this=$(this);

	      $this.prop('id','disable30');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable30").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis30').text('').append(put);

	 	   var state_text = $('.state30').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state30').text('').append(input2);

	 });

	$(document).on('click','#disable31',function(){

     var $this=$(this);

     $this.prop('id','enable31');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable31").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis31').text('').append(put);

	 var state_text = $('.state31').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state31').text('').append(input2);

	 });



	$(document).on('click','#enable31',function(){

	     var $this=$(this);

	      $this.prop('id','disable31');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable31").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis31').text('').append(put);

	 	   var state_text = $('.state31').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state31').text('').append(input2);

	 });

	$(document).on('click','#disable32',function(){

     var $this=$(this);

     $this.prop('id','enable32');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable32").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis32').text('').append(put);

	 var state_text = $('.state32').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state32').text('').append(input2);

	 });



	$(document).on('click','#enable32',function(){

	     var $this=$(this);

	      $this.prop('id','disable32');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable32").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis32').text('').append(put);

	 	   var state_text = $('.state32').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state32').text('').append(input2);

	 });

	$(document).on('click','#disable33',function(){

     var $this=$(this);

     $this.prop('id','enable33');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable33").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis33').text('').append(put);

	 var state_text = $('.state33').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state33').text('').append(input2);

	 });



	$(document).on('click','#enable33',function(){

	     var $this=$(this);

	      $this.prop('id','disable33');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable33").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis33').text('').append(put);

	 	   var state_text = $('.state33').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state33').text('').append(input2);

	 });

	$(document).on('click','#disable34',function(){

     var $this=$(this);

     $this.prop('id','enable34');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable34").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis34').text('').append(put);

	 var state_text = $('.state34').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state34').text('').append(input2);

	 });



	$(document).on('click','#enable34',function(){

	     var $this=$(this);

	      $this.prop('id','disable34');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable34").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis34').text('').append(put);

	 	   var state_text = $('.state34').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state34').text('').append(input2);

	 });

	$(document).on('click','#disable35',function(){

     var $this=$(this);

     $this.prop('id','enable35');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable35").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis35').text('').append(put);

	 var state_text = $('.state35').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state35').text('').append(input2);

	 });



	$(document).on('click','#enable35',function(){

	     var $this=$(this);

	      $this.prop('id','disable35');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable35").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis35').text('').append(put);

	 	   var state_text = $('.state35').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state35').text('').append(input2);

	 });

	$(document).on('click','#disable36',function(){

     var $this=$(this);

     $this.prop('id','enable36');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable36").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis36').text('').append(put);

	 var state_text = $('.state36').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state36').text('').append(input2);

	 });



	$(document).on('click','#enable36',function(){

	     var $this=$(this);

	      $this.prop('id','disable36');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable36").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis36').text('').append(put);

	 	   var state_text = $('.state36').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state36').text('').append(input2);

	 });

	$(document).on('click','#disable37',function(){

     var $this=$(this);

     $this.prop('id','enable37');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable37").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis37').text('').append(put);

	 var state_text = $('.state37').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state37').text('').append(input2);

	 });



	$(document).on('click','#enable37',function(){

	     var $this=$(this);

	      $this.prop('id','disable37');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable37").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis37').text('').append(put);

	 	   var state_text = $('.state37').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state37').text('').append(input2);

	 });

	$(document).on('click','#disable38',function(){

     var $this=$(this);

     $this.prop('id','enable38');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable38").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis38').text('').append(put);

	 var state_text = $('.state38').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state38').text('').append(input2);

	 });



	$(document).on('click','#enable38',function(){

	     var $this=$(this);

	      $this.prop('id','disable38');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable38").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis38').text('').append(put);

	 	   var state_text = $('.state38').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state38').text('').append(input2);

	 });

	$(document).on('click','#disable39',function(){

     var $this=$(this);

     $this.prop('id','enable39');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable39").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis39').text('').append(put);

	 var state_text = $('.state39').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state39').text('').append(input2);

	 });



	$(document).on('click','#enable39',function(){

	     var $this=$(this);

	      $this.prop('id','disable39');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable39").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis39').text('').append(put);

	 	   var state_text = $('.state39').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state39').text('').append(input2);

	 });

	$(document).on('click','#disable40',function(){

     var $this=$(this);

     $this.prop('id','enable40');

     $this.val("Enable"); //OR  $this.val("Hide") //if you are using input type="button"

     $("#enable40").attr('class', 'btn btn-success');

     var put = $('<input class = "form-control" type="hidden" name="state[]" value="Disable" />')

	 $('.dis40').text('').append(put);

	 var state_text = $('.state40').text();

	 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

	 $('.state40').text('').append(input2);

	 });



	$(document).on('click','#enable40',function(){

	     var $this=$(this);

	      $this.prop('id','disable40');

	      $this.val("Disable"); //OR  $this.val("Hide") //if you are using input type="button"

	      $("#disable40").attr('class', 'btn btn-danger');

	      var put = $('<input class = "form-control" type="hidden" name="state[]" value="Enable" />')

	 	  $('.dis40').text('').append(put);

	 	   var state_text = $('.state40').text();

		 var input2 = $('<input class = "form-control" type="hidden" name="state_id[]" value="'+ state_text +'" />')

		 $('.state40').text('').append(input2);

	 });



</script>



<script type="text/javascript">


//$('#unitid').on('change', function(e){
    //$(this).closest('form').submit();
//});


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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info0').text('').append(input);

		    var text1 = $('.text-hidden0').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info1').text('').append(input);

		    var text1 = $('.text-hidden1').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info2').text('').append(input);

		    var text1 = $('.text-hidden2').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info3').text('').append(input);

		    var text1 = $('.text-hidden3').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info4').text('').append(input);

		    var text1 = $('.text-hidden4').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info5').text('').append(input);

		    var text1 = $('.text-hidden5').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info6').text('').append(input);

		    var text1 = $('.text-hidden6').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info7').text('').append(input);

		    var text1 = $('.text-hidden7').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info8').text('').append(input);

		    var text1 = $('.text-hidden8').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info9').text('').append(input);

		    var text1 = $('.text-hidden9').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info10').text('').append(input);

		    var text1 = $('.text-hidden10').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info11').text('').append(input);

		    var text1 = $('.text-hidden11').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

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

		$('#edit12').click(function() {

		    var text = $('.text-info12').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info12').text('').append(input);

		    var text1 = $('.text-hidden12').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden12').text('').append(input1);

		    var text2 = $('.text-type12').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect12" name="measure_types[]" value="option">')

		     $('.text-type12').text('').append(input2);
		      var x = document.getElementById("mySelect12");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit13').click(function() {

		    var text = $('.text-info13').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info13').text('').append(input);

		    var text1 = $('.text-hidden13').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden13').text('').append(input1);

		    var text2 = $('.text-type13').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect13" name="measure_types[]" value="option">')

		     $('.text-type13').text('').append(input2);
		      var x = document.getElementById("mySelect13");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

			$('#edit14').click(function() {

		    var text = $('.text-info14').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info14').text('').append(input);

		    var text1 = $('.text-hidden14').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden14').text('').append(input1);

		    var text2 = $('.text-type14').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect14" name="measure_types[]" value="option">')

		     $('.text-type14').text('').append(input2);
		      var x = document.getElementById("mySelect14");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

				$('#edit15').click(function() {

		    var text = $('.text-info15').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info15').text('').append(input);

		    var text1 = $('.text-hidden15').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden15').text('').append(input1);

		    var text2 = $('.text-type15').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect15" name="measure_types[]" value="option">')

		     $('.text-type15').text('').append(input2);
		      var x = document.getElementById("mySelect15");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit16').click(function() {

		    var text = $('.text-info16').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info16').text('').append(input);

		    var text1 = $('.text-hidden16').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden16').text('').append(input1);

		    var text2 = $('.text-type16').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect16" name="measure_types[]" value="option">')

		     $('.text-type16').text('').append(input2);
		      var x = document.getElementById("mySelect16");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit17').click(function() {

		    var text = $('.text-info17').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info17').text('').append(input);

		    var text1 = $('.text-hidden17').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden17').text('').append(input1);

		    var text2 = $('.text-type17').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect17" name="measure_types[]" value="option">')

		     $('.text-type17').text('').append(input2);
		      var x = document.getElementById("mySelect17");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit18').click(function() {

		    var text = $('.text-info18').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info18').text('').append(input);

		    var text1 = $('.text-hidden18').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden18').text('').append(input1);

		    var text2 = $('.text-type18').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect18" name="measure_types[]" value="option">')

		     $('.text-type18').text('').append(input2);
		      var x = document.getElementById("mySelect18");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit19').click(function() {

		    var text = $('.text-info19').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info19').text('').append(input);

		    var text1 = $('.text-hidden19').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden19').text('').append(input1);

		    var text2 = $('.text-type19').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect19" name="measure_types[]" value="option">')

		     $('.text-type19').text('').append(input2);
		      var x = document.getElementById("mySelect19");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit20').click(function() {

		    var text = $('.text-info20').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info20').text('').append(input);

		    var text1 = $('.text-hidden20').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden20').text('').append(input1);

		    var text2 = $('.text-type20').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect20" name="measure_types[]" value="option">')

		     $('.text-type20').text('').append(input2);
		      var x = document.getElementById("mySelect20");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit21').click(function() {

		    var text = $('.text-info21').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info21').text('').append(input);

		    var text1 = $('.text-hidden21').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden21').text('').append(input1);

		    var text2 = $('.text-type21').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect21" name="measure_types[]" value="option">')

		     $('.text-type21').text('').append(input2);
		      var x = document.getElementById("mySelect21");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit22').click(function() {

		    var text = $('.text-info22').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info22').text('').append(input);

		    var text1 = $('.text-hidden22').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden22').text('').append(input1);

		    var text2 = $('.text-type22').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect22" name="measure_types[]" value="option">')

		     $('.text-type22').text('').append(input2);
		      var x = document.getElementById("mySelect22");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit23').click(function() {

		    var text = $('.text-info23').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info23').text('').append(input);

		    var text1 = $('.text-hidden23').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden23').text('').append(input1);

		    var text2 = $('.text-type23').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect23" name="measure_types[]" value="option">')

		     $('.text-type23').text('').append(input2);
		      var x = document.getElementById("mySelect23");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit24').click(function() {

		    var text = $('.text-info24').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info24').text('').append(input);

		    var text1 = $('.text-hidden24').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden24').text('').append(input1);

		    var text2 = $('.text-type24').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect24" name="measure_types[]" value="option">')

		     $('.text-type24').text('').append(input2);
		      var x = document.getElementById("mySelect24");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit25').click(function() {

		    var text = $('.text-info25').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info25').text('').append(input);

		    var text1 = $('.text-hidden25').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden25').text('').append(input1);

		    var text2 = $('.text-type25').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect25" name="measure_types[]" value="option">')

		     $('.text-type25').text('').append(input2);
		      var x = document.getElementById("mySelect25");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit26').click(function() {

		    var text = $('.text-info26').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info26').text('').append(input);

		    var text1 = $('.text-hidden26').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden26').text('').append(input1);

		    var text2 = $('.text-type26').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect26" name="measure_types[]" value="option">')

		     $('.text-type26').text('').append(input2);
		      var x = document.getElementById("mySelect26");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit26').click(function() {

		    var text = $('.text-info26').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info26').text('').append(input);

		    var text1 = $('.text-hidden26').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden26').text('').append(input1);

		    var text2 = $('.text-type26').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect26" name="measure_types[]" value="option">')

		     $('.text-type26').text('').append(input2);
		      var x = document.getElementById("mySelect26");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit27').click(function() {

		    var text = $('.text-info27').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info27').text('').append(input);

		    var text1 = $('.text-hidden27').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden27').text('').append(input1);

		    var text2 = $('.text-type27').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect27" name="measure_types[]" value="option">')

		     $('.text-type27').text('').append(input2);
		      var x = document.getElementById("mySelect27");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit28').click(function() {

		    var text = $('.text-info28').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info28').text('').append(input);

		    var text1 = $('.text-hidden28').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden28').text('').append(input1);

		    var text2 = $('.text-type28').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect28" name="measure_types[]" value="option">')

		     $('.text-type28').text('').append(input2);
		      var x = document.getElementById("mySelect28");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit29').click(function() {

		    var text = $('.text-info29').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info29').text('').append(input);

		    var text1 = $('.text-hidden29').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden29').text('').append(input1);

		    var text2 = $('.text-type29').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect29" name="measure_types[]" value="option">')

		     $('.text-type29').text('').append(input2);
		      var x = document.getElementById("mySelect29");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit30').click(function() {

		    var text = $('.text-info30').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info30').text('').append(input);

		    var text1 = $('.text-hidden30').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden30').text('').append(input1);

		    var text2 = $('.text-type30').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect30" name="measure_types[]" value="option">')

		     $('.text-type30').text('').append(input2);
		      var x = document.getElementById("mySelect30");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit31').click(function() {

		    var text = $('.text-info31').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info31').text('').append(input);

		    var text1 = $('.text-hidden31').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden31').text('').append(input1);

		    var text2 = $('.text-type31').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect31" name="measure_types[]" value="option">')

		     $('.text-type31').text('').append(input2);
		      var x = document.getElementById("mySelect31");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit32').click(function() {

		    var text = $('.text-info32').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info32').text('').append(input);

		    var text1 = $('.text-hidden32').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden32').text('').append(input1);

		    var text2 = $('.text-type32').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect32" name="measure_types[]" value="option">')

		     $('.text-type32').text('').append(input2);
		      var x = document.getElementById("mySelect32");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit33').click(function() {

		    var text = $('.text-info33').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info33').text('').append(input);

		    var text1 = $('.text-hidden33').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden33').text('').append(input1);

		    var text2 = $('.text-type33').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect33" name="measure_types[]" value="option">')

		     $('.text-type33').text('').append(input2);
		      var x = document.getElementById("mySelect33");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit34').click(function() {

		    var text = $('.text-info34').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info34').text('').append(input);

		    var text1 = $('.text-hidden34').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden34').text('').append(input1);

		    var text2 = $('.text-type34').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect34" name="measure_types[]" value="option">')

		     $('.text-type34').text('').append(input2);
		      var x = document.getElementById("mySelect34");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit35').click(function() {

		    var text = $('.text-info35').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info35').text('').append(input);

		    var text1 = $('.text-hidden35').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden35').text('').append(input1);

		    var text2 = $('.text-type35').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect35" name="measure_types[]" value="option">')

		     $('.text-type35').text('').append(input2);
		      var x = document.getElementById("mySelect35");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit36').click(function() {

		    var text = $('.text-info36').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info36').text('').append(input);

		    var text1 = $('.text-hidden36').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden36').text('').append(input1);

		    var text2 = $('.text-type36').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect36" name="measure_types[]" value="option">')

		     $('.text-type36').text('').append(input2);
		      var x = document.getElementById("mySelect36");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit37').click(function() {

		    var text = $('.text-info37').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info37').text('').append(input);

		    var text1 = $('.text-hidden37').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden37').text('').append(input1);

		    var text2 = $('.text-type37').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect37" name="measure_types[]" value="option">')

		     $('.text-type37').text('').append(input2);
		      var x = document.getElementById("mySelect37");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit38').click(function() {

		    var text = $('.text-info38').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info38').text('').append(input);

		    var text1 = $('.text-hidden38').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden38').text('').append(input1);

		    var text2 = $('.text-type38').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect38" name="measure_types[]" value="option">')

		     $('.text-type38').text('').append(input2);
		      var x = document.getElementById("mySelect38");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});
		$('#edit39').click(function() {

		    var text = $('.text-info39').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info39').text('').append(input);

		    var text1 = $('.text-hidden39').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden39').text('').append(input1);

		    var text2 = $('.text-type39').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect39" name="measure_types[]" value="option">')

		     $('.text-type39').text('').append(input2);
		      var x = document.getElementById("mySelect39");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});

		$('#edit40').click(function() {

		    var text = $('.text-info40').text();

		    var input = $('<input class = "form-control" type="text" name="measures[]" value="'+ text +'" />')

		    $('.text-info40').text('').append(input);

		    var text1 = $('.text-hidden40').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="measures_id[]" value="'+ text1 +'" />')

		    $('.text-hidden40').text('').append(input1);

		    var text2 = $('.text-type40').text();

		    var input2 = $('<select class= "btn btn-default dropdown-toggle form-control" id="mySelect40" name="measure_types[]" value="option">')

		     $('.text-type40').text('').append(input2);
		      var x = document.getElementById("mySelect40");
    			var option = document.createElement("option");
    			option.text = "Summation/Total";
    			x.add(option,x[0]);
    			var option2 = document.createElement("option");
    			option2.text = "Average";	
    			x.add(option2,x[1]);



		});



	



</script>

@stop