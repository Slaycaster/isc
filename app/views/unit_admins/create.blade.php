@extends('layouts.scaffold')

@section('main')

<h1>Create Unit_admin</h1>

{{ Form::open(array('route' => 'unit_admins.store')) }}
	<ul>
        <li>
            {{ Form::label('LastName', 'LastName:') }}
            {{ Form::text('LastName') }}
        </li>

        <li>
            {{ Form::label('FirstName', 'FirstName:') }}
            {{ Form::text('FirstName') }}
        </li>

        <li>
            {{ Form::label('UserName', 'UserName:') }}
            {{ Form::text('UserName') }}
        </li>

        <li>
            {{ Form::label('Password', 'Password:') }}
            {{ Form::text('Password') }}
        </li>

        <li>
            {{ Form::label('UnitOfficeID', 'UnitOfficeID:') }}
            {{ Form::input('number', 'UnitOfficeID') }}
        </li>

        <li>
            {{ Form::label('SecondaryUnitOffice', 'SecondaryUnitOffice:') }}
            {{ Form::input('number', 'SecondaryUnitOffice') }}
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


