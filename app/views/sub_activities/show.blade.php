@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Sub-activity Maintenance</h1>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Sub-activity</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
				<table class="table">
					<thead>
						<tr>
							<th>Sub-activity Name</th>
							<th>Main Activity</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>{{{ $sub_activity->SubActivityName}}}</td>
							
							@foreach ($main_activities as $main_activity)
                            @if ($main_activity->id == $sub_activity->MainActivityID)
                              <td>{{  $main_activity->MainActivityName }}</td>
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
