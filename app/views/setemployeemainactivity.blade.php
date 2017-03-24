@extends("layout")

@section("content")



<head>

    <title>Edit Main Activities | PNP Scorecard System</title>

</head>


<div class="label_white">
  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
    <h1>Edit Main Activities - {{ $PersonnelName }}</h1>
  </div>
</div>

	<div class="col-md-12">




@if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div>

    @endif

</div>



<div class = "row">



 




{{ Form::open(array('url' => 'posteditemployeemainactivity', 'method' => 'post')) }}

 

 {{Form::hidden('empid',$id)}}

   <div class = "col-md-12">

        <div class="panel panel-primary">

              <div class="panel-heading" id = "up">

                  <strong>Main-Activities</strong>

              </div>
           <div class="table-responsive">
             <div class="panel-body">

              <table class="table" id="example">

                  <thead>

                      <tr class="filters">       

                          <th>Main Activity Name</th>

                          <th>Actions</th>

                      </tr>

                  </thead>

                  <tbody>

                 <?php

				      $counter = 0;

				                            

				    ?>

                 

	                  @foreach ($main_activities as $main_activity)

	                        <tr>





	                            <td style='color:black'>

	                           		{{ Form::label('main_activity[]', $main_activity->MainActivityName,  array('class' =>'text-info'.$counter, 'style' => 'color:black'))}}

	                           		{{ Form::label('mainactivity[]', $main_activity->id,  array('class' =>'text-hidden'.$counter, 'style' => 'color:white'))}}

	                    		</td>



	                            <td>

	                              <div class="controls" style="margin-bottom:3px">

								        {{ HTML::link('#up', 'Edit', array('id' => 'edit'.$counter, 'class' => 'btn btn-info'))}}

								    </div>



								    @if($main_activity->TDate == null)

									    {{ Form::input('button', 'state', 'Disable' ,array('id' =>'disable'.$counter, 'class' => 'btn btn-danger')) }}

									    {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

									    {{ Form::label('state_id[]', $main_activity->id,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

								    @else

		                               {{ Form::input('button', 'state', 'Enable',array('id' =>'enable'.$counter, 'class' => 'btn btn-success')) }}

		                                {{ Form::label('state[]', '',  array('class' =>'dis'.$counter, 'style' => 'color:white'))}}

		                                {{ Form::label('state_id[]', $main_activity->id,  array('class' =>'state'.$counter, 'style' => 'color:white'))}}

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





</script>





<script type="text/javascript">



$('#unitid').on('change', function(e){

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

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info0').text('').append(input);

		    var text1 = $('.text-hidden0').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden0').text('').append(input1);



		});



		$('#edit1').click(function() {

		    var text = $('.text-info1').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info1').text('').append(input);

		    var text1 = $('.text-hidden1').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden1').text('').append(input1);



		});



		$('#edit2').click(function() {

		    var text = $('.text-info2').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info2').text('').append(input);

		    var text1 = $('.text-hidden2').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden2').text('').append(input1);



		});



		$('#edit3').click(function() {

		    var text = $('.text-info3').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info3').text('').append(input);

		    var text1 = $('.text-hidden3').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden3').text('').append(input1);



		});



		$('#edit4').click(function() {

		    var text = $('.text-info4').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info4').text('').append(input);

		    var text1 = $('.text-hidden4').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden4').text('').append(input1);



		});



		$('#edit6').click(function() {

		    var text = $('.text-info6').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info6').text('').append(input);

		    var text1 = $('.text-hidden6').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden6').text('').append(input1);



		});

		$('#edit7').click(function() {

		    var text = $('.text-info7').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info7').text('').append(input);

		    var text1 = $('.text-hidden7').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden7').text('').append(input1);



		});

		$('#edit8').click(function() {

		    var text = $('.text-info8').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info8').text('').append(input);

		    var text1 = $('.text-hidden8').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden8').text('').append(input1);



		});

		$('#edit9').click(function() {

		    var text = $('.text-info9').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info9').text('').append(input);

		    var text1 = $('.text-hidden9').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden9').text('').append(input1);



		});

		$('#edit10').click(function() {

		    var text = $('.text-info10').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info10').text('').append(input);

		    var text1 = $('.text-hidden10').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden10').text('').append(input1);



		});

		$('#edit11').click(function() {

		    var text = $('.text-info11').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info11').text('').append(input);

		    var text1 = $('.text-hidden11').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden11').text('').append(input1);



		});



</script>







@stop