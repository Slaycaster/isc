@extends("layout-employee")

@section("content")



<head>

    <title>Edit Activities | PNP Scorecard System</title>

</head>



<div class="container" style=" margin-bottom:4%">

	<div class="label_white">

	<div class="col-md-12" style="margin-bottom:15px">

			<center><h1>Scorecard - Edit Sub Activities </h1></center>

	</div>



	</div>

	<div class="col-md-12">

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
								     <div style="color:white">{{ Form::label('main_id', 'Main Activity:') }} <h2>{{$id}}</h2></div>
								@endforeach
                       
                             @endif
                            @if($unitoffices->state == 'Enable')
                            	

							 {{ Form::open(array('url' => 'employee/postset_activities', 'method' => 'post')) }}

							                      

							                        <div style="color:white">{{ Form::label('main_id', 'Main Activity:') }}</div>

							                        <div style='color:black'>{{ Form::select('main_id', $main_id, Input::get('main_id'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'unitid', 'tabindex' => '2')) }}</div>

							                        {{Form::hidden('empid',$id)}}

							 {{Form::close()}}
                                 
                            @endif
                    
                                @endif
                            @endif
                            <?php break; ?>
                        @endforeach              
                    @endforeach
                 @endif
            @endforeach
                  





<br><br>

{{ Form::open(array('url' => 'employee/postedit_activities', 'method' => 'post')) }}


 {{Form::hidden('main', Input::get('main'))}}


   <div class = "col-md-12">

        <div class="panel panel-primary">

              <div class="panel-heading" id = "up">

                  <strong>Sub-Activities</strong>

              </div>

             <div class="panel-body">
             @if (Session::has('message'))
			    <div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif

              <table class="table" id="example">

                  <thead>

                      <tr class="filters">       

                          <th>Sub Activity Name</th>

                          <th>Actions</th>

                      </tr>

                  </thead>

                  <tbody>

                 <?php

				      $counter = 0;

				                            

				    ?>

                 

	                  @foreach ($sub_activities as $sub_activity)

	                        <tr>





	                            <td style='color:black'>

	                           		{{ Form::label('sub_activity[]', $sub_activity->SubActivityName,  array('class' =>'text-info'.$counter, 'style' => 'color:black'))}}

	                           		{{ Form::label('subactivity[]', $sub_activity->SubActivityID,  array('class' =>'text-hidden'.$counter, 'style' => 'color:white'))}}

	                    		</td>



	                            <td>

	                

	                              <div class="controls" style="margin-bottom:3px">

								        {{ HTML::link('#up', 'Edit', array('id' => 'edit'.$counter, 'class' => 'btn btn-info'))}}

								    </div>

						

								    @if($sub_activity->TerminationDate == null)

									    {{ Form::input('button', 'state', 'Disable' ,array('id' =>'disable'.$counter, 'class' => 'btn btn-danger')) }}

									    {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

									    {{ Form::label('state_id[]', $sub_activity->SubActivityID,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

								    @else

		                               {{ Form::input('button', 'state', 'Enable',array('id' =>'enable'.$counter, 'class' => 'btn btn-success')) }}

		                                {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

		                                {{ Form::label('state_id[]', $sub_activity->SubActivityID,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

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



$('#unitid').on('change', function(e){

    $(this).closest('form').submit();

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



</script>





</script>







<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>







<script type="text/javascript">



		

		$('#edit0').click(function() {

		    var text = $('.text-info0').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info0').text('').append(input);

		    var text1 = $('.text-hidden0').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden0').text('').append(input1);



		});



		$('#edit1').click(function() {

		    var text = $('.text-info1').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info1').text('').append(input);

		    var text1 = $('.text-hidden1').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden1').text('').append(input1);



		});



		$('#edit2').click(function() {

		    var text = $('.text-info2').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info2').text('').append(input);

		    var text1 = $('.text-hidden2').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden2').text('').append(input1);



		});



		$('#edit3').click(function() {

		    var text = $('.text-info3').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info3').text('').append(input);

		    var text1 = $('.text-hidden3').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden3').text('').append(input1);



		});



		$('#edit4').click(function() {

		    var text = $('.text-info4').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info4').text('').append(input);

		    var text1 = $('.text-hidden4').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden4').text('').append(input1);



		});



		$('#edit6').click(function() {

		    var text = $('.text-info6').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info6').text('').append(input);

		    var text1 = $('.text-hidden6').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden6').text('').append(input1);



		});

		$('#edit7').click(function() {

		    var text = $('.text-info7').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info7').text('').append(input);

		    var text1 = $('.text-hidden7').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden7').text('').append(input1);



		});

		$('#edit8').click(function() {

		    var text = $('.text-info8').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info8').text('').append(input);

		    var text1 = $('.text-hidden8').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden8').text('').append(input1);



		});

		$('#edit9').click(function() {

		    var text = $('.text-info9').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info9').text('').append(input);

		    var text1 = $('.text-hidden9').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden9').text('').append(input1);



		});

		$('#edit10').click(function() {

		    var text = $('.text-info10').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info10').text('').append(input);

		    var text1 = $('.text-hidden10').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden10').text('').append(input1);



		});

		$('#edit11').click(function() {

		    var text = $('.text-info11').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info11').text('').append(input);

		    var text1 = $('.text-hidden11').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden11').text('').append(input1);



		});

		$('#edit12').click(function() {

		    var text = $('.text-info12').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info12').text('').append(input);

		    var text1 = $('.text-hidden12').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden12').text('').append(input1);



		});
		$('#edit13').click(function() {

		    var text = $('.text-info13').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info13').text('').append(input);

		    var text1 = $('.text-hidden13').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden13').text('').append(input1);



		});
		$('#edit14').click(function() {

		    var text = $('.text-info14').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info14').text('').append(input);

		    var text1 = $('.text-hidden14').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden14').text('').append(input1);



		});
		$('#edit15').click(function() {

		    var text = $('.text-info15').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info15').text('').append(input);

		    var text1 = $('.text-hidden15').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden15').text('').append(input1);



		});
		$('#edit16').click(function() {

		    var text = $('.text-info16').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info16').text('').append(input);

		    var text1 = $('.text-hidden16').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden16').text('').append(input1);



		});
		$('#edit17').click(function() {

		    var text = $('.text-info17').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info17').text('').append(input);

		    var text1 = $('.text-hidden17').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden17').text('').append(input1);



		});
		$('#edit18').click(function() {

		    var text = $('.text-info18').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info18').text('').append(input);

		    var text1 = $('.text-hidden18').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden18').text('').append(input1);



		});
		$('#edit19').click(function() {

		    var text = $('.text-info19').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info19').text('').append(input);

		    var text1 = $('.text-hidden19').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden19').text('').append(input1);



		});
		$('#edit20').click(function() {

		    var text = $('.text-info20').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info20').text('').append(input);

		    var text1 = $('.text-hidden20').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden20').text('').append(input1);



		});
		$('#edit21').click(function() {

		    var text = $('.text-info21').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info21').text('').append(input);

		    var text1 = $('.text-hidden21').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden21').text('').append(input1);



		});
		$('#edit22').click(function() {

		    var text = $('.text-info22').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info22').text('').append(input);

		    var text1 = $('.text-hidden22').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden22').text('').append(input1);



		});
		$('#edit23').click(function() {

		    var text = $('.text-info23').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info23').text('').append(input);

		    var text1 = $('.text-hidden23').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden23').text('').append(input1);



		});
		$('#edit24').click(function() {

		    var text = $('.text-info24').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info24').text('').append(input);

		    var text1 = $('.text-hidden24').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden24').text('').append(input1);



		});
		$('#edit25').click(function() {

		    var text = $('.text-info25').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info25').text('').append(input);

		    var text1 = $('.text-hidden25').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden25').text('').append(input1);



		});
		$('#edit26').click(function() {

		    var text = $('.text-info26').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info26').text('').append(input);

		    var text1 = $('.text-hidden26').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden26').text('').append(input1);



		});
		$('#edit27').click(function() {

		    var text = $('.text-info27').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info27').text('').append(input);

		    var text1 = $('.text-hidden27').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden27').text('').append(input1);



		});
		$('#edit28').click(function() {

		    var text = $('.text-info28').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info28').text('').append(input);

		    var text1 = $('.text-hidden28').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden28').text('').append(input1);



		});
		$('#edit29').click(function() {

		    var text = $('.text-info29').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info29').text('').append(input);

		    var text1 = $('.text-hidden29').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden29').text('').append(input1);



		});
		$('#edit30').click(function() {

		    var text = $('.text-info30').text();

		    var input = $('<input class = "form-control" type="text" name="sub_activity[]" value="'+ text +'" />')

		    $('.text-info30').text('').append(input);

		    var text1 = $('.text-hidden30').text();

		    var input1 = $('<input class = "form-control" type="hidden" name="subactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden30').text('').append(input1);



		});




</script>







@stop