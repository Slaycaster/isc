@extends("layout-unitadmin")

@section("content")

<head>

    <title>Remove Employee Activity | PNP Scorecard System</title>

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

<div class="container" style="margin-top:3%">

  <div class="col-md-12" style="margin-bottom:15px; color:white;">

    <center><div class="text_paragraph">

    <p style="font-size: 30px"><strong>REMOVE ACTIVITY</strong></p>
    @foreach($emp as $emps)
      <center><p style="font-size: 15px">for <strong> {{$emps->RankCode}} {{$emps->EmpLastName}}, {{$emps->EmpFirstName}} {{$emps->EmpMidInit}} </strong></p></center>
    @endforeach
  </div></center>



    <hr>

    </div>

  <div class = "col-md-12">

      <div class="panel panel-default">

          <div class="panel-heading">

           

            </div>

            <div class="panel-body">
            @if (Session::has('message'))
              <div class="alert alert-success">{{ Session::get('message') }}</div><br>
          @endif

              <div class="alert alert-warning"><h4 style= 'color:black; font-weight:bolder'>NOTE:</h4><p style= 'color:black;'>These are your activities which aren't placed in your scorecard yet, this means that your current and past scorecard records aren't affected whatsoever. You can safely remove these if you feel they're just typographical errors, irrelevant to your scorecard and such.
               <br><br>If you want to remove just the Main Activity's sub-activities instead, click "Show its Sub-activities" button to do so.</p> <hr></div><br>

              
                    <div class="form-group">

                      

                      <div class="panel panel-primary">

                      <div class="panel-heading">

                          <strong>Main Activities</strong>

                      </div>

                       <div class="panel-body table-responsive">
         {{ Form::open(array('url' => 'employee/uadeletemain', 'method' => 'post')) }}
         
                             {{ Form::hidden('emp_id', $emp_id) }}

                        <table id="example">

                          
                          <thead>

                              <tr>       
                                  
                                  <th>Main Activity</th>

                                  <th>Remove Main Activity</th>

                                  <th>Remove Sub-activities</th>

                              </tr>

                          </thead>

                          <tbody>

                                      @foreach($main_activities as $main)
                                <tr>

                                 
                                <td style='color:black'>
                                            {{$main->MainActivityName}}
                                
                                </td>
                                <td>
                                    {{Form::checkbox('main_id[]', $main->id, false, array('style' => 'width:25px; height:25px;'))}}
                                </td>

                                 <td>
                                      <a class = 'btn btn-warning' style= "margin-bottom:5px" href="{{ URL::to('UAremoveEmpSub/' . $main->id) }}" onclick="window.open('{{ URL::to('UAremoveEmpSub/' . $main->id) }}', 'newwindow'); return false;">Show its Sub-activities</a>
                                </td>

                              </tr>
                          
                          
                                      @endforeach
                          </tbody>
                      </table>

                  
                       </div>

                                   <a class="btn btn-danger" href="#" data-toggle="modal" style="margin-top:10px; padding-top:10px; padding-bottom:10px; float: right;" data-target="#mainModal">Delete Main Activities</a>
                  
                                <div class="col-md-12">

                                  
                                  <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                      <label for="exampleInputEmail1">Are you sure you want to delete this Main Activity?</label>     
                                    </div>


                                    <div class="modal-body">
                                      
                                            <!-- content goes here -->

                                            <p>Deleting this Main Activities will also delete their corresponding Sub Activities and Measures</p>
                                      

                                    </div>
                                    <div class="modal-footer">
                                                                             
                                    <p style = "text-align:left; margin-bottom: -25px"><strong>Confirm deletion?</strong></p>
                                    <!--<input class = 'btn btn-success' type="submit" value="Ok">-->

                                    <input class = 'btn btn-success' type="submit" name="Delete" value="Yes (Remove)">
                                    <input class = 'btn btn-default' type="submit" name="Submit" data-dismiss="modal" value="No (Cancel)">    

                                   

                                    </div>
                                  </div>
                                  </div>  
                                </div>

                            </div>
                  </div>
               </div>

               </div>
        </div>




    </div>

</div>
  {{Form::close()}}
<script type="text/javascript">

  $(document).ready(function() {

      $('#example').DataTable();

  } );

</script>


@stop





                               