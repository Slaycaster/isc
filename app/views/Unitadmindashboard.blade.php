@extends("layout-unitadmin")

@section("content")

<head>

  <title>Unit Administrator Dashboard | PNP Scorecard System</title>
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

    <br>
    <center>
      <div class="text_paragraph">
        @foreach($unitoffice as $office)
                @if($office->UnitOfficeSecondaryID== 0)
                    @foreach($primaryoffice as $primary)
                        @if($office->UnitOfficeID == $primary->id)
                          <p style="font-size: 30px"><strong>DASHBOARD - {{$primary->UnitOfficeName}}</strong> </p>
                        @endif
                    @endforeach
                @else
                     @foreach($secondaryoffice as $secondary)
                       @foreach($primaryoffice as $primary)
                          @if($office->UnitOfficeID == $primary->id)
                            @if($office->UnitOfficeSecondaryID == $secondary->id)
                              <p style="font-size: 30px"><strong>DASHBOARD - {{$primary->UnitOfficeName}}, {{$secondary->UnitOfficeSecondaryName}}</strong> </p>
                            @endif
                          @endif
                      @endforeach
                    @endforeach
                @endif
        @endforeach
    </div>
  </center>



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

            <strong>Maintenance Panel (Unit/Office)</strong>

          </div>

          <div class="panel-body">



            <div class = "panel-group" id="accordion">

              <!--Personnel-->

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

                            <a href="{{ URL::to('admin/index') }}">Personnel Master Entry</a>

                          </td>

                          <td>

                            <ul>

                    

                    </ul>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>


                 @foreach($unitoffice as $unitadmin)

                   

                @endforeach
               



              



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

                            <a href="{{ URL::to('admins/objectives') }}">Objective Master Entry</a>
                            <br>
                           @if($sub_unit != null)
                              @if($unitadmin->UnitOfficeSecondaryID == '0')
                                <a href="{{ URL::to('UAEofficeobjectives') }}">Assign objectives to unit/offices</a>
                              @endif
                            @endif                         
                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>

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

                            <ul>
                            @foreach($unitoffice as $ifprimary)
                            @if($ifprimary->UnitOfficeSecondaryID == '0')
                      <li><a href="{{ URL::to('UnitAdminSecondaryOffice') }}">Unit/Office Secondary </a>
                      <br><i>(NCRPO District, PPO/CPO, RPSB, RHQ-NSU Division/Office)</i></li>

                      <li><a href="{{ URL::to('UnitAdminTertiaryOffice') }}">Unit/Office Tertiary </a><br><i>(MPS/CPS, Numbered Station, NSU Section/Branch, PPO/CPO Division/Branch)</i></li>

                      <li><a href="{{ URL::to('UnitAdminQuaternaryOffice') }}">Unit/Office Quaternary </a><br><i>(PCP, PPO Section)</i></li>
                            @else
                             <li><a href="{{ URL::to('UnitAdminTertiaryOffice') }}">Unit/Office Tertiary </a><br><i>(MPS/CPS, Numbered Station, NSU Section/Branch, PPO/CPO Division/Branch)</i></li>

                      <li><a href="{{ URL::to('UnitAdminQuaternaryOffice') }}">Unit/Office Quaternary </a>><br><i>(PCP, PPO Section)</i></li>
                            @endif
                        @endforeach
                    </ul>

                          </td>

                        </tr>

                      </table>

                    </div>

                  </div>

                </div>

                <!--Suspend unsuspend 
                <div class = "panel panel-default">

                  <div class = "panel-heading">

                    <h4 class = "panel-title">

                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class = "glyphicon glyphicon-info-sign"></span> Personnel Status</a>

                    </h4>

                  </div>
                --

                  <div id = "collapseFive" class = "panel-collapse collapse">
                      <div class = "panel-body" style="height:auto;">
                          <table class = "table">
                            <tr>
                                <td>
                                  <button type="button" class="btn btn-danger" style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-bottom:3%;' data-toggle="modal" data-target="#loginAgainModal">Remove/ Suspend Employee</button>
                                  <!-- Modal --
                                  <div id="loginAgainModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content--
                                        <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">PNP Unit Administrator Login</h4>
                                          </div>
                                          <div class="modal-body">
                                              <div class="panel-heading">
                                    <strong>Please Enter your credentials to continue:</strong>
                                  </div>
                                  <div class="panel-body">
                                    {{ Form::open(array('url' => 'employeestatusunitadmin', 'method' => 'get')) }}
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
                -->
            </div>    
        </div>
    </div>

        <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Personnel Activities (Unit/Office)</strong>

              </div>
              <div class="panel-body">
                          <a class = 'btn btn-primary' style='font-size:15px; padding-top:10px; padding-bottom:10px;'  href="{{URL::to('UAEactivities')}}" onclick="{{URL::to('UAEactivities')}}" type="submit" >Set Personnel Activities (Unit/Office)</a>
                    
            </div>
          </div>


 <!--NOTIFICATION PANEL -->
          <div class="panel panel-default">

              <div class="panel-heading">

                <strong>Analysis Report</strong>

              </div>
<div class='table-responsive'>
              <div class="panel-body">

                <div class="panel-default">

                  <div class="col-md-12">

                    <div class="col-md-12">
    
                          <a class = 'btn btn-info' style='font-size:15px; padding-top:10px; padding-bottom:10px; margin-left:-30px;' href="{{URL::to('Unitadmindashboard/selectemp')}}" onclick="{{URL::to('Unitadmindashboard/selectemp')}}"type="submit" >Key Performance Indicator (KPI)</a>

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

                                  <th> </th>

                              </tr>

                          </thead>
<!--
                          <tbody>

                          @foreach ($submitted as $submit)

                          <tr>

                              <td style='color:black'>

                                  <img src="{{URL::asset($submit->EmpPicturePath)}}" style="width:50px; height: 50px" alt="" class="img-rounded img-responsive">

                              </td>



                              <td>

                                  {{$submit->RankCode}}  

                              </td>



                              <td>

                                {{$submit->EmpLastName}}

                              </td>

                              <td>

                                {{$submit->EmpFirstName}}

                              </td>

                              <td>
                                
                                 <a class = 'btn btn-primary' href="{{ URL::to('SubmittedScorecardForThisWeek/' . $submit->empID) }}" onclick="window.open('{{ URL::to('SubmittedScorecardForThisWeek/' . $submit->empID) }}', 'newwindow'); return false;">View</a>

                              </td>

                          </tr>

                          @endforeach

                          </tbody>
-->
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

                        <table class="table" id="didntsubmit">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                              </tr>

                          </thead>
<!--
                          <tbody>

                          @foreach ($didNotSubmitted as $submit)

                          <tr>

                              <td style='color:black'>

                                  <img src="{{URL::asset($submit->EmpPicturePath)}}" style="width:50px; height: 50px" alt="" class="img-rounded img-responsive">

                              </td>



                              <td>

                                  {{$submit->RankCode}}  

                              </td>



                              <td>

                                {{$submit->EmpLastName}}

                              </td>

                              <td>

                                {{$submit->EmpFirstName}}

                              </td>



                          </tr>

                          @endforeach

                          </tbody>
-->
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

                        <table class="table" id="submittedlastweek">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                                  <th> </th>

                              </tr>

                          </thead>
<!--
                          <tbody>

                          @foreach ($lastSubmitted as $submit)

                          <tr>

                              <td style='color:black'>

                                  <img src="{{URL::asset($submit->EmpPicturePath)}}" style="width:50px; height: 50px" alt="" class="img-rounded img-responsive">

                              </td>



                              <td>

                                  {{$submit->RankCode}}  

                              </td>



                              <td>

                                {{$submit->EmpLastName}}

                              </td>

                              <td>

                                {{$submit->EmpFirstName}}

                              </td>

                              <td>
                                
                                 <a class = 'btn btn-primary' href="{{ URL::to('SubmittedScorecardForLastWeek/' . $submit->empID) }}" onclick="window.open('{{ URL::to('SubmittedScorecardForLastWeek/' . $submit->empID) }}', 'newwindow'); return false;">View</a>

                              </td>

                          </tr>

                          @endforeach

                          </tbody>
-->
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

                        <table class="table" id="noscorecard">

                          <thead>

                              <tr>       
                                  <th>    </th>

                                  <th>Rank</th>

                                  <th>Last Name</th>

                                  <th>First Name</th>

                              </tr>

                          </thead>
<!--
                          <tbody>

                          @foreach ($noScorecardList as $submit)

                          <tr>

                              <td style='color:black'>

                                  <img src="{{URL::asset($submit->EmpPicturePath)}}" style="width:50px; height: 50px" alt="" class="img-rounded img-responsive">

                              </td>



                              <td>

                                  {{$submit->RankCode}}  

                              </td>



                              <td>

                                {{$submit->EmpLastName}}

                              </td>

                              <td>

                                {{$submit->EmpFirstName}}

                              </td>



                          </tr>

                          @endforeach

                          </tbody>
-->
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

            <strong>Queries/Reports Panel (Unit/Office)</strong>

          </div>

          <div class="panel-body">

          <div>
            <h4>Personnel Report</h4>
                <div class="col-md-5">
                  <p style="font-style: italic;font-size: 24x;font-weight: bold;">By Position/Rank</p>
                  {{ Form::open(array('target' => '_blank', 'url' => 'UnitAdminPersonnelReport', 'method' => 'get')) }}
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
                                                    {{--'Filter by Secondary Unit/Office',
                                                        'Filter by Tertiary Unit/Office',
                                                        'Filter by Quaternary Unit/Office'--}}
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
                        {{ Form::open(array('target' => '_blank', 'url' => 'UnitAdminPersonnelReportbyOffice', 'method' => 'get')) }}
                          <?php
                            $secondaryoffice_id = Session::get('secondaryunit','default');
                          ?>

                          @if($secondaryoffice_id == 0)
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
                          @endif
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

          <div class="col-md-12">
             @if (Session::has('message'))

                <div class="alert alert-danger">{{ Session::get('message') }}</div><br>

              @endif
          </div>
          <div>
            <h4>Scorecard Submission Report</h4>
            {{ Form::open(array('target' => '_blank', 'url' => 'SubmittedScorecardUnitAdmin', 'method' => 'get')) }}
                <div>
                    <div class="col-md-6">
                      <div style='color:black'>{{ Form::select('ReportType', 
                                                  array('Select Report Type...',
                                                     'List of personnel with submitted scorecard',
                                                     'List of personnel with pending submission of scorecard (current week)',
                                                     "List of personnel who did not submit scorecard"),
                                                Input::get('ReportType'), 
                                                  array('class' => 'btn btn-default dropdown-toggle form-control',
                                                        'id' => 'unitid', 
                                                        'tabindex' => '1',
                                                        'style' => 'padding:1px')) }}
                      </div>
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
                                                       'style' => 'padding:4px')) }}
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
</div>


@if($iffirsttime->firstlogin==0)
<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>
@endif


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
                  url: "Unitadmindashboard/personnelreport",
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
                  url: "Unitadmindashboard/personnelreport",
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
        ajax: 'anyunitdash',
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
        ajax: 'UAnotifsubmitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }, 
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>




<!-- Submitted last week -->
<script type="text/javascript">

$(document).ready(function() {
    $('#submittedlastweek').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'UAnotiflastweeksubmitted',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }, 
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>



<!-- didnt submit -->
<script type="text/javascript">

$(document).ready(function() {
    $('#didntsubmit').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'UAnotifdidntsubmit',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }
        ]
    });
});

</script>

<!-- no scorecard -->
<script type="text/javascript">

$(document).ready(function() {
    $('#noscorecard').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'UAnotifnoscorecard',
        columns: [
            
            { data: 'Pictures' , name: 'Pictures'},
            { data: 'rank', name: 'rank' },
            { data: 'lastname', name: 'lastname' },
            { data: 'firstname', name: 'firstname' }
        ]
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

<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>



<script type="text/javascript">

  $(document).ready(function() {

      $('#example2').DataTable();

  } );

</script>



<script type="text/javascript">

  $(document).ready(function() {

      $('#example3').DataTable();

  } );

</script>


<script type="text/javascript">

  $(document).ready(function() {

      $('#example4').DataTable();

  } );

</script>



<script type="text/javascript">

  $(document).ready(function() {

      $('#example5').DataTable();

  } );

</script>

<script type="text/javascript">
 

  $(function() {
    $( "#filterby" ).combobox();
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
      var val = "<?php echo $secondaryoffice_id ?>";
      if(val == 0)
      {
          //Secondary Unit office dropdown
          $('#unitid2').change(function()
          {
              $('#unitid3').html('');
              $('#unitid4').html('');

              var id2 = $('#unitid2').val();
             if (id2 != '0') { 
              $.ajax({
                  type: "POST",
                  url: "Unitadmindashboard/personnelreport/secondary",
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
      }

      //Tertiary Unit office dropdown

      $('#unitid3').change(function()
      {
        
          $('#unitid4').html('');

          var id3 = $('#unitid3').val();
        if (id3 != '0') {
          $.ajax({
              type: "POST",
              url: "Unitadmindashboard/personnelreport/tertiary",
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