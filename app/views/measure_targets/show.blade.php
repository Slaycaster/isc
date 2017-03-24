@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Measure Target Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Measure Target</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
						<th>Measure Name</th>
                        <th>Measure Target Unit</th>
                        <th>Measure Target Value</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>
								@foreach($measures as $measure)
                            	@if($measure->id == $measure_target->MeasureID)
                            		{{$measure->MeasureName}}
                        		@endif
                        
                        		@endforeach
                    		</td>
							<td>
		                        @foreach($measure_target_units as $measure_target_unit)
		                            @if($measure_target_unit->id == $measure_target->MeasureTargetUnitID)
		                            {{$measure_target_unit->MeasureTargetUnitName}}({{$measure_target_unit->MeasureTargetUnitSymbol}})
		                        @endif
		                        @endforeach
		                    </td>
		                    
		                    <td>
		                            {{$measure_target->MeasureTargetValue}} 
		                    </td>
				                   
						</tr>
					</tbody>
				</table>
					</div>
				</div>	
		</fieldset>
		</div>
</div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
@stop
