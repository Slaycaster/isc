@extends('layouts.scaffold')

@section('main')

<h1>Create Measure_target_unit</h1>

{{ Form::open(array('route' => 'measure_target_units.store')) }}
	<ul>
        <li>
            {{ Form::label('MeasureTargetUnitName', 'MeasureTargetUnitName:') }}
            {{ Form::text('MeasureTargetUnitName') }}
        </li>

        <li>
            {{ Form::label('MeasureTargetUnitSymbol', 'MeasureTargetUnitSymbol:') }}
            {{ Form::text('MeasureTargetUnitSymbol') }}
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


