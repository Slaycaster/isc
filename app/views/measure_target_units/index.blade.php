@extends("layout")
@section("content")

<head>
    <title>Measure Target Units | PNP Scorecard System</title>
</head>


<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Measure Target Unit Maintenance</h1>
  
	 <div class ="col-md-4">
    {{ $measure_target_units->links() }}
  </div>
</div>
</div>

<div class="container">
  <div class="row">
    <!--CREATE RANK-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Measure Target Unit</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'measure_target_units.store')) }}
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
                      {{ Form::submit('Create Measure Target Unit', array('class' => 'btn btn-lg btn-success btn-block')) }}
                    </div>
                  </div>
                </div>
              </fieldset>
            {{ Form::close() }}
          </div>
        </div>
    </div>
      <div class = "col-md-8">
      <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <strong>All Measure Target Unit Symbol</strong>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
           
            <table class="table">
                <thead>
                    <tr class="filters">       
                        <th><input type="text" class="form-control" placeholder="Measure Target Unit Name"></th>
                        <th><input type="text" class="form-control" placeholder="Measure Target Unit Symbol"></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($measure_target_units as $measure_target_unit)
                <tr>

                    <td style='color:black'>
                        {{$measure_target_unit->MeasureTargetUnitName}} 
                    </td>
                    <td style='color:black'>
                        {{$measure_target_unit->MeasureTargetUnitSymbol}}
                    </td>

                    <td>
                       <a class = 'btn btn-warning' href="{{ URL::to('measure_target_units/' . $measure_target_unit->id) }}" onclick="window.open('{{ URL::to('measure_target_units/' . $measure_target_unit->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                        <a class = 'btn btn-info'  href="{{ URL::to('measure_target_units/' . $measure_target_unit->id . '/edit') }}" onclick="window.open('{{ URL::to('measure_target_units/' . $measure_target_unit->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
                    </td>

                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@stop
