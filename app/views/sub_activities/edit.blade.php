@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Sub-activity Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update a Sub-activity</strong>
	</div>
		<div class="panel-body">
		{{ Form::model($sub_activity, array('method' => 'PATCH', 'route' => array('sub_activities.update', $sub_activity->id))) }}
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
                        <div>{{ Form::label('SubActivityName', 'Sub-activity Name:') }}</div>
                        <div style='color:black'>{{ Form::text('SubActivityName', Input::get('SubActivityName'), array('placeholder' => 'Sub-activity','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('MainActivityID', 'Main Activity:') }}</div>
                        <div style='color:black'> {{ Form::select('MainActivityID', $main_activities_id, Input::old('MainActivityID'), array('class' => 'form-control')) }}</div>
                       
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Sub-activity', array('class' => 'btn btn-lg btn-success')) }}
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
