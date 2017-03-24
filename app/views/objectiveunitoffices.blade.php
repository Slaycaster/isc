@extends("layout")

@section("content")



<head>

    <title>Unit/Offices Objectives | PNP Scorecard System</title>

</head>



<div class="label_white">

  <div class="row">

    <div class="col-md-12">

      <h1><strong><center>Unit/Offices Objective</center></strong></h1>

      <br>

    </div>

  </div>

  <div class="col-md-12">

@if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div>

    @endif

</div>

</div>


 


<div class="row">
  <div class="col-md-12">

                      {{ Form::open(array('url' => 'office_objectives', 'method' => 'post')) }}

                  <div class="panel panel-primary">

                      <div class="panel-heading">


                          <strong>Perspective</strong>

                      </div>

                      <div class="panel-body">

                                     

                                         <div style='color:black'>{{ Form::select('PerspectiveID', $perspectives_id, Input::get('PerspectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'perspectives_id', 'tabindex' => '2')) }}</div>

                                         </div>
                    

                  </div>

                      <div class = "panel panel-primary">
                        <div class="panel-heading">


                          <strong>All Primary Unit/Offices</strong>

                        </div>

                            <div class="panel-body">

                              <table class='table table-responsive' id='another-table'>

                                  <thead>

                                    <tr>*Check the box of the objectives you want to assign to certain unit offices</tr>

                                      <br>
                                      <br>
                                        <tr>       

                                          <th>Objectives</th>
                                         <th>Action</th>
                                        </tr>

                                  </thead>

                              </table>

                          </div>
                        </div>




                  <!--Unit Offices -->

                   <div class="col-md-6">
                      <div class = "panel panel-primary">
                        <div class="panel-heading">


                          <strong>All Primary Unit/Offices</strong>

                      </div>

                      <div class="panel-body">

                          <table class='table table-responsive' id='users-table'>

                              <thead>



                                <tr>*Check the box of the Unit Offices you want the objectives assigned to</tr>


                                  <br>
                                  <br>
                                    <tr>       

                                      <th>Unit Offices</th>
                                      <th>Select</th>
                                    </tr>

                              </thead>

                          </table>

                      </div>
                      </div>
                      

                  </div>


                  <!-- Secondary Unit Offices -->


                    <div class="col-md-6">
                      <div class = "panel panel-primary ">
                        <div class="panel-heading">


                          <strong>All Secondary Unit/Office</strong>

                      </div>

                      <div class="panel-body table-responsive">

                          <table class='table table-striped' id='users-tables'>

                              <thead>



                                <tr>*Check the box of the Unit Offices you want the objectives assigned to</tr>


                                  <br>
                                  <br>
                                    <tr>       

                                      <th>Secondary Unit/Office</th>
                                      <th>Select</th>
                                    </tr>

                              </thead>

                          </table>

                      </div>
                      </div>
                      

                  </div>

                  <div class = "row">
                    <div class = "col-md-12">
                      {{ Form::submit('Save Changes', array('class' => 'btn btn-success btn-block')) }}
                    </div>
                  </div>
                  
                  <br><br><br><br>

        </div>

</div>
        

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

   $(document).ready(function()
  {

      //Unit Office dropdown
      $('#perspectives_id').change(function()
      {
         


          var id = $('option:selected').val();
         
          
          var table =  $('#another-table').DataTable();
          table.destroy();


         

          $('#another-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: 'objectives/ajax/'+id,
          columns: [
              { data: 'ObjectiveName', name: 'ObjectiveName' },
              { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
          ]
          });
         

     
    });

      
    

  });

</script>


<script type="text/javascript">

$(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'pri/office_objectives',
        columns: [
      
            { data: 'UnitOfficeName', name: 'UnitOfficeName'},
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#users-tables').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'sec/office_objectives',
        columns: [
      
            { data: 'UnitOfficeSecondaryName', name: 'UnitOfficeSecondaryName'},
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#another-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'obj/office_objectives',
        columns: [
      
            { data: 'ObjectiveName', name: 'ObjectiveName'},
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>



<!-- <script type="text/javascript">

$("#perspectives_id").on('change', function () {

        var year = $("#perspectives_id").val();

        $('tr').hide();

        $("td.AR").each(function (index, tdAR) {

            if ($(tdAR).hasClass("AR_" + year) || $(tdAR).hasClass("AR_exclude") ) {

                $(tdAR).parent('tr').show();

            }

        });

    });</script> -->

<script type="text/javascript">

  $(document).ready(function() {

      $('#example').ddTableFilter();

  } );

</script>

<script type="text/javascript">

  $(document).ready(function() {

      $('#example2').DataTable();

  } );

</script>

@stop

