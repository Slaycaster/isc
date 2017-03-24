@extends("layout-employee")

@section("content")



<head>

    <title>Scorecard  | PNP Scorecard System</title>

</head>



<div class="label_white">

<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">

<h1>Scorecard - Add Sub-activity </h1>

  

</div>

</div>


<div class="container">

  <div class="row">

   <div class="col-md-12">

    <div class="panel panel-default">

      	<div class="panel-heading">

            <strong>Add Sub-Activity</strong>

        </div>

        <div class="panel-body">

          {{ Form::open(array('url' => 'employee/postaddsubactivities', 'method' => 'post')) }}
          
@if (Session::has('message'))

      <div class="alert alert-danger">{{ Session::get('message') }}</div><br>

    @endif

          
@if (Session::has('messages'))

      <div class="alert alert-danger">{{ Session::get('messages') }}</div><br>

    @endif
          <!--loob ng foreach fcker-->
  @foreach($users as $user)
            
            @if($user->state == 'Disable' or $user->state == 'Enable')
                
             @foreach($myrecord as $records)
                 
                 @foreach($unitoffice as $unitoffices)
                             
                   @if($unitoffices->UnitOfficeSecondaryID != '0' or $unitoffices->UnitOfficeSecondaryID == '0')
                                  
                      @if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID
                        or $unitoffices->UnitOfficeSecondaryID != $records->UnitOfficeSecondaryID)
                        
                           @if($unitoffices->state == 'Disable')
                                    <?php $a = 0 ?>

                                  @foreach($MainActivityOfEmp as $MainActivity)

                                   

                                       @if($MainActivity->Main_ID == 3)


                                            <label>Main Activity 3</label>

                                            <p>{{ $MainActivity->MainActivityName }}</p>

                                            <div class="multi-field-wrapper">


                                            <div class="row">

                                                <br>

                                                

                                                <div class="multi-fields">

                                                    <div class="multi-field">

                                                       <div class="col-md-12">

                                                          <label>Sub-Activity</label> 

                                                          <input type="hidden" name="main_id[]" value="<?=$MainActivity->id?>"/>

                                                          <input type="text" name="subactivity[]" class="form-control" autocomplete="off">

                                                          

                                                          <br>

                                                       </div>

                                                       

                                                    </div>

                                                 </div>

                                             </div> 

                                            <div class="row">

                                              <div class="col-md-12">


                                                <button type="button" class="add-field"><span class="glyphicon glyphicon-plus"></span>Add Sub-Activity</button>

                                              </div>

                                            </div>
                                                <br>
                                        </div>

                                  

                                    @endif

                                     <?php $a++ ?>

                                  @endforeach


                       
                             @endif
                            @if($unitoffices->state == 'Enable')
                              

                 <?php $a = 0 ?>

                  @foreach($MainActivityOfEmp as $MainActivity)

                    <?php $a++ ?>


                            <label>Main Activity {{$a}}</label>

                            <p>{{ $MainActivity->MainActivityName }}</p>



                            <div class="multi-field-wrapper">


                            <div class="row">

                                <br>

                                

                                <div class="multi-fields">

                                    <div class="multi-field">

                                       <div class="col-md-12">

                                          <label>Sub-Activity</label> 

                                          <input type="hidden" name="main_id[]" value="<?=$MainActivity->id?>"/>

                                          <input type="text" name="subactivity[]" class="form-control" autocomplete="off">

                                          

                                          <br>

                                       </div>

                                       

                                    </div>

                                 </div>

                             </div> 

                            <div class="row">

                              <div class="col-md-12">


                                <button type="button" class="add-field"><span class="glyphicon glyphicon-plus"></span>Add Sub-Activity</button>

                              </div>

                            </div>
                            <br>

                        </div>

                  

                    

                  @endforeach


                                 
                            @endif
                    
                                @endif
                            @endif
                            <?php break; ?>
                        @endforeach              
                    @endforeach
                 @endif
            @endforeach

               

                 

                	

              <!--loob ng foreach fcker-->

              

 		    </div>

        <div class="panel-footer">

          <br>

          {{ Form::submit('(Step 1 of 2) Submit', array('class' => 'btn btn-lg btn-success')) }}

              {{Form::close()}}

        </div>

 		    <br>

        

 		</div>

 	</div>

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

$('.multi-field-wrapper').each(function() {

    var $wrapper = $('.multi-fields', this);

    $(".add-field", $(this)).click(function(e) {

        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input type=hidden').val('').focus();

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

@stop