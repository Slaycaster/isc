@extends("layout")
@section("content")

<head>
    <title>Unit/Office Quaternaries | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Unit/Office Quaternary Maintenance</h1>
<p><i>(PCP, PPO Section)</i></p>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE Unit/Office Quaternary-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Unit/Office Quaternary</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'unit_office_quaternaries.store')) }}
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
					                    <div>{{ Form::label('UnitOfficeQuaternaryName', 'Quaternary Unit/Office Name:') }}</div>
	            						<div style='color:black'>{{ Form::text('UnitOfficeQuaternaryName', Input::get('UnitOfficeQuaternaryName'), array('placeholder' => 'Unit/Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
	            					</div>


	            					<div class="form-group">
                        				<div>{{ Form::label('UnitOfficeTertiaryID', 'Tertiary Unit/Office:') }}</div>
                        				<div style='color:black'>{{ Form::select('UnitOfficeTertiaryID', $tertiary_unit_offices_id, Input::old('UnitOfficeTertiaryID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                    				</div>
				                    <div class="form-group">
				               			{{ Form::submit('Create Quaternary Unit/Office', array('class' => 'btn btn-lg btn-success btn-block')) }}
				                    </div>
                  				</div>
                  			</div>
		          		</fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>

    <!--ALL RANKS-->
    <div class = "col-md-8">
      <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>All Unit/Office Quaternaries</strong>
            </div>
           
           <div class="panel-body table-responsive">
            <table class="table" id="users-table">
                <thead>
                    <tr class="filters">       
                        <th>Quaternary Name</th>
                        <th>Tertiary Unit/Office Name</th>
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
        ajax: 'uniqua',
        columns: [
      
            { data: 'UnitOfficeQuaternaryName', name: 'UnitOfficeQuaternaryName' },
            { data: 'UnitOfficeTertiaryName', name: 'UnitOfficeTertiaryName' },
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