@extends("layout")
@section("content")

<head>
    <title>Personnel | PNP Scorecard System</title>
</head>
<div class="label_white">
    <div class="row">
        <div class="col-md-12">
            <h1><strong><center>Remove / Suspend Personnel</center></strong></h1>
            <br>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
        </div>
        <div class="col-md-12">
            @if (Session::has('message2'))
                <div class="alert alert-danger">{{ Session::get('message2') }}</div>
            @endif
        </div>
    </div>

    <div class="row">
        <!--ALL ACTIVITIES-->
        <div class="col-md-12">
            <div class="panel panel-primary" style="margin-bottom:30px">
                <div class="panel-heading">
                    <strong>All Personnel</strong>
                </div>
                <div class="panel-body  table-responsive">
                    <table class="table" id="personnels-table" width="100%">
                        <thead>
                            <tr>       
                                <th></th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Rank</th>
                                <th>Position</th>
                                <th>Unit Office</th>
                                <th>Supervisor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      $('#personnels-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: 'employeestatusindex/tempdatatable',
          columns: 
          [
              { data: 'Picture', name: 'Picture', orderable: false, searchable: false},
              { data: 'EmpLastName', name: 'Last Name' },
              { data: 'EmpFirstName', name: 'First Name' },
              { data: 'RankName', name: 'Rank' },
              { data: 'PositionName', name: 'Position' },
              { data: 'UnitOffice', name: 'Unit Office' },
              { data: 'Supervisor', name: 'Supervisor' },
              { data: 'Actions', name: 'Actions', orderable: false, searchable: false}
          ]
      });
  });
</script>
<!--
<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable();
  } );
</script>
-->


@stop
