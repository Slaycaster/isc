@extends("layout")
@section("content")

<h1>Create Objective</h1>

{{ Form::open(array('route' => 'objectives.store')) }}

       
            {{ Form::label('ObjectiveName', 'ObjectiveName:') }}
            {{ Form::text('ObjectiveName') }}<br>
        

	
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
	
{{ Form::close() }}

@if ($errors->any())

		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	
@endif

@stop


