@extends('layouts.scaffold')

@section('main')

<h1>Create Unit_office_tertiary</h1>

{{ Form::open(array('route' => 'unit_office_tertiaries.store')) }}
	<ul>
        <li>
            {{ Form::label('UnitOfficeTertiaryName', 'UnitOfficeTertiaryName:') }}
            {{ Form::text('UnitOfficeTertiaryName') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeHasQuaternary', 'UnitOfficeHasQuaternary:') }}
            {{ Form::text('UnitOfficeHasQuaternary') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeSecondaryID', 'UnitOfficeSecondaryID:') }}
            {{ Form::input('number', 'UnitOfficeSecondaryID') }}
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


