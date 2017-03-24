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

                    <li><p style="color:white; margin-top:7%">PNP e-PGS Individual Scorecard</p> </li>    

                </ul>  

                 <ul class="nav navbar-nav navbar-right">
                        <li><a href ="{{URL::to('login/employee')}}"><b>Personnel</b></a></li>
              

                        <li><a href ="{{URL::to('login/unitadmin')}}">Unit Admin</a></li>
                    }

                 </ul>

                </div>                               

            </div>

         </div>

         <br> <br> <br>

         <!-- end of navbar -->
