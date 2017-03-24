@extends("layout")
@section("content")

<h1>Create Perspective</h1>

{{ Form::open(array('route' => 'perspectives.store')) }}

       
            {{ Form::label('PerspectiveName', 'PerspectiveName:') }}
            {{ Form::text('PerspectiveName') }}<br>
        

	
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
	
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


