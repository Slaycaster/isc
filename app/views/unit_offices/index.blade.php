@extends('layout')
@section('content')

<head>
    <title>Unit/Offices | PNP Scorecard System</title>
</head>

<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Unit/Offices Maintenance</h1>
<p><i>(PROs, NSUs, D-Staff, P-Staff)</i></p>
</div>
</div>

<div class="container">
	<div class="row">
		<!--CREATE UNIT/OFFICES-->
    		<div class = "col-md-4">
    			<div class="panel panel-default">
    				<div class="panel-heading">
		            	<strong>Create an Unit/Offices</strong>
		          	</div>
		          	<div class="panel-body">
		          		{{ Form::open(array('route' => 'unit_offices.store')) }}
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
					                    <div>{{ Form::label('UnitOfficeName', 'Unit/Office Name:') }}</div>
	            						<div style='color:black'>{{ Form::text('UnitOfficeName', Input::get('UnitOfficeName'), array('placeholder' => 'Unit/Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
	            					</div>

	            					<div class="form-group">
				                        <div>{{ Form::label('UnitOfficeHasField', 'Unit/Office has Secondary?:') }}</div>
				                      

				                        <div class='col-md-12' style="margin-left:-10%">
					                        <div class='col-md-6'>
					                        	<div style='color:black'>{{Form::radio('UnitOfficeHasField', 'True', true)}} True</div>
					                        </div>
					                        <div class='col-md-6'>
					                        	<div style='color:black'>{{Form::radio('UnitOfficeHasField', 'False', true)}} False</div>
					                        	</div>
				                        </div>
				                    </div>
									<br><br>
				                    <div class="form-group">
				               			{{ Form::submit('Create Unit/Office', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
		                <strong>All Unit/Offices</strong>
		            </div>

		            <div class="panel-body">
		            	<table class="table" id="users-table">
		                <thead>
		                    <tr class="filters">       
		                        <th>Unit/Office Name</th>
		                        <th>Unit/Office Has Field</th>
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
        ajax: 'unit_office/unipri',
        columns: [
      
            { data: 'UnitOfficeName', name: 'UnitOfficeName' },
            { data: 'UnitOfficeHasField', name: 'UnitOfficeHasField' },
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
