@extends("layout-unitadmin")

@section("content")



<head>

    <title>Unit Offices Objectives | PNP Scorecard System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>



<div class="label_white">

  <div class="row">
    <div class="col-md-12" style="margin-top:-10px; margin-bottom:15px; color:white;">
      <br>
        <center>
          <div class="text_paragraph">
            <p style="font-size: 30px"><strong>Unit Office's Objectives - {{ $OfficeName }}</strong> </p>
          </div>
        </center>
      <hr>
    </div>

  </div>

  <div class="col-md-12">

@if (Session::has('message'))

      <div class="alert alert-success">{{ Session::get('message') }}</div>

    @endif

</div>

</div>


 


<div class="row">
   <div class="panel panel-primary">

                      <div class="panel-heading">


                          <strong>Perspective</strong>

                      </div>

                      <div class="panel-body">

                                     

                                         <div style='color:black'>{{ Form::select('PerspectiveID', $perspectives_id, Input::get('PerspectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control','id' => 'perspectives_id', 'tabindex' => '2')) }}</div>

                                         </div>
                    

                  </div>
  <div class="col-md-12">

                      {{ Form::open(array('url' => 'UAEofficeobjectives', 'method' => 'post')) }}



                  <div class="panel panel-primary">

                      <div class="panel-heading">


                          <strong>All Objectives</strong>

                      </div>

                      <div class="panel-body table-responsive">

                          <table class='table table-striped' id="users-table2">

                              <thead>



                                <tr>*Check the box of the objectives you want to assign to certain unit offices</tr>
                      
                            

                                  <tr>
                                      <th>Objectives</th>
                                      <th>Action</th>

                                  </tr>

                                 

                              </thead>

                             

                          </table>

                          

                      </div>

                  </div>



                  <!-- Secondary unit offices -->



                   <div class="panel panel-primary">

                      <div class="panel-heading">


                          <strong>Secondary Unit Offices</strong>

                      </div>

                      <div class="panel-body table-responsive">

                          <table class='table table-striped' id='users-table'>

                              <thead>



                                <tr>*Check the box of the Unit Offices you want the objectives assigned to</tr>


                                  <br>
                                  <br>
                                    <tr>       
                                      <th>Secondary Offices Name</th>
                                      <th>Action</th>
                                    </tr>

                              </thead>

                             

                          </table>

                      </div>

                  </div>


                  {{ Form::submit('Save', array('class' => 'btn btn-lg btn-success')) }}
                  <br><br><br><br>

        </div>

</div>
        







<!--
<script type="text/javascript">

$("#perspectives_id").on('change', function () {

        var year = $("#perspectives_id").val();

        $('tr').hide();

        $("td.AR").each(function (index, tdAR) {

            if ($(tdAR).hasClass("AR_" + year) || $(tdAR).hasClass("AR_exclude") ) {

                $(tdAR).parent('tr').show();

            }

        });

    });</script>
-->

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

   $(document).ready(function()
  {

      //Unit Office dropdown
      $('#perspectives_id').change(function()
      {
         


          var id = $('option:selected').val();

          
          var table =  $('#users-table2').DataTable();
          table.destroy();


         

          $('#users-table2').DataTable({
          processing: true,
          serverSide: true,
          ajax: 'UAEofficeobjectives/objectives/ajax/'+id,
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
        ajax: 'UAEofficeobjectives/secondaryoffices',
        columns: [
            { data: 'UnitOfficeSecondaryName', name: 'UnitOfficeSecondaryName' },
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>


<script type="text/javascript">
  $(document).ready(function() {
      $('#users-table').DataTable();
  } );
</script>



<script type="text/javascript">

$(document).ready(function() {
    $('#users-table2').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'UAEofficeobjectives/objectives',
        columns: [
            { data: 'ObjectiveName', name: 'ObjectiveName' },
            { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
        ]
    });
});

</script>


<script type="text/javascript">
  $(document).ready(function() {
      $('#users-table2').DataTable();
  } );
</script>


@stop

