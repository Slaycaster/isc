@extends("layout")
@section("content")

<head>
    <title>Objectives | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Objective Maintenance</h1>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE Objective-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create an Objective</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'objectives.store')) }}
              <fieldset>
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                    <div class="form-group">
                      <div class="input-group">
                        @if ($errors->any())
                            <ul>
                                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                            </ul>
                        @endif
                      </div>
                    </div>
                    
                    <div class="form-group">
                        <div>{{ Form::label('ObjectiveName', 'Objective Name:') }}</div>
                        <div style='color:black'>{{ Form::text('ObjectiveName', Input::get('ObjectiveName'), array('placeholder' => 'Objective Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('PerspectiveID', 'Perspective:') }}</div>
                        <div style='color:black'>{{ Form::select('PerspectiveID', $perspectives_id, Input::old('PerspectiveID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Create Objective', array('class' => 'btn btn-lg btn-success btn-block')) }}
                    </div>
                  </div>
                </div>
              </fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>

    <!--ALL PERSPECTIVE-->
    <div class = "col-md-8">
      <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>All Objectives</strong>
            </div>

            <div class="panel-body table-responsive">
              <table class="table" id="users-table">
                <thead>
                    <tr class="filters">       
                        <th>Objective Name</th>
                        <th>Perspective</th>
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
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'objective',
        columns: [
      
            { data: 'ObjectiveName', name: 'ObjectiveName' },
            { data: 'PerspectiveName', name: 'PerspectiveName' },
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
      $('#example').DataTable();
  } );
</script>

@stop