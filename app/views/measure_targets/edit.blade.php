@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Measure Target Maintenance</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Update a Measure Target</strong>
    </div>
        <div class="panel-body">
        {{ Form::model($measure_target, array('method' => 'PATCH', 'route' => array('measure_targets.update', $measure_target->id))) }}
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
                        <div>{{ Form::label('MeasureTargetValue', 'Measure Target Value:') }}</div>
                        <div style='color:black'>{{ Form::text('MeasureTargetValue', Input::get('MeasureTargetValue'), array('placeholder' => 'Measure Target Value','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('MeasurTargetUnitID', 'Measure Target Unit') }}</div>
                        <div style='color:black'>
                        {{ Form::select('measure_target_units_id', $measure_target_units_id, Input::old('measure_target_units_id'), array('class' => 'form-control')) }}</div>
                    </div>

                     

                    <div class="form-group">
                      {{ Form::submit('Update Measure Target', array('class' => 'btn btn-lg btn-success')) }}
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
