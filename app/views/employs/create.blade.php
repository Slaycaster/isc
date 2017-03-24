@extends('layouts.scaffold')

@section('main')

<h1>Create Employ</h1>

{{ Form::open(array('route' => 'employs.store')) }}
	<ul>
        <li>
            {{ Form::label('EmpID', 'EmpID:') }}
            {{ Form::text('EmpID') }}
        </li>

        <li>
            {{ Form::label('EmpFirstName', 'EmpFirstName:') }}
            {{ Form::text('EmpFirstName') }}
        </li>

        <li>
            {{ Form::label('EmpLastName', 'EmpLastName:') }}
            {{ Form::text('EmpLastName') }}
        </li>

        <li>
            {{ Form::label('EmpMidInit', 'EmpMidInit:') }}
            {{ Form::text('EmpMidInit') }}
        </li>

        <li>
            {{ Form::label('EmpQualifier', 'EmpQualifier:') }}
            {{ Form::text('EmpQualifier') }}
        </li>

        <li>
            {{ Form::label('EmpPicturePath', 'EmpPicturePath:') }}
            {{ Form::text('EmpPicturePath') }}
        </li>

        <li>
            {{ Form::label('RankID', 'RankID:') }}
            {{ Form::input('number', 'RankID') }}
        </li>

        <li>
            {{ Form::label('PositionID', 'PositionID:') }}
            {{ Form::input('number', 'PositionID') }}
        </li>

        <li>
            {{ Form::label('SupervisorID', 'SupervisorID:') }}
            {{ Form::text('SupervisorID') }}
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


