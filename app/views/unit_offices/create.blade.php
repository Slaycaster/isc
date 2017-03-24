@extends('layouts.scaffold')

@section('main')

<h1>Create Unit_office</h1>

{{ Form::open(array('route' => 'unit_offices.store')) }}
	<ul>
        <li>
            {{ Form::label('UnitOfficeName', 'UnitOfficeName:') }}
            {{ Form::text('UnitOfficeName') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeHasField', 'UnitOfficeHasField:') }}
            {{ Form::text('UnitOfficeHasField') }}
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


