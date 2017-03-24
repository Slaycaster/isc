@extends('layout-noheader2')
@section('content')

<div class="label_white">
<h1>Objective Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Objective</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Objective Name</th>
							<th>Perspective</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $objective->ObjectiveName}}}</td>
							
							@foreach ($perspectives as $perspective)
                            @if ($perspective->id == $objective->PerspectiveID)
                              <td>{{  $perspective->PerspectiveName }}</td>
                            @endif
                          	@endforeach
				                   
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
