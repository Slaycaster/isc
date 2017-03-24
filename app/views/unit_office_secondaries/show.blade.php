@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Unit Office Secondary Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Unit Office Secondary</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Secondary Unit Office Name</th>
							<th>Unit Office</th>
							<th>Unit Office Has Quaternary</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $unit_office_secondary->UnitOfficeSecondaryName}}}</td>
							
							<td>
								@foreach ($unit_offices as $unit_office)
		                            @if ($unit_office->id == $unit_office_secondary->UnitOfficeID)
		                              {{  $unit_office->UnitOfficeName }}
		                            @endif
		                        @endforeach
                    		</td>
							<td>
		                        {{$unit_office_secondary->UnitOfficeHasTertiary}}
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
