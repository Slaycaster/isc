@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Unit Office Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Unit Office</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Unit Office Name</th>
							<th>Unit Office has Field</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $unit_office->UnitOfficeName}}}</td>
							<td>{{{ $unit_office->UnitOfficeHasField}}}</td>
				                   
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
