@extends("layout")
@section("content")

<head>
    <title>Unit/Office Secondaries | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Unit/Office Secondary Maintenance</h1>
<p><i>(NCRPO District, PPO/CPO, RPSB, RHQ-NSU Division/Office)</i></p>
  
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE RANK-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Unit/Office Secondary</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'unit_office_secondaries.store')) }}
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
					                    <div>{{ Form::label('UnitOfficeSecondaryName', 'Secondary Unit/Office Name:') }}</div>
	            						<div style='color:black'>{{ Form::text('UnitOfficeSecondaryName', Input::get('UnitOfficeSecondaryName'), array('placeholder' => 'Unit/Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
	            					</div>


	            					<div class="form-group">
                        				<div>{{ Form::label('UnitOfficeID', 'Primary Unit/Office:') }}</div>
                        				<div style='color:black'>{{ Form::select('UnitOfficeID', $unit_offices_id, Input::old('UnitOfficeID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                    				</div>

	            					<div class="form-group">
				                        <div>{{ Form::label('UnitOfficeHasTertiary', 'Secondary has Tertiary:') }}</div>
				                      

				                        <div class='col-md-12' style="margin-left:-10%">
					                        <div class='col-md-6'>
					                        	<div style='color:black'>{{Form::radio('UnitOfficeHasTertiary', 'True', true)}} True</div>
					                        </div>
					                        <div class='col-md-6'>
					                        	<div style='color:black'>{{Form::radio('UnitOfficeHasTertiary', 'False', true)}} False</div>
					                        	</div>
				                        </div>
				                    </div>
									<br><br>
				                    <div class="form-group">
				               			{{ Form::submit('Create Secondary Unit/Office', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
                <strong>All Unit/Office Secondaries</strong>
            </div>

            <div class="panel-body table-responsive">
              <table class="table table-striped" id="users-table">
                <thead>
                    <tr class="filters">       
                        <th>Secondary Name</th>
                        <th>Primary Unit/Office</th>
                        <th>Secondary has Tertiary</th>
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
        ajax: 'unisec',
        columns: [
      
            { data: 'UnitOfficeSecondaryName', name: 'UnitOfficeSecondaryName' },
            { data: 'UnitOfficeName', name: 'UnitOfficeName' },
            { data: 'UnitOfficeHasTertiary', name: 'UnitOfficeHasTertiary' },
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