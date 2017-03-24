@extends('layouts.scaffold')

@section('main')

<h1>Create Unit_office_secondary</h1>

{{ Form::open(array('route' => 'unit_office_secondaries.store')) }}
	<ul>
        <li>
            {{ Form::label('UnitOfficeSecondaryName', 'UnitOfficeSecondaryName:') }}
            {{ Form::text('UnitOfficeSecondaryName') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeHasTertiary', 'UnitOfficeHasTertiary:') }}
            {{ Form::text('UnitOfficeHasTertiary') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeID', 'UnitOfficeID:') }}
            {{ Form::input('number', 'UnitOfficeID') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


