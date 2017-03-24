@extends("layout")
@section("content")

<head>
    <title>Measure Target | PNP Scorecard System</title>
</head>


<div class="label_white">
<div class="col-md-12" style="margin-top:-10px; margin-bottom:15px">
<h1>Measure Target Maintenance</h1>
  
	 <div class ="col-md-4">
   
   </div>
</div>
</div>




<div class="container">
  <div class="row">
    <!--CREATE RANK-->
    <div class = "col-md-4">
      <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Create a Measure Target</strong>
          </div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'measure_targets.store')) }}
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

                     <div class="panel panel-primary filterable">
                        <div class="panel-heading">
                            <strong>All Measure </strong>
                            <div class="pull-right">
                           
                            </div>
                        </div>
           
                            <table class="table">
                                <thead>
                                <tr class="filters">       
                                    <th><input type="text" class="form-control" placeholder="Measure ID"></th>
                                    <th><input type="text" class="form-control" placeholder="Measure Name"></th>
                                    <th>Select</th>
                                </tr>
                                </thead>
                            <tbody>
                            @foreach ($measures as $measure)
                            <tr>

                            <td style='color:black'>
                            {{$measure->id}} 
                            </td>
                            <td style='color:black'>
                            {{$measure->MeasureName}}
                            </td>
                            <td align="center">{{ Form::checkbox($measure->id, $measure->id)}}</td>

                            

                            </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>

                    <div class="form-group">
                      {{ Form::submit('Create Measure Target', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
                        <th><input type="text" class="form-control" placeholder="Measure Name" size="10"></th>
                        <th><input type="text" class="form-control" placeholder="Measure Target Unit" size="15"></th>
                        <th><input type="text" class="form-control" placeholder="Measure Target Value" size="15"></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($measure_targets as $measure_target)
                <tr>

                    <td style='color:black'>
                         @foreach($measures as $measure)
                            @if($measure->id == $measure_target->MeasureID)
                            {{$measure->MeasureName}}
                        @endif
                        
                        @endforeach
                        
                    </td>
                    
                    <td style='color:black'>
                        @foreach($measure_target_units as $measure_target_unit)
                            @if($measure_target_unit->id == $measure_target->MeasureTargetUnitID)
                            {{$measure_target_unit->MeasureTargetUnitName}}({{$measure_target_unit->MeasureTargetUnitSymbol}})
                        @endif
                        @endforeach
                    </td>
                    
                    <td style='color:black'>
                            {{$measure_target->MeasureTargetValue}} 
                    </td>
                        
                    <td>
                       <a class = 'btn btn-warning' href="{{ URL::to('measure_targets/' . $measure_target->id) }}" onclick="window.open('{{ URL::to('measure_targets/' . $measure_target->id) }}', 'newwindow', 'width=450, height=500'); return false;">View</a>
                        <a class = 'btn btn-info'  href="{{ URL::to('measure_targets/' . $measure_target->id . '/edit') }}" onclick="window.open('{{ URL::to('measure_targets/' . $measure_target->id . '/edit') }}', 'newwindow', 'width=450, height=450'); return false;">Edit</a>
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
