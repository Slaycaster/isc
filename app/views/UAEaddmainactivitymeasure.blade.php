@extends("layout-unitadmin")

@section("content")



<head>

    <title>Scorecard (Step 2) | PNP Scorecard System</title>

</head>


<div class="label_white">
  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
    <h1>Create Sub-activity Measures - {{ $PersonnelName }}</h1>
  </div>
</div>

<div class="container">

  <div class="row">

   <div class="col-md-12">

    <div class="panel panel-default">

      	<div class="panel-heading">

            <strong>Create Measures</strong>

        </div>

        <div class="panel-body">

          {{ Form::open(array('url' => 'UAEpostaddEmployeeMeasure', 'method' => 'post')) }}

           {{Form::hidden('empid',$emp_id)}}

          <!--loob ng foreach fcker-->

              

                  @foreach($MainActivityOfEmp as $MainActivity)

                  

                      @foreach($SubActivityOfEmp as $SubActivity)

                      

                          @if($SubActivity->MainActivityID == $MainActivity->id)

                            <label>Sub Activity</label>

                            <p>{{ $SubActivity->SubActivityName }}</p>



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
                                            <div class="col-md-8">
                                              <label>Measure</label> 

                                              <input type="hidden" name="sub_id[]" value="<?=$SubActivity->id?>"/>

                                              <input type="text" name="measures[]" class="form-control" autocomplete="off">

                                              

                                              <br>
                                            </div>
                                            <div class="col-md-4">

                                              <label>Measure Type</label> 
                                                     
                                                        <select class="btn btn-default dropdown-toggle form-control" name="measure_type[]">
                                                              <option value="Summation/Total">Summation/Total</option>
                                                              <option value="Average">Average</option>
                                                             
                                                        </select> 
                                            </div>

                                       </div>

                                       

                                    </div>

                                 </div>

                             </div> 

                        </div>

                          @endif

                      @endforeach

                  @endforeach



                 

                	

              <!--loob ng foreach fcker-->

              

 		    </div>

        <div class="panel-footer">

          <br>

          {{ Form::submit('(Step 2 of 2) Submit', array('class' => 'btn btn-lg btn-success')) }}

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