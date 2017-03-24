

<!-- contains navbar -->

        <div id="blue-bootstrap-menu" class = "navbar navbar-default navbar-fixed-top">

            <div class = "container-fluid">

                               

                <a href="{{ URL::to('/') }}" class = "navbar-brand"><img style ="height:30px; margin-top:-4px;"src="https://s3-ap-southeast-1.amazonaws.com/pnp-isc/assets/pnp_pahalang.png"/></a>

                               

                <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                        <span class = "icon-bar"></span>

                </button>

                               

                <div class = "collapse navbar-collapse navHeaderCollapse navbar-menubuilder">

                               

                        <ul class = "nav navbar-nav">

                            <li><a href = "{{ URL::to('employee/dashboard') }}">Dashboard</a></li>

                        

                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                          @if($name == null)



                          @else

                          <li><a href="{{ URL::to('employee/dashboard') }}" style="color:white">Hi, {{ $name }}  </a></li>

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

         <br> <br> <br>

         <!-- end of navbar -->
