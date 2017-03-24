<div id ="blue-bootstrap-menu" class = "navbar navbar-default navbar-fixed-top">

            <div class = "container-fluid">

                               

                <a href="{{ URL::to('/') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/pnp_pahalang.png"/></a>

                               

                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                </button>

                               

                <div class = "collapse navbar-collapse navHeaderCollapse">

              

                        <ul class = "nav navbar-nav">

                            <li><a href="{{ URL::to('employee/dashboard') }}">Dashboard</a></li>

                            @foreach($users as $user)
                                  
                            @if($user->state == 'Enable')
                             @foreach($myrecord as $records)
                              @foreach($unitoffice as $unitoffices)
                             
                                @if($unitoffices->UnitOfficeSecondaryID != '0')
                                  
                                    @if($unitoffices->UnitOfficeSecondaryID == $records->UnitOfficeSecondaryID)
                                        @if($unitoffices->state == 'Enable')
                                                      <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                          <ul class="dropdown-menu">

                                      </li>

                                          <li><a href="{{ URL::to('employee/scorecard') }}">Add Main Activities</a></li>

                                              <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>

                                           <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                           <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>

                                          <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>

                                         

                                          <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                                         <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>
                                           <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                          <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                          </ul> 
                                        @endif
                                         @if($unitoffices->state == 'Disable')
                                                           <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                              <ul class="dropdown-menu">

                                          </li>
                                             <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>

                                              <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                              <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>
                                              

                                              <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>


                                              <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                                             
                                               <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>
                                                 <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                              <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                              </ul> 
                                        @endif
                                    @else
                                         @if($unitoffices->state == 'Enable')
                                                             <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                                <ul class="dropdown-menu">

                                            </li>

                                                <li><a href="{{ URL::to('employee/scorecard') }}">Add Main Activities</a></li>

                                                  <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>


                                                 <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                                 <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>


                                                <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>


                                                <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                                                 <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>
                                                   <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                                <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                                </ul> 
                                          @endif
                                          @if($unitoffices->state == 'Disable')
                                                             <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                                <ul class="dropdown-menu">

                                            </li>

                                                <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>

                                                 <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                                 <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>

                                                <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>

                                                

                                                <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                                                <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>
                                                 <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                                <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                                </ul> 
                                          @endif
                                    @endif
                                    <?php break; ?>
                                @elseif($unitoffices->UnitOfficeSecondaryID == '0')
                         
                                      @if($unitoffices->UnitOfficeID == $records->UnitOfficeID)
                                        @if($unitoffices->state == 'Enable')
                                                             <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                                <ul class="dropdown-menu">

                                            </li>

                                                <li><a href="{{ URL::to('employee/scorecard') }}">Add Main Activities</a></li>
                                                 <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>
                                                   <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                                   <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>


                                                <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>

                                               
                                                <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                                                <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>
                                                 <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                                <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                                </ul> 
                                        @endif
                                         @if($unitoffices->state == 'Disable')
                                                             <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                                <ul class="dropdown-menu">

                                            </li>

                                                <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>

                                                 <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                                 <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>

                                                <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>

                                                

                                                <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>
                                                
                                                 <li><a href="{{ URL::to('employee/otheractivities') }}">Add/Edit Other Activities</a></li>

                                                   <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>

                                                <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                                </ul> 
                                        @endif
                                      @endif
                                    <?php break; ?>
                                @endif
                                @endforeach
                              @endforeach
                           
                             

                                
                                 



                            @elseif($user->state == 'Disable')

                                <li class="dropdown"><a href = "#">Activity<b class="caret"></b></a>

                                <ul class="dropdown-menu">

                            </li>

                                  <li><a href="{{ URL::to('employee/addsubactivities') }}">Add Sub-Activities</a></li>
                                    <li><a href="{{ URL::to('employee/addmeasures') }}">Add Measure</a></li>

                                    <li><a href="{{ URL::to('employee/employeeeditmain') }}">Edit Main Activities</a></li>


                                <li><a href="{{ URL::to('employee/set_activities') }}">Edit Sub Activities</a></li>

                               
                                <li><a href="{{ URL::to('employee/set_measures') }}">Edit Measures</a></li>

                              
                                 <li><a href="{{ URL::to('employee/otheractivities') }}">Other Activities</a></li>
                                 <li><a href="{{ URL::to('employee/EMPremoveEmpAct') }}">Remove Unused Activities</a></li>
                                <li><a href="{{ URL::to('employee/assignobjective') }}">Assign Objectives</a></li>

                                </ul>

                                

                            </li>

                            @endif

                            @endforeach

                            <li><a href = "{{ URL::to('employee/accomplishment-final') }}">Scorecard</a></li>

                              <li><a href = "{{ URL::to('employee/reports') }}">Report</a></li>

                               <li class="dropdown"><a href = "#">Utilities<b class="caret"></b></a>

                                <ul class="dropdown-menu multi-level">

                              </li>

                               <li><a href="{{ URL::to('employee/change_password') }}">Change Password</a> </li>
                                 <li><a href="{{ URL::to('employee/change_photo') }}">Change Profile Photo</a> </li>
                                 <li><a href="#"type="button" data-toggle="modal" data-target="#myContact">Contact Us</a></li>
                                                                    

                     

                                 </li>
                               
                                </ul>

                                

                            </li>

                            <li class="dropdown"><a href="#">Help<b class="caret"></b></a>
                                <ul class="dropdown-menu multi-level">

                            </li>
                                  <li><a href="#"type="button" data-toggle="modal" data-target="#myModal">Getting Started/Tutorial</a></li>
                                   <li>  <a href= "https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/isc_personnel_manual.pdf" download>Download User Manual</a> </li>
                                 </ul>

                           
                             

                               



                        </ul>

                               

                        <ul class="nav navbar-nav navbar-right">

                          <li>
                            <a href="#">
                              <?php
                                //Get server's current time and date for scorecard subnmission
                                date_default_timezone_set("Asia/Manila");
                                echo (date("l, M d, Y, h:ia"));
                              ?>
                            </a>
                          </li>

                          @if($name == null)



                          @else

                          <li><a href="{{ URL::to('employee/view/') }}" onclick="window.open('{{ URL::to('employee/view/') }}', 'newwindow', 'width=450, height=620'); return false;"> <img style ="height:20px; width:20px; margin-top:-4px;"src="{{ URL::asset($pic) }}"/> {{ $name }}  </a></li>

                          @endif

                         @if($name != null)

                          <li><a href="{{ URL::to('employee/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                          @else

                          <li><a href="{{ URL::to('login/employee') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

                          @endif

                          

                        </ul>

                </div>                               

            </div>

         </div>

         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="js-title-step"></h4>
      </div>
      <div class="modal-body" style="margin-left:10px; margin-right:10px;">
        <div class="row hide" data-step="1" data-title="Getting Started - Change Password">
          
           
          
          <br>
          <div class="jumbotron">
               <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_1.jpg" alt="Scorecard" class="img-rounded img-responsive"/>
               <br>
               If you're using the system for the first time, the administrator will provide you a <b>temporary password</b>. You can change your the provided password later with your preferred password.

               <br><br>
               <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_2.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
             </div>
          
              
          
        </div>
        <div class="row hide" data-step="2" data-title="Getting Started - Add Main Activity">
          
          <div class="jumbotron">
             <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_3.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
             <br>
           You can now add your set of <b>Main Activities</b>
          <br><br>
            <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_4.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
            <br>
            Within here, you can also set your <b>sub-activities</b> under the 'Main Activity' field.

            <br>
           Click <b>'(Step 1 of 2) Next'</b> in order to set measure(s) to each sub-activities
          </div>
            
        </div>
      <div class="row hide" data-step="3" data-title="Getting Started - Add Measure">
          <div class="jumbotron">
               <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_5.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
               <br>You can now add measure(s) to each sub-activities you've added recently. After that, click 'Submit' button to save changes then you must assign those each sub-activities to their respective <b>Perspective</b> and <b>Objective</b>.
          </div>

        </div>

      <div class="row hide" data-step="4" data-title="Getting Started - Assign Objectives">
          <div class="jumbotron">
            <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_6.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
            <br>
            Choose your desired Perspective and Objective and click the checkbox(es) at the left to select and click 'Save' button to commit changes.
            <br><br>
            <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_7.jpg"  alt="PEPE" class="img-rounded img-responsive"/>
          </div>
      </div>

       <div class="row hide" data-step="5" data-title="Getting Started - Fill-up targets in the Scorecard">
          <div class="jumbotron">
            <img src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/Screenshot_10.jpg"  alt="Scorecard" class="img-rounded img-responsive"/>
            <br>
           Fill-up all the target to each measure(s).
          <b>If fully decided with the targets</b>, click 'Submit' button to submit the targets which will be reviewed by your respective supervisor to <b>approve</b> or <b>reject</b> it.
          
          </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>
        <button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
        <button type="button" class="btn btn-success js-btn-step" data-orientation="next"></button>
      </div>
    </div>
  </div>
</div>
         <br> <br> <br>

         <div class="modal fade" id="myContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="js-title-step"></h4>
      </div>
      <div class="modal-body" style="margin-left:10px; margin-right:10px;">
        <div class="row hide" data-step="1" data-title="Contact Us">
          
           <?php
              $id = Session::get('empid', 'default');
              $employees = DB::table('employs')
                                ->where('employs.id', '=', $id)
                                ->first();
              $SupervisorInfo = DB::table('unit_admins')
                                    ->where('unit_admins.UnitOfficeID', '=', $employees->UnitOfficeID)
                                    ->first();
           ?>
              
               <p>Contact us for requests such as rank change, name change and other concerns via e-mail at:</p>
               <br><p><b>To:</b> <u>{{ $SupervisorInfo->AdminEmail }}</u></p>
               <p><b>CC:</b> isc@cpsm.pnp.gov.ph</p>
               <p><b>Subject:</b> <i>Clearly state here the concernn (i.e. Rank Change, Name Change, etc.)</i>
                </p><hr><p><b>Body:</b></p>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>Name:_________________ &nbsp;&nbsp;&nbsp;&nbsp;Badge Number/Plantilla Number:__________</p>
              <p>Unit/Office:__________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile Number:__________</p>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>Change Request Details:</p>
               <p><i>Ex. Request change of name from PO1 Juana Santiago Dela Cruz to PO1 Juana Santiago Dela Cruz Gonzales. Attached is my marriage certificate as proof of validation.</i></p>
               <p><i>Ex. Request change of rank from Police Senior Inspector to Police Chief Inspector. Attached is the DPRM General Order #_________</i></p>
               <p><i>Ex. Request change of assignment from Police Regional Office 1 to Police Regional Office 2. Attached is the DPRM Letter Order #_________</i></p>
               <br><p><i>IMPORTANT: Please send an attachment relating to the concern for mere successful approval.</i></p>

             
          <div class="modal-footer">
        <button type="button" class="btn btn-primary js-btn-step" data-orientation="cancel" data-dismiss="modal"></button>
        
        </div>
              
          
        </div>
        

      </div>

    </div>
  </div>
</div>

            <script>
$('#myModal').modalSteps({
btnCancelHtml: 'Cancel',
btnPreviousHtml: 'Previous',
btnNextHtml: 'Next',
btnLastStepHtml: 'Finish and get started!',
disableNextButton: false,
completeCallback: function(){},
callbacks: {}
});
</script>

<script>
$('#myContact').modalSteps({
btnCancelHtml: 'Close',
disableNextButton: false,
completeCallback: function(){},
callbacks: {}
});
</script>
