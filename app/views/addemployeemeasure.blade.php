@extends("layout")

@section("content")



<head>

    <title>Scorecard Add Measure| PNP Scorecard System</title>

</head>



<style type="text/css">
/*Panel tabs*/
.panel-tabs {
    position: relative;
    bottom: 30px;
    clear:both;
    border-bottom: 1px solid transparent;
}

.panel-tabs > li {
    float: left;
    margin-bottom: -1px;
}

.panel-tabs > li > a {
    margin-right: 2px;
    margin-top: 4px;
    line-height: .85;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
    color: #ffffff;
}

.panel-tabs > li > a:hover {
    border-color: transparent;
    color: #ffffff;
    background-color: transparent;
}

.panel-tabs > li.active > a,
.panel-tabs > li.active > a:hover,
.panel-tabs > li.active > a:focus {
    color: #fff;
    cursor: default;
    -webkit-border-radius: 1px;
    -moz-border-radius: 1px;
    border-radius: 1px;
    background-color: rgba(255,255,255, .23);
    border-bottom-color: transparent;
}
</style>

<div class="label_white">
  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
    <h1>Add Sub-activity Measures - {{ $PersonnelName }}</h1>
  </div>
</div>



<div class="container">
  <div class="row">
    <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="panel-title">Create Measure</h1>
                     {{ Form::open(array('url' => 'postAddEmployeeSubMeasure', 'method' => 'post')) }}

                    {{Form::hidden('empid',$id)}}
                    
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">

                    <br><br>
                           <?php $counter = 1 ?>

                    @foreach($mainactivities as $mainactivity )
                    

                    <li><a href="#tab{{$counter}}" class="tab-pane active" data-toggle="tab">{{$mainactivity->MainActivityName}}</a></li>
                    <?php $counter=$counter+1 ?>

                    @endforeach
                            
                            
                        </ul>
                  
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        
                          <?php $counter = 1 ?>

                   <!-- foreach main activity again -->

                   <?php $maincounter = 1 ?>

                  @foreach($mainactivities as $mainactivity)

                  <div id="tab{{$counter}}" class="tab-pane active">

                         <?php $maincounter++ ?>

                    <!-- foreach sub activity -->

                        <?php $a = 0 ?>


                                @foreach($subactivities as $subactivity)

                                <?php $a++ ?>
                                @if($subactivity->MainActivityID == $mainactivity->id)
                                    

                                     

                                      <p>{{ $subactivity->SubActivityName }}</p>



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

                                                        <input type="hidden" name="sub_id[]" value="<?=$subactivity->id?>"/>

                                                        <input type="text" name="measures[]" class="form-control" autocomplete="off">

                                                        <br>
                                                    </div>
                                                    <div class="col-md-4">

                                                         <label>Measure Type</label> 
                                                      {{-- Form::select('measure_type[]', array('Score' => 'Score','%(Percentage)' => '%(Percentage)','#(Quantity)' => '#(Quantity)','hours' => 'hours','days' => 'days','minutes' => 'minutes'),null,array('class' => 'btn btn-default dropdown-toggle form-control')) --}}
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

                                @endforeach <!--subactivity foreach-->

        </div>
        <?php $counter++ ?>
        @endforeach
                        
                    </div>
                </div>
<div class="panel-footer" style="padding-top:10px; padding-bottom:10px; margin-left:20px">

          {{ Form::submit('Submit', array('class' => 'btn btn-lg btn-success')) }}

              {{Form::close()}}

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



jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});

</script>

@stop