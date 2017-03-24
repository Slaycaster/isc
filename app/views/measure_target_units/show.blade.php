@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Measure Target Unit Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Measure Target Unit</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Measure Target Unit Name</th>
							<th>Measure Target Unit Symbol</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $measure_target_unit->MeasureTargetUnitName}}}</td>
							<td>{{{ $measure_target_unit->MeasureTargetUnitSymbol }}}</td>
				                   
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
