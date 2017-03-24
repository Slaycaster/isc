

<!-- contains navbar -->

		<div class = "navbar navbar-inverse navbar-fixed-top">

            <div class = "container-fluid">

                               

                <a href="{{ URL::to('/') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/pnp_pahalang.png"/></a>

                               

                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

              	</button>

                               

                <div class = "collapse navbar-collapse navHeaderCollapse">

                               

                        <ul class = "nav navbar-nav">

                            <li><a href = "{{ URL::to('dashboard') }}">Administrator Dashboard</a></li>

                        

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

                          @if(Auth::check())

                          <li><a href="{{ URL::to('logout/@den2') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

                          @else

                          <li><a href="{{ URL::to('login/@den2') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

                          @endif

     					</ul>

                </div>                               

            </div>

         </div>

         <br> <br> <br>

         <!-- end of navbar -->
