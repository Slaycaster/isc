

<!-- contains navbar -->

        <div id="crimson-bootstrap-menu" class = "navbar navbar-default navbar-fixed-top">

            <div class = "container-fluid">

                               

                <a href="{{ URL::to('/') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/pnp_pahalang.png"/></a>

                               

                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                </button>

                               

                <div class = "collapse navbar-collapse navHeaderCollapse navbar-menubuilder">

                               

                        <ul class = "nav navbar-nav">

                            <li><a href = "{{ URL::to('Unitadmindashboard') }}">Unit Administrator Dashboard</a></li>

                            <li><a href ="{{URL::to('unitadmin/changepassword')}}">Change Password</a></li>  

                             <li>  <a href= "../ScorecardManualUnitAdmin.pdf" download>Download User Manual</a> </li>
                        

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

                          <li><a href="{{ URL::to('Unitadmindashboard') }}" style="color:white">Hi, {{ $name }}  </a></li>

                          @endif

                          @if($name != null)

                          <li><a href="{{ URL::to('logout/unitadmin') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                          @else

                          <li><a href="{{ URL::to('login/unitadmin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

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
        <div class="row hide" data-step="1" data-title="Getting Started - Dashboard Panels">
          
           
          
          <br>
          <div class="jumbotron">
                <br><br>
                Welcome to the Unit Administrator Dashboard to get started let us get 
                Familiar with the three basic panels of the dashboard
                <br>

               <img src="{{URL::asset('img/Screenshot_1.png')}}" alt="Scorecard" class="img-rounded img-responsive"/>

               <br>
               The maintenance panel lets you <b>ADD</b> new personnels , or <b>UPDATE</b> personnel info’s,<br>
                ADD Specific objectives for your unit and add sub-offices to your unit 
                <br>

               
             </div>
          
              
          
        </div>
        <div class="row hide" data-step="2" data-title="Getting Started - Personnel Activities">
          
          <div class="jumbotron">

            <br>

             <img src="{{URL::asset('img/Screenshot_3.png')}}"  alt="Scorecard" class="img-rounded img-responsive"/>

             <br>

             The personnel activities panel gives you authority on <br>
             whether your personnel can Add or Edit their activities, and<br>
             Set specific activities to certain personnel<br>

             
          </div>
            
        </div>
      <div class="row hide" data-step="3" data-title="Getting Started - Add Measure">

          <div class="jumbotron">
                <br>

               <img src="{{URL::asset('img/Screenshot_5.png')}}"  alt="Scorecard" class="img-rounded img-responsive"/>

              <br>
               Queries/Reports Panel lets you generate Weekly or Monthly Reports<br>
               Of your personnel scorecard . To GENERATE report, make sure you<br>
               Select a start date, then select the personnel by clicking the radio button<br>
               Finally you may generate the weekly or monthly report.<br>
               
          </div>

        </div>

      <div class="row hide" data-step="4" data-title="Getting Started - Assign Objectives">
          <div class="jumbotron">
            <img src="{{URL::asset('img/Screenshot_6.png')}}"  alt="Scorecard" class="img-rounded img-responsive"/>
            <br>
            Choose your desired Perspective and Objective and click the checkbox(es) at the left to select and click 'Save' button to commit changes.
            <br><br>
            <img src="{{URL::asset('img/Screenshot_7.png')}}"  alt="PEPE" class="img-rounded img-responsive"/>
          </div>
      </div>

       <div class="row hide" data-step="5" data-title="Getting Started - Fill-up targets in the Scorecard">
          <div class="jumbotron">
            <img src="{{URL::asset('img/Screenshot_10.png')}}"  alt="Scorecard" class="img-rounded img-responsive"/>
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

         <!-- end of navbar -->



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
