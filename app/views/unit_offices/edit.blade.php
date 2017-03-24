@extends('layout-noheader')
@section('content')

<div class="label_white">
<h1>Unit Office Maintenance</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong>Update an Unit Office</strong>
	</div>
		<div class="panel-body">
		{{ Form::model($unit_office, array('method' => 'PATCH', 'route' => array('unit_offices.update', $unit_office->id))) }}
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
                              <div>{{ Form::label('UnitOfficeName', 'Unit Office Name:') }}</div>
                          <div style='color:black'>{{ Form::text('UnitOfficeName', Input::get('UnitOfficeName'), array('placeholder' => 'Unit Office Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                        </div>

                        <div class="form-group">
                            <div>{{ Form::label('UnitOfficeHasField', 'Unit Office has Field:') }}</div>

                            <div class='col-md-6'>
                              <div style='color:black'>{{Form::radio('UnitOfficeHasField', 'True', true)}} True</div>
                            </div>
                            
                            <div class='col-md-6'>
                              <div style='color:black'>{{Form::radio('UnitOfficeHasField', 'False', true)}} False</div>
                            </div>
                                
                        </div>

                        <div class="form-group">
                            {{ Form::submit('Update Unit Office', array('class' => 'btn btn-lg btn-success btn-block')) }}
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
