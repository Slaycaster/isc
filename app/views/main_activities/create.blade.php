@extends("layout")
@section("content")

<h1>Create Main Activity</h1>

{{ Form::open(array('route' => 'main_activities.store')) }}
	
            {{ Form::label('MainActivityName', 'MainActivityName:') }}
            {{ Form::text('MainActivityName') }} <br>
      
            {{ Form::label('ObjectiveID', 'ObjectiveID:') }}
            {{ Form::input('number', 'ObjectiveID') }} <br>
       
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
	
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


