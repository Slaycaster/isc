@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Unit Office Tertiary Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Unit Office Tertiary</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Tertiary Unit Office Name</th>
							<th>Secondary Unit Office</th>
							<th>Unit Office Has Quaternary</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $unit_office_tertiary->UnitOfficeTertiaryName}}}</td>
							
							<td>
								@foreach($secondary_unit_offices as $secondary_unit_office)
                            	@if($secondary_unit_office->id == $unit_office_tertiary->UnitOfficeSecondaryID)
                            		{{$secondary_unit_office->UnitOfficeSecondaryName}}
                        		@endif
                        
                        		@endforeach
                    		</td>
							<td>
		                        {{{ $unit_office_tertiary->UnitOfficeHasQuaternary}}}
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
