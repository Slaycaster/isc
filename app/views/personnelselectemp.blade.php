@extends("layout-employee")

@section("content")

<head>

    <title>Administrator - Key Performance Indicator (KPI)| PNP Scorecard System</title>

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
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">

    <br><center><div class="text_paragraph">

    <p style="font-size: 30px"><strong>ANALYSIS REPORT - KEY PERFORMANCE INDICATOR (KPI)</strong> </p>

  </div></center>



  <hr>

  </div>
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
          {{ Form::open(array('target' => '_blank', 'url' => 'employee/dashboard/subgraph', 'method' => 'post')) }}
              <h4>Individual Analysis Report</h4><hr>
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
                        <table class="table" id="example">
                          <thead>
                              <tr>  
                                  <th>Rank</th>     
                                  <th>Last Name</th>
                                  <th>First Name</th>
                                  <th>Select</th>
                              </tr>
                          </thead>
                          <tbody>
                          @foreach ($employs as $employ)
                         <tr>
                              <td style='color:black'>
                                  {{$employ->RankCode}}
                              </td>
                              <td style='color:black'>
                                  {{$employ->EmpLastName}}
                              </td>
                              <td>
                                 {{$employ->EmpFirstName}}
                              </td>
                              <td>
                                {{Form::radio('emp_id', $employ->id, false)}}
                              </td>
                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                       </div>
                  </div>
                      </div>
                      <div class="form-group col-md-12">
                        {{ Form::submit('Click to View', array('class' => 'btn btn-primary btn-block', 'name' => 'analysis')) }}
                      </div>

                </fieldset>

              {{ Form::close() }}
          </div>

        </div>

    </div>
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

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>
@stop