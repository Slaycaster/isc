@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Position Maintenance</h1>
</div>


<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Show Rank</strong>
	</div>
		<div class="panel-body">
			<fieldset>
				<div class="row">
                  <div class="col-sm-12 col-md-10  col-md-offset-1 ">
					<table class="table">
						<thead>
							<tr>
								<th>PositionName</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>{{{ $position->PositionName }}}</td>
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
@stop
