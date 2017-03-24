@extends("layout")

@section("content")

<head>

  <title>Administrator Dashboard | PNP Scorecard System</title>
  <style>
    .custom-combobox {
      position: relative;
      display: inline-block;
    }
    .custom-combobox-toggle {
      position: absolute;
      top: 0;
      bottom: 0;
      margin-left: -1px;
      padding: 50;
    }
    
    .custom-combobox-input {
      margin: 0;
      padding: 2px;
      width: 255px;
      height: 34px;
      font-size: 12px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
              box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
           -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
              transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
  </style>
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


<div class="container">

  <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

    <br><center><div class="text_paragraph">

    <p style="font-size: 30px"><strong>WELCOME TO YOUR DASHBOARD</strong> </p>

  </div></center>



  <hr>

  </div>

  <div class="row" style="margin-top:30px;">

    <!--MAINTENANCE PANEL -->

    <div class = "col-md-4">

      <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Notifications</strong>

              </div>

              <div class="panel-body">

                <div class="form-group">

                    <p><a href="#" data-toggle="modal" data-target="#squarespaceModal">{{$whosub}} Subordinate/s</a> who submitted their scorecard</p>
                    <p><a href="#" data-toggle="modal" data-target="#didSubmitterLastWeek">{{$whoSubLast}} Subordinate/s</a> who submitted their scorecard last week</p>
                    <p><a href="#" data-toggle="modal" data-target="#didNotSubmitterLastWeek">{{$whoDidNotSub}} Subordinate/s</a> who did not submit their scorecard last week</p>
                    <p><a href="#" data-toggle="modal" data-target="#noScorecard">{{$noScorecard}} Subordinate/s</a> who still didn't have scorecard</p>
                  
                </div>

              </div>
                
          </div>

        

<div class="panel panel-default">

          <div class="panel-heading">

            <strong>Maintenance Panel</strong>

          </div>

          <div class="panel-body">



            <div class = "panel-group" id="accordion">

              <!--EMPLOYEE-->

                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class = "glyphicon glyphicon-user"></span> Personnel</a>

                    </h4>

                  </div>

                  <div id = "collapseOne" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            <a href="{{ URL::to('employs') }}">Personnel Master Entry</a>

                          </td>

                          <td>

                            <ul>

                      <li><a href="{{ URL::to('ranks') }}">Rank</a></li>

                      <li><a href="{{ URL::to('positions') }}">Position</a></li>

                    </ul>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>



                <!--UNIT OFFICE-->

                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class = "glyphicon glyphicon-tree-deciduous"></span> Unit/Office</a>

                    </h4>

                  </div>

                  <div id = "collapseTwo" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            <a href="{{ URL::to('unit_offices') }}">Master Entry</a><br><i>(PROs, NSUs, D-Staff, P-Staff)</i>

                          </td>

                          <td>

                            <ul>

                      <li><a href="{{ URL::to('unit_office_secondaries') }}">Unit/Office Secondary</a><br><i>(NCRPO District, PPO/CPO, RPSB, RHQ-NSU Division/Office)</i></li>

                      <li><a href="{{ URL::to('unit_office_tertiaries') }}">Unit/Office Tertiary</a><br><i>(MPS/CPS, Numbered Station, NSU Section/Branch, PPO/CPO Division/Branch)</i></li>

                      <li><a href="{{ URL::to('unit_office_quaternaries') }}">Unit/Office Quaternary</a><br><i>(PCP, PPO Section)</i></li>

                    </ul>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>



                <!--PERSPECTIVE-->

                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class = "glyphicon glyphicon-lamp"></span> Perspective</a>

                    </h4>

                  </div>

                  <div id = "collapseThree" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            <a href="{{ URL::to('perspectives') }}">Perspective Master Entry</a>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>



                <!--OBJECTIVE-->

                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class = "glyphicon glyphicon-record"></span> Objective</a>

                    </h4>

                  </div>

                  <div id = "collapseFour" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            <a href="{{ URL::to('objectives') }}">Objective Master Entry</a>
                            <br>
                            <a href="{{ URL::to('office_objectives') }}">Assign objectives to unit offices</a>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>



                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class = "glyphicon glyphicon-home"></span> Unit Admin</a>

                    </h4>

                  </div>

                  <div id = "collapseFive" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            <a href="{{ URL::to('unit_admins') }}">Unit Admin Master Entry</a>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>

                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span class = "glyphicon glyphicon-info-sign"></span> Personnel Status</a>

                    </h4>

                  </div>

                  <div id = "collapseSix" class = "panel-collapse collapse">

                    <div class = "panel-body" style="height:auto;">

                      <table class = "table">

                        <tr>

                          <td>

                            {{--<a href="{{ URL::to('employeestatus') }}">Remove/Suspend Employee</a>--}}
                            <button type="button" class="btn btn-danger" style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-bottom:3%;' data-toggle="modal" data-target="#loginAgainModal">Remove/ Suspend Employee</button>

                          <!-- Modal -->
                          <div id="loginAgainModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">PNP Administrator Login</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="panel-heading">

            <strong>Please Enter your credentials to continue:</strong>

          </div>

          <div class="panel-body">

            {{ Form::open(array('url' => 'employeestatus', 'method' => 'get')) }}

              <fieldset>


                <div class="row">

                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <div class="form-group">

                      <div class="input-group">

                        @if (Session::has('message'))

                          <div class="alert alert-danger">{{ Session::get('message') }}</div>

                        @endif

                      </div>

                      <div class="input-group">

                          <span class="input-group-addon">

                          <i class="glyphicon glyphicon-user"></i>

                        </span> 

                        <strong>{{ Form::text('username', Input::get('username'), array('placeholder' => 'Username','autocomplete' => 'off', 'class' => 'form-control')) }}</strong>

                      </div>

                    </div>

                    <div class="form-group">

                      <div class="input-group">

                        <span class="input-group-addon">

                          <i class="glyphicon glyphicon-lock"></i>

                        </span>

                        <strong>{{ Form::password('password', array('placeholder' => 'Password', 'autocomplete' => 'off', 'class' => 'form-control')) }}</strong>

                      </div>

                    </div>

                    <div class="form-group">

                      {{ Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block')) }}

                    </div>

                  </div>

                </div>

              </fieldset>

            {{ Form::close() }}

          </div>
                                </div>
                              
                              </div>

                            </div>
                          </div>

                          </td>

                          <td>

                        

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>

                



                



              </div>    

          </div>



        </div>

            <!--NOTIFICATION PANEL -->

    <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Personnel Activities</strong>

              </div>
<div class='table-responsive'>
              <div class="panel-body">

                <div class="panel-default">

                  <div class="col-md-12">

                    <div class="col-md-12">

                {{ Form::open(array('url' => 'dashboard', 'method' => 'post')) }}

                        @foreach($users as $user)

                          @if($user->state == 'Enable')

                          
                          <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-danger" style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-bottom:3%; margin-left:-30px;' data-toggle="modal" data-target="#disableModal">Disable/Revoke Personnel's Access on Activities</button>

                          <!-- Modal -->
                          <div id="disableModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Are you sure?</h4>
                                </div>
                                <div class="modal-body">
                                  <p>It will Disable/Revoke access on <strong>all personnel</strong> at <strong>all unit offices</strong>. <br>Are you sure you want to proceed? </p>
                                </div>
                                <div class="modal-footer">
                                  <input class = 'btn btn-danger' type="submit" name="state" value="Disable/Revoke Employee's Access on Activities">

                                  {{Form::hidden('state','Disable')}}

                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>
 

                          @endif

                           @if($user->state == 'Disable')

                            <!-- Trigger the modal with a button -->
                          <button type="button" class="btn btn-success" style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-bottom:3%; margin-left:-30px;' data-toggle="modal" data-target="#enableModal">Enable/Grant Personnel's Access on Activities</button>

                          <!-- Modal -->
                          <div id="enableModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Are you sure?</h4>
                                </div>
                                <div class="modal-body">
                                  <p>It will Enable/Grant access on <strong>all personnel</strong> at <strong>all unit offices</strong>. <br>Are you sure you want to proceed? </p>
                                </div>
                                <div class="modal-footer">
                                  <input class = 'btn btn-success' type="submit" name="state" value="Enable/Grant Personnel's Access on Activities">

                                   {{Form::hidden('state','Enable')}}

                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>

                          @endif



                        @endforeach

                  {{Form::close()}}

                    </div>

                    <div class="col-md-12">

                          <a class = 'btn btn-primary' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('employeeactivities')}}" onclick="{{URL::to('employeeactivities')}}"type="submit" >Set Personnel Activities</a>

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
    
                          <a class = 'btn btn-info' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('dashboard/selectemp')}}" onclick="{{URL::to('dashboard/selectemp')}}"type="submit" >Key Performance Indicator (KPI)</a>

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

                       <div class="panel-body">

                        <table class="table" id="submittedthisweek">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Unit/Office</th>

                                  <th>Actions</th>

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

                       <div class="panel-body">

                        <table class="table" id="didnotsubmitted">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Unit/Office</th>

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

                       <div class="panel-body">

                        <table class="table" id="submitted">

                          <thead>

                              <tr>       
                                  <th> </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Unit/Office</th>

                                  <th>Actions</th>

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

          <div class="modal fade" id="noScorecard" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <label for="exampleInputEmail1">Names who still didn't have scorecard:</label>
                          
              </div>
              <div class="modal-body">
                
                      <!-- content goes here -->

                        <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong></strong>

                      </div>

                       <div class="panel-body">

                        <table class="table" id="example5">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th>Unit/Office</th>

                              </tr>

                          </thead>

                          <tbody>

                          </tbody>

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



    </div>





    <!--QUERIES/REPORTS PANEL -->

    <div class = "col-md-8" style="margin-bottom:40px;">

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
            <h4>Personnel Report</h4><hr> 
                <div class="col-md-5">
                  <p style="font-style: italic;font-size: 24x;font-weight: bold;">By Position/Rank</p>
                  {{ Form::open(array('target' => '_blank', 'url' => 'AdminPersonnelReport', 'method' => 'get')) }}
                    <div>
                      <div style='color:black'>{{ Form::select('Filter', 
                                                  array('Filter by...',
                                                        'Filter by Position',
                                                        'Filter by Rank'),
                                                Input::get('Filter'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'filter', 
                                                        'tabindex' => '1',
                                                        'style' => 'padding:1px')) }}
                      </div>
                    </div>
                    <br>
                    <div>
                      <div style='color:black'>{{ Form::select('FilteredBy', $filterby,
                                                Input::get('FilteredBy'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'filterby', 
                                                        'tabindex' => '2',
                                                        'style' => 'padding:1px')) }}
                      </div>
                    </div>
                    <br>
                    <div>
                      {{ Form::submit('Show List', array('class' => 'btn btn-primary btn-block')) }}
                    </div>
                  {{ Form::Close() }}
                </div>
                    <div class="col-md-7">
                      <p style="font-style: italic;font-size: 24x;font-weight: bold;">By Unit/Offices</p>
                        {{ Form::open(array('target' => '_blank', 'url' => 'AdminPersonnelReportbyOffice', 'method' => 'get')) }}

                          <div>
                            <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id,
                                                      Input::get('UnitOfficeID'), 
                                                        array('class' => 'btn btn-default dropdown-toggle form-control',
                                                              'id' => 'unitid1', 
                                                              'tabindex' => '2',
                                                              'style' => 'padding:1px')) }}
                            </div>
                          </div>
                          <br>
                          <div>
                            <div style='color:black'>{{ Form::select('UnitOfficeSecondaryID', $unit_offices_secondaries_id,
                                                      Input::get('UnitOfficeSecondaryID'), 
                                                        array('class' => 'btn btn-default dropdown-toggle form-control',
                                                              'id' => 'unitid2', 
                                                              'tabindex' => '2',
                                                              'style' => 'padding:1px')) }}
                            </div>
                          </div>
                          <br>
                          <div>
                            <div style='color:black'>{{ Form::select('UnitOfficeTertiaryID', $unit_offices_tertiaries_id,
                                                      Input::get('UnitOfficeTertiaryID'), 
                                                        array('class' => 'btn btn-default dropdown-toggle form-control',
                                                              'id' => 'unitid3', 
                                                              'tabindex' => '2',
                                                              'style' => 'padding:1px')) }}
                            </div>
                          </div>
                          <br>
                          <div>
                            <div style='color:black'>{{ Form::select('UnitOfficeQuaternaryID', $unit_offices_quaternaries_id,
                                                      Input::get('UnitOfficeQuaternaryID'), 
                                                        array('class' => 'btn btn-default dropdown-toggle form-control',
                                                              'id' => 'unitid4', 
                                                              'tabindex' => '2',
                                                              'style' => 'padding:1px')) }}
                            </div>
                          </div>
                          <br>
                          <div>
                            {{ Form::submit('Show List', array('class' => 'btn btn-primary btn-block')) }}
                          </div>
                        {{ Form::Close() }}
                    </div>
                <br>
                <br>
          </div>


          <div>
          <h4>Scorecard Submission Report</h4>
            {{ Form::open(array('target' => '_blank', 'url' => 'SubmittedScorecardAdmin', 'method' => 'get')) }}
                <div>
                    <div class="col-md-5">
                      <div style='color:black'>{{ Form::select('ReportType', 
                                                  array('Select Report Type...',
                                                     'List of personnel with submitted scorecard',
                                                     'List of personnel with pending submission of scorecard (current week)',
                                                     "List of personnel who did not submit scorecard"),
                                                Input::get('ReportType'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'unitid1', 
                                                        'tabindex' => '1',
                                                        'style' => 'padding:1px')) }}
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id,
                                                Input::get('UnitOfficeID'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'unitid', 
                                                        'tabindex' => '2',
                                                        'style' => 'padding:1px')) }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      {{ Form::text('MondayDate',Input::get('MondayDate'),
                                                 array('autocomplete' => 'off',
                                                       'size' => '35',
                                                       'id' => 'dp1',
                                                       'placeholder' => 'Date', 
                                                       'class' => 'form-control', 
                                                       'readonly', 
                                                       'onfocus' => 'this.blur()', 
                                                       'tabindex' => '3',
                                                       'style' => 'padding:4px')) }}
                    </div>
                </div>
                <br>
                <br>
                <div>
                    <div class="form-group col-md-5">
                        {{ Form::submit('Generate Weekly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'weekly')) }}
                      </div>
                      <div class="form-group col-md-5">
                        {{ Form::submit('Generate Monthly Report', array('class' => 'btn btn-primary btn-block', 'name' => 'monthly')) }}
                      </div>
                </div>
                <br>
                <br>
            {{ Form::Close() }}
          </div>
          
          {{ Form::open(array('target' => '_blank', 'url' => 'reportsadmin', 'method' => 'get')) }}
              <h4>Individual Scorecard Report</h4><hr>
              <div class="form-group">

                        {{ Form::label('StartDate', 'Start Date:') }}

                        {{ Form::text('StartDate',Input::get('StartDate'), array('autocomplete' => 'off', 'size' => '35','id' => 'dp2','placeholder' => 'Date', 'class' => 'form-control', 'readonly', 'onfocus' => 'this.blur()')) }}

                      </div>

                      <script type="text/javascript">

                        $('input[readonly]').focus(function(){

                              this.blur();

                          });

                      </script>

              

                <fieldset>

                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong>Select Personnel</strong>

                      </div>

                       <div class="panel-body">
                        
                        <table class="table" id="users-table">

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




  </div>

</div>


<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  $(document).ready(function()
  {
      $('#filter').change(function()
      {
           $('#filterby').html('');
          var id = $('#filter').val();
          //alert(id);
          if(id == 1)
          {
              $.ajax({
                  type: "POST",
                  url: "dashboard/personnelreport",
                  data: {'filter' : id},
                  success: function(data){
                    //console.log(data);
                    var arr = data ;
                    var i;
                    var select = document.getElementById("filterby");
                    for(i = 0; i < arr.length; i++) 
                    {
                        var option = document.createElement('option');
                        option.value = arr[i].id;
                        option.text = arr[i].PositionName;
                        select.add(option, i);
                    }
                  }
              })
          }
          if(id == 2)
          {
              $.ajax({
                  type: "POST",
                  url: "dashboard/personnelreport",
                  data: {'filter' : id},
                  success: function(data){
                    //console.log(data);
                    var arr = data ;
                    var i;
                    var select = document.getElementById("filterby");
                    for(i = 0; i < arr.length; i++) 
                    {
                        var option = document.createElement('option');
                        option.value = arr[i].id;
                        option.text = arr[i].RankCode;
                        select.add(option, i);
                    }
                  }
              })
          }
      });
  });


</script>


<!-- Dashboard -->
<script type="text/javascript">

$(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'datatable',
        columns: [

            { data: 'rank', name: 'rank' },
            { data: 'EmpLastName', name: 'EmpLastName' },
            { data: 'EmpFirstName', name: 'EmpFirstName' }, 
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>


<!-- Submitted this week -->
<script type="text/javascript">

$(document).ready(function() {
    $('#submittedthisweek').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'notif-submitted-this-week',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }, 
            { data: 'unit', name: 'unit '},
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
        ajax: 'notif-submitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' },
            { data: 'unit', name: 'unit' },
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
        ajax: 'notifDidNotSubmitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' },
            { data: 'unit', name: 'unit' }
            
        ]
    });
});

</script>



<!--No Scorecard Notif -->
<script type="text/javascript">

$(document).ready(function() {
    $('#example5').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'notifNoScorecard',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' },
            { data: 'unit', name: 'unit' }
            
        ]
    });
});

</script>



<script type="text/javascript">
  $(document).ready(function() {
      $('#users-table').DataTable();
  } );
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




<script type="text/javascript">

    $(function() {

        $("#dp3").datepicker(

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

    $("#dp3").val($.datepicker.formatDate('dd/mm/yy'));

</script>

<script type="text/javascript">
 

  $(function() {
    $( "#filterby" ).combobox();
    $("#unitid").combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
</script>

<script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "col-md-5 custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $(  "<a style='border:1px solid #ccc; color: #000;padding-top: 8px'> <span class='glyphicon glyphicon-chevron-down' </a>"  )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-2-n-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete("widget").is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  
  </script>

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

  $(document).ready(function()
  {

      //Unit Office dropdown
      $('#unitid1').change(function()
      {
          $('#unitid2').html('');
          $('#unitid3').html('');
          $('#unitid4').html('');
          
          var id = $('#unitid1').val();
          if (id != '0') {
            $.ajax({
                type: "POST",
                url: "dashboard/personnelreport/primary",
                data: {'officeID' : id},
                success: function(data){
                  var arr = data ;
                  var i;
                  var select = document.getElementById("unitid2");
                  for(i = 0; i < arr.length; i++) 
                  {
                      var option = document.createElement('option');
                      option.value = arr[i].id;
                      option.text = arr[i].UnitOfficeSecondaryName;
                      select.add(option, i);

                  }
                  $('#unitid2').prepend('<option value="' + 0 + '">' + 'Select Secondary Unit Office' + '</option>');
                }
          }

          )
          }
      });

      //Secondary Unit office dropdown

      $('#unitid2').change(function()
      {
          $('#unitid3').html('');
          $('#unitid4').html('');

          var id2 = $('#unitid2').val();
         if (id2 != '0') { 
          $.ajax({
              type: "POST",
              url: "dashboard/personnelreport/secondary",
              data: {'officeID2' : id2},
              success: function(data){
                var arr = data ;
                var i;
                var select = document.getElementById("unitid3");
                for(i = 0; i < arr.length; i++) 
                {
                    var option = document.createElement('option');
                    option.value = arr[i].id;
                    option.text = arr[i].UnitOfficeTertiaryName;
                    select.add(option, i);
                   
                }
                 $('#unitid3').prepend('<option value="' + 0 + '">' + 'Select Tertiary Unit Office' + '</option>');
               
              }

          })
        }
      });

      //Tertiary Unit office dropdown

      $('#unitid3').change(function()
      {
        
          $('#unitid4').html('');

          var id3 = $('#unitid3').val();
        if (id3 != '0') {
          $.ajax({
              type: "POST",
              url: "dashboard/personnelreport/tertiary",
              data: {'officeID3' : id3},
              success: function(data){
                var arr = data ;
                var i;
                var select = document.getElementById("unitid4");
                for(i = 0; i < arr.length; i++) 
                {
                    var option = document.createElement('option');
                    option.value = arr[i].id;
                    option.text = arr[i].UnitOfficeQuaternaryName;
                    select.add(option, i);
                }
                $('#unitid4').prepend('<option value="' + 0 + '">' + 'Select Quaternary Unit Office' + '</option>');
              }

          })
        }
      });


  });

</script>





@stop