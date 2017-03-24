@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Measure Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update a Measure</strong>
	</div>
		<div class="panel-body">
		{{ Form::model($Measure, array('method' => 'PATCH', 'route' => array('measures.update', $Measure->id))) }}
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
                        <div>{{ Form::label('MeasureName', 'Measure Name:') }}</div>
                        <div style='color:black'>{{ Form::text('MeasureName', Input::get('MeasureName'), array('placeholder' => 'Measure Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Measure Name', array('class' => 'btn btn-lg btn-success')) }}
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
