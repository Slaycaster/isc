@extends('layout-noheader2')
@section('content')

<div class="label_white">
<h1>Perspective Maintenance</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Update a Perspective</strong>
  </div>
    <div class="panel-body">
    {{ Form::model($perspective, array('method' => 'PATCH', 'url' => array('unitadminupdateperspective', $perspective->id))) }}
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
                        <div>{{ Form::label('PerspectiveName', 'Perspective Name:') }}</div>
                        <div style='color:black'>{{ Form::text('PerspectiveName', Input::get('PerspectiveName'), array('placeholder' => 'Perspective Name','autocomplete' => 'off', 'class' => 'form-control')) }}</div>
                    </div>

                    <div class="form-group">
                      {{ Form::submit('Update Perspective Name', array('class' => 'btn btn-lg btn-success')) }}
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
