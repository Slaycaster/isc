@extends('layouts.scaffold')

@section('main')

<h1>Create Measure_target</h1>

{{ Form::open(array('route' => 'measure_targets.store')) }}
	<ul>
        <li>
            {{ Form::label('MeasureTargetValue', 'MeasureTargetValue:') }}
            {{ Form::text('MeasureTargetValue') }}
        </li>

        <li>
            {{ Form::label('MeasureTargetUnitID', 'MeasureTargetUnitID:') }}
            {{ Form::input('number', 'MeasureTargetUnitID') }}
        </li>

        <li>
            {{ Form::label('MeasureID', 'MeasureID:') }}
            {{ Form::input('number', 'MeasureID') }}
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


