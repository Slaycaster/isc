@extends("layout-employee")

@section("content")

<head>

    <title>Your Dashboard | PNP Scorecard System</title>

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

.center {
    margin-top:50px;   
}


</style>

<div class = "col-md-2">





<div class="container">

    <div class="col-md-12" style="margin-bottom:15px; color:white;">

    <center><div class="text_paragraph">

    <p style="font-size: 30px"><strong>WELCOME TO YOUR DASHBOARD</strong></p>

  </div></center>



    <hr>

    </div>

  <div class="row">



  </div>



   @if($employs == null)

      <!--Notifications for regular employee-->
      <div class = "col-md-4" style="margin-bottom:30px;">

      <div class="panel panel-default">

          <div class="panel-heading">

            <strong>Notifications</strong>

          </div>

          <div class="panel-body">
                  @if($notification == null)
                        <p><i>No new Notifications</i></p><hr>
                         
                      @endif

                @foreach($notification as $notify)
                    @if($notify->status == 'submitted' or $notify->status == 'pending' )
                        <p><i>No new Notifications</i></p><hr>
                         <?php break; ?>
                      @endif
                  @if($notify->status == 'approved')
                      <p><strong>{{$supervisorrank->RankCode}} {{$supervisorname->EmpFirstName}} {{$supervisorname->EmpLastName}} {{$supervisorname->EmpQualifier}}</strong> has approved your target request. <a href="{{ URL::to('employee/accomplishment-final') }}">Click to view your scorecard.</a> </p>
                      <?php break; ?>
                  @elseif($notify->status == 'rejected')
                      <p><strong>{{$supervisorrank->RankCode}} {{$supervisorname->EmpFirstName}} {{$supervisorname->EmpLastName}} {{$supervisorname->EmpQualifier}}</strong> has rejected your target request. 

                        @if($remarks != null)
                        <a href="#" data-toggle="modal" data-target="#remarks">Click to view the remarks.</a></p> 
                        @endif
                      <?php break; ?>

                  @endif
                       <!-- Modal -->

                @endforeach


             

          </div>

        </div>
              <!-- Trigger the modal with a button -->


<div class="modal fade" id="remarks" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Supervisor's remarks.</label>     
              </div>


              <div class="modal-body">

                      <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                       <div class="panel-body">

                        @if ($remarks == null)
                        <p><i>No remarks.</i></p>
                        @else
                        {{$remarks->messages}}
                        @endif

                       </div>

                      </div>

                      </div>
                      
                </fieldset>
                
              </div>
              <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </div>  
          </div>

         <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Analysis Report</strong>

              </div>
              <div class='table-responsive'>
              <div class="panel-body">

                <div class="panel-default">

                  <div class="col-md-12">

                    <div class="col-md-12">
    
                          <a class = 'btn btn-info' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('employee/dashboard/selectemp')}}" onclick="{{URL::to('employee/dashboard/selectemp')}}"type="submit" >Key Performance Indicator (KPI)</a>
                          

                    </div>

                 </div>

               </div>

              </div>
            </div>
          </div>

    </div>
   <div class="col-md-12"></div> 
  
   @else

   <!--QUERIES/REPORTS PANEL -->

    <div class = "col-md-7" style="margin-bottom:30px;">

      <div class="panel panel-default">

          <div class="panel-heading">

            <strong>Queries/Reports Panel</strong>

          </div>

          <div class="panel-body">
            <div class="col-md-12">
             @if (Session::has('message'))

                <div class="alert alert-danger">{{ Session::get('message') }}</div><br>

              @endif
          </div>
          <div>
            <h4>Scorecard Submission Report</h4>
            {{ Form::open(array('target' => '_blank', 'url' => 'employee/SubmittedScorecardSupervisor', 'method' => 'get')) }}
                <div>
                    <div>
                      <div class="col-md-6" style='color:black'>{{ Form::select('ReportType', 
                                                  array('Select Report Type...',
                                                     'List of personnel with submitted scorecard',
                                                     'List of personnel with pending submission of scorecard (current week)',
                                                     "List of personnel who did not submit scorecard"),
                                                Input::get('ReportType'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'unitid2', 
                                                        'tabindex' => '1',
                                                        'style' => 'padding:1px')) }}
                      </div>
                      <div class="col-md-6">
                        {{ Form::text('MondayDate',Input::get('MondayDate'),
                                                   array('autocomplete' => 'off',
                                                         'size' => '35',
                                                         'id' => 'dp1',
                                                         'placeholder' => 'Date', 
                                                         'class' => 'form-control', 
                                                         'readonly', 
                                                         'onfocus' => 'this.blur()', 
                                                         'tabindex' => '3',
                                                         'style' => 'padding:4px;')) }}
                      </div>
                    </div>
                    <br>
                    <br>
                    <div>
                      <div class="form-group col-md-6">
                        {{ Form::submit('Generate Weekly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'weekly')) }}
                      </div>
                      <div class="form-group col-md-6">
                        {{ Form::submit('Generate Monthly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'monthly')) }}
                      </div>
                    </div>
                </div>
                <br>
                <br>
            {{ Form::Close() }}
          </div>
          
          {{ Form::open(array('target' => '_blank', 'url' => 'employee/reportssupervisor', 'method' => 'get')) }}

                <h4>Subordinate Scorecard Report</h4><hr>

              <div class="form-group">

                        {{ Form::label('StartDate', 'Start Date:') }}

                        {{ Form::text('StartDate',Input::get('StartDate'), array('autocomplete' => 'off', 'size' => '35','id' => 'dp2','placeholder' => 'Date', 'class' => 'form-control' , 'readonly')) }}

                      </div>

                

                  <fieldset>

                        <div class="form-group">

                            

                        <div class="panel panel-primary">

                                <div class="panel-heading">

                                    <strong>Select Personnel</strong>

                                </div>

                            <div class="panel-body table-responsive">

                        <table class="table" id="subordinatereport">

                          <thead>

                              <tr>    

                                  <th>Rank</th>   

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Select</th>

                              </tr>

                          </thead>

                       

                      </table>

                       </div>

                                

                            </div>



                        </div>


                      <div class="form-group col-md-6">
                        {{ Form::submit('Generate Weekly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'weekly')) }}
                      </div>
                      <div class="form-group col-md-6">
                        {{ Form::submit('Generate Monthly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'monthly')) }}
                      </div>

                  </fieldset>

                {{ Form::close() }}

          </div>

        </div>

    </div>


    <div class="col-md-5">

          <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Notifications</strong>

              </div>

              <div class="panel-body">

                <div class="form-group">

                    <p><a href="#" data-toggle="modal" data-target="#squarespaceModal">{{$whosub}} Subordinate/s</a> who submitted their scorecard</p>
                    <p><a href="#" data-toggle="modal" data-target="#didSubmitterLastWeek">{{$whoSubLast}} Subordinate/s</a> who submitted their scorecard last week</p>
                    <p><a href="#" data-toggle="modal" data-target="#didNotSubmitterLastWeek">{{$whoDidNotSub}} Subordinate/s</a> who did not submit their scorecard last week</p>
                    
                  
                </div>

                <div class="form-group">
                  @if($notification == null)
                    <p></p><hr>
                  @else

                  @foreach($notification as $notify)
                  @if($notify->status == 'approved')
                      <p><strong>{{$supervisorrank->RankCode}} {{$supervisorname->EmpFirstName}} {{$supervisorname->EmpLastName}} {{$supervisorname->EmpQualifier}}</strong> has approved your target request. <a href="{{ URL::to('employee/accomplishment-final') }}">Click to view your scorecard.</a></p>
                      <?php break; ?>
                  @elseif($notify->status == 'rejected')
                      <p><strong>{{$supervisorrank->RankCode}} {{$supervisorname->EmpFirstName}} {{$supervisorname->EmpLastName}} {{$supervisorname->EmpQualifier}}</strong> has rejected your target request. 

                        @if($remarks != null)
                        <a href="#" data-toggle="modal" data-target="#remarkss">Click to view the remarks.</a></p> 
                        @endif
                      </p> 
                      <?php break; ?>

                       <!-- Modal -->
                  @endif

          
                @endforeach

                  @endif
                </div>

              </div>
                
          </div>
                       <div class="modal fade" id="remarkss" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Supervisor's remarks.</label>     
              </div>


              <div class="modal-body">

                      <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                       <div class="panel-body">

                        @if ($remarks == null)
                        <p><i>No remarks.</i></p>
                        @else
                        {{$remarks->messages}}
                        @endif

                       </div>

                      </div>

                      </div>
                      
                </fieldset>
                
              </div>
              <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </div>  
          </div>

           <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Analysis Report</strong>

              </div>
              <div class='table-responsive'>
              <div class="panel-body">

                <div class="panel-default">

                  <div class="col-md-12">

                    <div class="col-md-12">
    
                          <a class = 'btn btn-info' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('employee/dashboard/selectemp')}}" onclick="{{URL::to('employee/dashboard/selectemp')}}"type="submit" >Key Performance Indicator (KPI)</a>
                          <br><br>

                          <a class = 'btn btn-success' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('employee/dashboard/subselectemp')}}" onclick="{{URL::to('employee/dashboard/subselectemp')}}"type="submit" >Subordinate's Key Performance Indicator (KPI)</a>

                    </div>

                 </div>

               </div>

              </div>
            </div>
          </div>
         

         

          <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Names who already submitted this week: {{$DateCovered}}</label>     
              </div>


              <div class="modal-body">
                
                      <!-- content goes here -->


                      <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong></strong>

                      </div>

                       <div class="panel-body table-reponsive">

                        <table class="table" width="100%" id="submittedthisweek">

                          <thead>

                              <tr>       
                                  
                                  <th width="20%">    </th>

                                  <th width="25%">Last Name</th>

                                  <th width="23%">First Name</th>

                                   <th width="17%">Rank</th>

                                  <th width="15%">   </th>


                              </tr>

                          </thead>

                       

                      </table>

                       </div>

                      

                  </div>



                      </div>
                      
                </fieldset>
                

              </div>
              <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </div>  
          </div>




          <div class="modal fade" id="didNotSubmitterLastWeek" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Names who did not submit last week: {{$LastWeekDateCovered}}</label>
                          
              </div>
              <div class="modal-body">
                
                      <!-- content goes here -->


                       <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong></strong>

                      </div>

                       <div class="panel-body table-responsive">

                        <table width="100%" class="table" id="didnotsubmitted">

                          <thead>

                              <tr>       
                                  
                                  <th width="20%">    </th>

                                  <th width="30%">Last Name</th>

                                  <th width="30%">First Name</th>

                                   <th width="20%">Rank</th>

                              


                              </tr>

                          </thead>


                      </table>

                       </div>

                      

                  </div>



                      </div>
                      
                </fieldset>

              </div>
              <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>



          <div class="modal fade" id="didSubmitterLastWeek" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Names who submitted last week: {{$LastWeekDateCovered}}</label>
                          
              </div>
              <div class="modal-body">
                
                      <!-- content goes here -->

                       <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong></strong>

                      </div>

                       <div class="panel-body table-reponsive">

                        <table width="100%" class="table" id="submitted">

                          <thead>

                              <tr>       
                                  <th width="20%">    </th>

                                  <th width="25%">Last Name</th>

                                  <th width="23%">First Name</th>

                                   <th width="17%">Rank</th>

                                  <th width="15%">   </th>


                              </tr>

                          </thead>


                      </table>

                       </div>

                      

                  </div>



                      </div>
                      
                </fieldset>


                

              </div>
              <div class="modal-footer">
                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>

         

     {{ Form::open(array('url' => 'employee/ApprovePending', 'method' => 'post')) }}
          <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Pending Target Approvals</strong>

              </div>

              <div class="col-md-12">

                  @if (Session::has('message'))

                    <div class="alert alert-success">{{ Session::get('message') }}</div>

                  @endif



                  @if (Session::has('message2'))

                    <div class="alert alert-danger">{{ Session::get('message2') }}</div>

                  @endif

                  @if (Session::has('message3'))

                    <div class="alert alert-danger">{{ Session::get('message3') }}</div>

                  @endif



              </div>



              <div class="panel-body">

                @if($pending == null)

             

                <h4>No Pending Approvals</h4>

                @else

                  <h4>Personnel with pending targets</h4><hr>

                  <fieldset>

                        <div class="form-group">

                            

                        <div class="panel panel-primary">

                                <div class="panel-heading">

                                    <strong>Select Personnel</strong>

                                </div>

                                 <div class="panel-body table-responsive">

                        <table class="table" id="example2">

                          <thead>

                              <tr>       

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Select</th>

                              </tr>

                          </thead>

                        

                          <tbody>

        <?php $temp_id = 0 ?>

                          @foreach ($pending as $pendings)



                          @if($pendings->empID != $temp_id)

                          <tr>

                              <td style='color:black'>

                                  {{$pendings->RankCode}}

                              </td>

                              <td style='color:black'>

                                  {{$pendings->EmpLastName}}

                              </td>



                              <td>

                                 {{$pendings->EmpFirstName}}

                              </td>



                              <td>

                                <div class="col-md-6">

                                {{Form::checkbox('pending_id[]', $pendings->empID)}}

                              </div>



                              <div class="col-md-6">

                                <a class = 'btn btn-warning' href="{{ URL::to('employee/subordinatepending/' . $pendings->empID) }}" onclick="window.open('{{ URL::to('employee/subordinatepending/' . $pendings->empID) }}', 'newwindow'); return false;">View</a>

                               

                              </div>

                           

                              </td>



                              <?php

                                $temp_id = $pendings->empID

                              ?>

                          </tr>

                          @endif

                          @endforeach

                          </tbody>



                      </table>

                       </div>

                                

                            </div>



                        </div>



                        



                        <div class="form-group">

                          <div class="col-md-6">

                          

                       

                            <input class = 'btn btn-success btn-block' style="margin-bottom:3%;" type="submit" name="Approve" value="Approve">

            

                          </div>

                          <div class="col-md-6">

                             
                             <a href = '#' class = 'btn btn-danger btn-block' name="Reject" data-toggle="modal" data-target="#confirmModal" value="Reject">Reject</a>
                             
                               <!-- Modal -->
                            <div id="confirmModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                              <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Confirm submission?</h4>
                                  </div>
                                <div class="modal-body">
                                  <div>{{ Form::label('Remarks', 'Why did you reject?') }}</div>
                                <div style='color:black'>{{ Form::textarea('Remarks', Input::get('Remarks'), array('placeholder' => 'Remarks','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                                </div>
                                <div class="modal-footer">
                                  
                                  <!--<input class = 'btn btn-success' type="submit" value="Ok">-->

                                <input class = 'btn btn-danger' type="submit" name="Reject" value="Reject">
                                  

                                <button type="button" class="btn btn-default" data-dismiss="modal"><i>Cancel</i></button>
                                  </div>
                                </div>

                                </div>
                              </div>

                          </div>

                          

                        </div>

                      

                  </fieldset>

              </div>

              @endif

          </div>

    </div>

  {{Form::close()}}

  </div>





    @endif





</div>




</div>


@if($iffirsttime==null)
<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>
@endif



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

    $(function() {

        $("#dp1").datepicker(

        {   

            beforeShowDay: function(day) {



            var day = day.getDay();

            if (day == 0 || day == 2 || day == 3 || day == 4 || day == 5 || day == 6) {

                return [false]

            } else {

                return [true]

            }

        }

        });

    });

</script>
<script type="text/javascript">

    $(function() {

        $("#dp2").datepicker(

        {   

            beforeShowDay: function(day) {



            var day = day.getDay();

            if (day == 0 || day == 2 || day == 3 || day == 4 || day == 5 || day == 6) {

                return [false]

            } else {

                return [true]

            }

        }

        });

    });

</script>

<script type="text/javascript">

    $("#dp1").val($.datepicker.formatDate('dd/mm/yy'));

</script>

<script type="text/javascript">

    $("#dp2").val($.datepicker.formatDate('dd/mm/yy'));

</script>



<!-- Submitted this week -->
<script type="text/javascript">

$(document).ready(function() {
    $('#submittedthisweek').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'dashboard/personnelnotif-submitted-this-week',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }, 
            { data: 'rank', name: 'rank' },
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>


<!-- Submitted last week -->
<script type="text/javascript">

$(document).ready(function() {
    $('#submitted').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'dashboard/personnelnotif-submitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }, 
            { data: 'rank', name: 'rank' },
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>





<!-- Did not submitted -->
<script type="text/javascript">

$(document).ready(function() {
    $('#didnotsubmitted').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'dashboard/personnelnotifDidNotSubmitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' },
             { data: 'rank', name: 'rank' }
            
        ]
    });
});

</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#subordinatereport').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'dashboard/personnelsubordinatereport',
        columns: [
            
            { data: 'Rank' , name: 'Rank'},
            { data: 'LastName' , name: 'LastName'},
            { data: 'FirstName' , name: 'FirstName'},
            { data: 'Select' , name: 'Select'}
           
            
        ]
    });
});

</script>





@stop

