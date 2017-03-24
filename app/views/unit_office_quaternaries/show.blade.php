@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Unit Office Quaternary Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Unit Office Quaternary</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Quaternary Unit Office Name</th>
							<th>Tertiary Unit Office</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $unit_office_quaternary->UnitOfficeQuaternaryName}}}</td>
							
							<td>
								@foreach($tertiary_unit_offices as $tertiary_unit_office)
                            	@if($tertiary_unit_office->id == $unit_office_quaternary->UnitOfficeTertiaryID)
                            		{{$tertiary_unit_office->UnitOfficeTertiaryName}}
                        		@endif
                        
                        		@endforeach
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
