@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Measure Target Unit Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update a Measure Target Unit</strong>
	</div>
		<div class="panel-body">
		{{ Form::model($measure_target_unit, array('method' => 'PATCH', 'route' => array('measure_target_units.update', $measure_target_unit->id))) }}
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
                        <div>{{ Form::label('MeasureTargetUnitName', 'Measure Target Unit Name:') }}</div>
                        <div style='color:black'>{{ Form::text('MeasureTargetUnitName', Input::get('MeasureTargetUnitName'), array('placeholder' => 'Measure Target Unit Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('MeasureTargetUnitSymbol', 'Measure Target Unit Symbol:') }}</div>
                        <div style='color:black'>{{ Form::text('MeasureTargetUnitSymbol', Input::get('MeasureTargetUnitSymbol'), array('placeholder' => 'Measure Target Unit Symbol','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Measure Target Unit', array('class' => 'btn btn-lg btn-success')) }}
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
