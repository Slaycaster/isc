@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Rank Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update a Rank</strong>
	</div>
		<div class="panel-body">
		{{ Form::model($rank, array('method' => 'PATCH', 'route' => array('ranks.update', $rank->id))) }}
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
                        <div>{{ Form::label('RankCode', 'Rank Code:') }}</div>
                        <div style='color:black'>{{ Form::text('RankCode', Input::get('RankCode'), array('placeholder' => 'Rank Code','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('RankName', 'Rank Name:') }}</div>
                        <div style='color:black'>{{ Form::text('RankName', Input::get('RankName'), array('placeholder' => 'Rank Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                        <div>{{ Form::label('Hierarchy', 'Hierarchy (1 being the highest)') }}</div>
                        <div style='color:black'>{{ Form::number('Hierarchy', Input::get('Hierarchy'), array('placeholder' => 'ex: 1, 2, etc.', 'autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Rank', array('class' => 'btn btn-lg btn-success')) }}
                    </div>
                  </div>
                </div>
			</fieldset>
		{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif
</div>
</div>
<a href="#" onclick="window.opener.location.reload(true); window.close();" class="btn btn-warning">Close</a>
@stop
