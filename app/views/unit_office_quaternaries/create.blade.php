@extends('layouts.scaffold')

@section('main')

<h1>Create Unit_office_quaternary</h1>

{{ Form::open(array('route' => 'unit_office_quaternaries.store')) }}
	<ul>
        <li>
            {{ Form::label('UnitOfficeQuaternaryName', 'UnitOfficeQuaternaryName:') }}
            {{ Form::text('UnitOfficeQuaternaryName') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeQuaternaryID', 'UnitOfficeQuaternaryID:') }}
            {{ Form::input('number', 'UnitOfficeQuaternaryID') }}
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


