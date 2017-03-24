@extends("layout")
@section("content")

<h1>Create Sub Activity</h1>

{{ Form::open(array('route' => 'sub_activities.store')) }}

       
            {{ Form::label('SubActivityName', 'SubActivityName:') }}
            {{ Form::text('SubActivityName') }}<br>
        

       
            {{ Form::label('MainActivityID', 'MainActivityID:') }}
            {{ Form::text('MainActivityID') }}<br>
        

	
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		
	
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


