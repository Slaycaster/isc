@extends("layout-unitadmin")
@section("content")
	

	
<div class="container">

	 <div class="col-md-12" style="margin-bottom:15px; color:white;">

    <center><div class="text_paragraph">

    <p style="font-size: 35px"><strong>Other Activities</strong></p>
    @foreach($employsname as $other_activity)
    <p style="font-size: 25px"><i>Other Sub-activity's Measures - {{$other_activity->RankCode}} {{$other_activity->EmpLastName}}, {{$other_activity->EmpFirstName}}</i></p>
    @endforeach
  </div></center>



    <hr>

    </div>
  <div class="row">
  	<div class="col-md-12">
  		<div class="panel panel-default">

      	<div class="panel-heading">

            <strong>Add Measures</strong>

        </div>

        <div class="panel-body">

          {{ Form::open(array('url' => 'UAEothermeasure/postAddOtherMeasure', 'method' => 'post')) }}
          {{Form::hidden('empid', $empid)}}
@if (Session::has('message'))

      <div class="alert alert-danger">{{ Session::get('message') }}</div><br>

    @endif

          
@if (Session::has('messages'))

      <div class="alert alert-danger">{{ Session::get('messages') }}</div><br>

    @endif
          <!--loob ng foreach fcker-->
 
                                      
@if (Session::has('mes'))

      <div class="alert alert-success">{{ Session::get('mes') }}</div><br>

    @endif
                                           

                           
                            <label>Sub-Activity :   {{$subs->OtherActivitiesName}}</label>
                           
                            {{ Form::hidden('sub_id', $subs->id) }}

                           

                            <div class="multi-field-wrapper">

                            <div class="row">

                              <div class="col-md-12">

                                <br>

                                <button type="button" class="add-field"><span class="glyphicon glyphicon-plus"></span>Add Measure</button>

                              </div>

                            </div>

                            <div class="row">

                                <br>

                                
                         <div class="multi-fields">

                                      <div class="multi-field">

                                         <div class="col-md-12">

                                          

                                            <label>Measure</label> 

                                            <input type="text" name="measure[]" class="form-control" autocomplete="off">

                                            <br>

                                         </div>

                                         

                                      </div>

                                   </div>


                             </div> 

                        </div>
              

 		    </div>

        <div class="panel-footer">

          <br>

          {{ Form::submit('Add Measure', array('class' => 'btn btn-lg btn-success')) }}

              {{Form::close()}}

        </div>

 		    <br>
</div>

</div>


{{ Form::open(array('url' => 'UAEothermeasure/postEditOtherMeasure', 'method' => 'post')) }}
{{Form::hidden('empid', $empid)}}
{{ Form::hidden('sub_id', $subs->id) }}
   <div class = "col-md-12">

        <div class="panel panel-primary">

              <div class="panel-heading" id="up">

                  <strong>Existing Measures</strong>

              </div>
              <div class = "table-responsive">
           <div class="panel-body">
             	<p style="font-size: 15px">Please check if you want the measure to appear in  Sub-Activity :  <strong>   {{$subs->OtherActivitiesName}} </strong></p>
             	<p style="font-size: 15px"><i>NOTE: You will do this every time you want this measure to appear in this sub-activity</i></p>
              <table class="table" id="example">

                  <thead>

                      <tr class="filters">       

                          <th>Measure Name</th>

                         <th>Add/Remove to Sub-activity</th>

                          <th>Edit Measure</th>


                      </tr>

                  </thead>

                  <tbody>

                 <?php

				      $counter = 0;

				                            

				    ?>

                 

	                  @foreach ($other_activities as $other)

	                        <tr>





	                            <td style='color:black'>

	                           		{{ Form::label('main_activity[]', $other->OtherActivitiesMeasureName,  array('class' =>'text-info'.$counter, 'style' => 'color:black'))}}

	                           		{{ Form::label('mainactivity[]', $other->id,  array('class' =>'text-hidden'.$counter, 'style' => 'color:white'))}}

	                    		</td>
	                    		@if ($other->MeasureDate == null )
	                    		<td style='color:black'>
	                    		{{Form::checkbox('check_id[]', $other->id, true, array('style' => 'width:25px; height:25px; '))}}
	                    		</td>
	                
	                    		@endif

	                    		@if ($other->MeasureDate != null )
	                    		<td style='color:black'>
	                    		{{Form::checkbox('check_id[]', $other->id, null, array('style' => 'width:25px; height:25px; '))}}
	                    		</td>
	                
	                    		@endif
	                            <td>

	                              <div class="controls" style="margin-bottom:3px">
	                          
								        {{ HTML::link('#up', 'Edit Measure', array('id' => 'edit'.$counter, 'class' => 'btn btn-info'))}}
								
								    
								       {{ Form::submit('Save',  array('class' => 'btn btn-success', 'name' => 'Edit', 'id' => 'welcomeDiv'.$counter, 'style' => 'display:none')) }}


								   

								    </div>

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

    		 <input class = 'btn btn-success' style='font-size:15px; padding-top:15px; padding-bottom:15px; margin-bottom: 30px' type="submit" name="Save" value="Apply to Sub-Activity">

    	</div>

    </div>



</div>
</div>

{{ Form::close() }}






<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

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
		

		$('#edit0').click(function() {


		    var text = $('.text-info0').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info0').text('').append(input);

		    var text1 = $('.text-hidden0').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden0').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv0').style.display = "block";




		});



		$('#edit1').click(function() {

		    var text = $('.text-info1').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info1').text('').append(input);

		    var text1 = $('.text-hidden1').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden1').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv1').style.display = "block";




		});



		$('#edit2').click(function() {

		    var text = $('.text-info2').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info2').text('').append(input);

		    var text1 = $('.text-hidden2').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden2').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv2').style.display = "block";





		});



		$('#edit3').click(function() {

		    var text = $('.text-info3').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info3').text('').append(input);

		    var text1 = $('.text-hidden3').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden3').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv3').style.display = "block";



		});



		$('#edit4').click(function() {

		    var text = $('.text-info4').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info4').text('').append(input);

		    var text1 = $('.text-hidden4').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden4').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv4').style.display = "block";



		});



		$('#edit6').click(function() {

		    var text = $('.text-info6').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info6').text('').append(input);

		    var text1 = $('.text-hidden6').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden6').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv5').style.display = "block";



		});

		$('#edit7').click(function() {

		    var text = $('.text-info7').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info7').text('').append(input);

		    var text1 = $('.text-hidden7').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden7').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv6').style.display = "block";



		});

		$('#edit8').click(function() {

		    var text = $('.text-info8').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info8').text('').append(input);

		    var text1 = $('.text-hidden8').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden8').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv7').style.display = "block";



		});

		$('#edit9').click(function() {

		    var text = $('.text-info9').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info9').text('').append(input);

		    var text1 = $('.text-hidden9').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden9').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv8').style.display = "block";



		});

		$('#edit10').click(function() {

		    var text = $('.text-info10').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info10').text('').append(input);

		    var text1 = $('.text-hidden10').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden10').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv9').style.display = "block";



		});

		$('#edit11').click(function() {

		    var text = $('.text-info11').text();

		    var input = $('<input style = "width: 760px; height: 40px" type="text" name="main_activity[]" value="'+ text +'" />')

		    $('.text-info11').text('').append(input);

		    var text1 = $('.text-hidden11').text();

		    var input1 = $('<input style = "width: 760px; height: 40px" type="hidden" name="mainactivity[]" value="'+ text1 +'" />')

		    $('.text-hidden11').text('').append(input1);

		    $(this).hide();

		    document.getElementById('welcomeDiv10').style.display = "block";



		});



</script>



@stop