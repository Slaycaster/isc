@extends('layouts.scaffold')

@section('main')

<h1>Create Rank</h1>

{{ Form::open(array('route' => 'ranks.store')) }}
	<ul>
        <li>
            {{ Form::label('RankName', 'RankName:') }}
            {{ Form::text('RankName') }}
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


