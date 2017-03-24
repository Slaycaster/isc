@extends("layout")
@section("content")
 
<div class="label_white">
	<h1>Main Activities Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update a Rank</strong>
	</div>
	<div class="panel-body">
{{ Form::model($main_activity, array('method' => 'PATCH', 'route' => array('main_activities.update', $main_activity->id))) }}
	<fieldset>
                <div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group">
                      <div class="input-group">
                        @if ($errors->any())
                            <ul>
                                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                            </ul>
                        @endif
                      </div>
                    </div>
                        <div class="form-group"> 
                          <div>{{ Form::label('MainActivityName', 'Main Activity Name:') }}</div>
                          <div style='color:black'>{{ Form::text('MainActivityName', Input::get('MainActivityName'), array('placeholder' => 'Activity Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>
     
                        <div class="form-group">
                          {{ Form::submit('Update Main Activities', array('class' => 'btn btn-lg btn-success')) }}
                        </div>
                  </div>
                </div>
              </fieldset>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
	</div>
</div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
@stop
