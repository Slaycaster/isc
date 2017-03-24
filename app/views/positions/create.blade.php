@extends('layout')
@section('content')

<h1>Create Position</h1>

<div class="label_white">
{{ Form::open(array('route' => 'positions.store')) }}
	<ul>
        <li>
            {{ Form::label('PositionCode', 'PositionCode:') }}
            {{ Form::text('PositionCode') }}
        </li>

        <li>
            {{ Form::label('PositionName', 'PositionName:') }}
            {{ Form::text('PositionName') }}
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
</div>

@stop


