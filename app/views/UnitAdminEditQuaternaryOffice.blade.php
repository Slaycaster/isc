@extends('layout-noheader2')
@section('content')

<div class="label_white">
<h1>Unit Office Quaternary Maintenance</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Update a Unit Office Quaternary</strong>
    </div>
        <div class="panel-body">
        {{ Form::model($unit_office_quaternary, array('method' => 'PATCH', 'route' => array('UnitAdminQuaternaryOffice.update', $unit_office_quaternary->id))) }}
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
					                    <div>{{ Form::label('UnitOfficeQuaternaryName', 'Quaternary Unit Office Name:') }}</div>
	            						<div style='color:black'>{{ Form::text('UnitOfficeQuaternaryName', Input::get('UnitOfficeQuaternaryName'), array('placeholder' => 'Unit Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
	            					</div>


	            					<div class="form-group">
                        				<div>{{ Form::label('UnitOfficeTertiaryID', 'Unit Office:') }}</div>
                        				<div style='color:black'>{{ Form::select('UnitOfficeTertiaryID', $tertiary_unit_offices_id, Input::old('UnitOfficeTertiaryID'), array('class' => 'btn btn-default dropdown-toggle form-control')) }}</div>
                    				</div>
				                    <div class="form-group">
				               			{{ Form::submit('Update Quaternary Unit Office', array('class' => 'btn btn-lg btn-success')) }}
				                    </div>
                  				</div>
                  			</div>
		          		</fieldset>
        {{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif
</div>
</div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" style="margin-bottom:10%" class="btn btn-warning">Close</a>
@stop
