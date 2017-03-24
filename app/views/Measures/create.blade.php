@extends('layouts.scaffold')

@section('main')

<h1>Create Measure</h1>

{{ Form::open(array('route' => 'Measures.store')) }}
	<ul>
        <li>
            {{ Form::label('MeasureName', 'MeasureName:') }}
            {{ Form::text('MeasureName') }}
        </li>

        <li>
            {{ Form::label('SubActivityID', 'SubActivityID:') }}
            {{ Form::input('number', 'SubActivityID') }}
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


