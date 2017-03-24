<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

    <link rel="icon" href="{{ URL::asset('img/pnp_logo_HrX_icon.ico') }}" type="image/x-icon"/>

    <link rel="shortcut icon" href="{{ URL::asset('img/pnp_logo_HrX_icon.ico') }}" type="image/x-icon"/>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style-employee.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/fdpf.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/datepicker3.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.foundation.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.foundation.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.jqueryui.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dataTables.jqueryui.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.dataTables.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.dataTables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.dataTables_themeroller.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('jquery-ui-1.11.4/jquery-ui.min.css') }}">


     <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/cropper.css') }}">

     <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">

      <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}">



    

    <script src="{{ URL::asset('jquery-ui-1.11.4/external/jquery/jquery.js')}}"></script>

    <script src="{{ URL::asset('jquery-ui-1.11.4/jquery-ui.min.js')}}"></script>  

    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.bootstrap.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.foundation.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.foundation.min.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.jqueryui.js') }}"></script>

    <script src="{{ URL::asset('js/dataTables.jqueryui.min.js') }}"></script>

    <script src="{{ URL::asset('js/jquery.dataTables.js') }}"></script>

    <script src="{{ URL::asset('js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ URL::asset('js/jquery-bootstrap-modal-steps.js')}}"></script>

      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.1/angular.min.js"></script>

      <script src="{{ URL::asset('js/cropper.js') }}"></script>

      <script src="{{ URL::asset('js/main2.js') }}"></script>

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



  </head>

  <body>



    <div class = "container">

      @include("includes.header_employee")

       @yield("content")

    </div>

      



           





    <div class = "footer">

      @include("includes.footer")

    </div>



    

      

  </body>

</html>





